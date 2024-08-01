<?php
namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackSubcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use TCPDF; // Import TCPDF directly
use App\Exports\FeedbackExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\FeedbackReceived;
use App\Mail\FeedbackNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
class FeedbackController extends Controller
{
    public function index()
    {
        // Calculate feedback counts
        $todaysFeedback = Feedback::whereDate('created_at', Carbon::today())->count();
        $weeksFeedback = Feedback::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $monthlyFeedback = Feedback::whereMonth('created_at', Carbon::now()->month)->count();

        // Dump the feedback counts
        dd([
            'todaysFeedback' => $todaysFeedback,
            'weeksFeedback' => $weeksFeedback,
            'monthlyFeedback' => $monthlyFeedback,
        ]);

        // Return data using Inertia
        return Inertia::render('Admin/AdminIndex', [
            'todaysFeedback' => $todaysFeedback,
            'weeksFeedback' => $weeksFeedback,
            'monthlyFeedback' => $monthlyFeedback,
        ]);
    }
    public function show($categoryId)
    {
        // Fetch the category by ID
        $category = FeedbackCategory::findOrFail($categoryId);

        // Fetch the feedbacks associated with the category, including subcategory information
        $feedbacks = Feedback::with('subcategory')->where('category_id', $categoryId)->get();

        // Fetch the subcategories associated with the category
        $subcategories = FeedbackSubcategory::where('feedback_category_id', $categoryId)->get();

        $categories = FeedbackCategory::with('subcategories')->get();


        $categoriesData = $categories->map(function ($category) {
            return [
                'name' => $category->name,
                'feedback_count' => $category->feedbacks_count,
                'icon' => $category->icon ?? 'mdi-comment', // Provide default icon if not set
                'url' => route('category.feedback', ['categoryId' => $category->id]), // Use 'categoryId' here
            ];
        });

        return Inertia::render('Feedback/Category', [
            'category' => $category,
            'feedbacks' => $feedbacks,
            'subcategories' => $subcategories,
            'categories' => $categoriesData,

        ]);
    }


    public function AllFeedback(Request $request)
    {
        // Fetch feedbacks with related category and subcategory
        $feedbacks = Feedback::with(['category', 'subcategory'])
        ->where('hidden', false)  // Filter out hidden feedback
        ->get();

        // Fetch all categories with their subcategories
        $categories = FeedbackCategory::with('subcategories')->get();

        $categoriesData = $categories->map(function ($category) {
            return [
                'name' => $category->name,
                'feedback_count' => $category->feedbacks_count,
                'icon' => $category->icon ?? 'mdi-comment', // Provide default icon if not set
                'url' => route('category.feedback', ['categoryId' => $category->id]), // Use 'categoryId' here
            ];
        });

        return Inertia::render('Admin/AllFeedback', [
            'feedbacks' => $feedbacks,
            'feedbackcategories' => $categories,
            'categories' => $categoriesData,


        ]);
    }
    public function print(Request $request)
{
    // Fetch feedback data (adjust this query based on your requirements)
    $feedbacks = Feedback::all(); // Or any other query to get feedback data

    // Initialize TCPDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    // Add content to the PDF (adjust the view name and data as needed)
    $html = view('pdf.feedbacks', ['feedbacks' => $feedbacks])->render();
    $pdf->writeHTML($html);

    // Output the PDF to the browser for printing
    return response()->stream(
        function () use ($pdf) {
            $pdf->Output('feedbacks.pdf', 'I'); // 'I' for inline display
        },
        'application/pdf',
        [
            'Content-Disposition' => 'inline; filename="feedbacks.pdf"'
        ]
    );
}

public function export()
    {
        return Excel::download(new FeedbackExport, 'feedbacks.xlsx');
    }

    public function giveFeedbackPage()
    {
        $categories = FeedbackCategory::with('subcategories')->get();
        return Inertia::render('Feedback/GiveFeedback', [
            'categories' => $categories,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'subject' => 'required|string',
            'subcategory_id' => 'nullable|integer',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'feedback' => 'required|string',
        ]);

        try {
            // Store feedback in the database
            $feedback = Feedback::create($request->all());

            // Retrieve category and subcategory names
            $categoryName = FeedbackCategory::find($request->category_id)->name;
            $subcategoryName = $request->subcategory_id ? FeedbackSubcategory::find($request->subcategory_id)->name : 'No Subcategory';

            // Prepare feedback data with category and subcategory names
            $feedbackData = $request->all();
            $feedbackData['category_name'] = $categoryName;
            $feedbackData['subcategory_name'] = $subcategoryName;

            // Send email to the user if email is provided
            if ($request->filled('email')) {
                Mail::to($request->email)
                    ->send(new FeedbackReceived($feedbackData));
            }

            // Send email to admin
            Mail::to('benedict.dhadho@strathmore.edu')
                ->send(new FeedbackNotification($feedbackData));

            // Create a notification record
            DB::table('notifications')->insert([
                'title' => 'New Feedback Received',
                'message' => 'A new feedback has been submitted. Please review it.',
                'feedback_id' => $feedback->id,
                'created_at' => now(),
                'updated_at' => now(),
                'read' => false,
            ]);

            // Redirect with success message
            return redirect()->route('feedback')->with('successMessage', 'Feedback submitted successfully!');
        } catch (\Exception $e) {
            // Handle any exceptions and redirect with an error message
            return redirect()->route('feedback')->with('errorMessage', $e->getMessage() ?? 'An error occurred while submitting feedback.');
        }
    }



    public function reply($id, Request $request)
{
    // Validate the request input
    $request->validate([
        'email' => 'required|email',
        'message' => 'required|string',
    ]);

    // Extract input data
    $email = $request->input('email');
    $message = $request->input('message');

    // Send the email
    Mail::raw($message, function ($mail) use ($email) {
        $mail->to($email)
             ->subject('Reply to Your Feedback');
    });

    // Return a success response
    return response()->json([
        'status' => 'success',
        'message' => 'Reply sent successfully.',
    ], 200); // OK
}
public function update(Request $request, $id)
{
    // Find the feedback by ID
    $feedback = Feedback::find($id);

    // Check if the feedback exists
    if (!$feedback) {
        return redirect()->back()->with('error', 'Feedback not found');
    }

    // Validate the request
    $request->validate([
        'status' => 'required|string'
    ]);

    // Update the feedback status
    $feedback->status = $request->status;
    $feedback->save();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Feedback status updated successfully');
}
public function archive($id)
{
    $feedback = Feedback::find($id);

    if ($feedback) {
        $feedback->hidden = true; // Assuming you have an 'archived' column
        $feedback->save();
        return response()->json(['message' => 'Feedback archived successfully.']);
    }

    return response()->json(['message' => 'Feedback not found.'], 404);
}

}
