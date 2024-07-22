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

        return Inertia::render('Feedback/Category', [
            'category' => $category,
            'feedbacks' => $feedbacks,
            'subcategories' => $subcategories
        ]);
    }


    public function AllFeedback(Request $request)
    {
        // Fetch feedbacks with related category and subcategory
        $feedbacks = Feedback::with(['category', 'subcategory'])->get();

        // Fetch all categories with their subcategories
        $categories = FeedbackCategory::with('subcategories')->get();

        return Inertia::render('Admin/AllFeedback', [
            'feedbacks' => $feedbacks,
            'categories' => $categories,
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


    public function GivefeedbackPage()
    {
        return Inertia::render('Feedback/GiveFeedback');
    }

}
