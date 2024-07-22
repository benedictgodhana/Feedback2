<?php

namespace App\Exports;

use App\Models\Feedback;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeedbackExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Feedback::with(['category', 'subcategory'])->get()->map(function($feedback) {
            return [
                'Category' => $feedback->category ? $feedback->category->name : 'N/A',
                'Subcategory' => $feedback->subcategory ? $feedback->subcategory->name : 'N/A',
                'Name' => $feedback->name,
                'Email' => $feedback->email,
                'Subject' => $feedback->subject,
                'Feedback' => $feedback->feedback,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Category',
            'Subcategory',
            'Name',
            'Email',
            'Subject',
            'Feedback',
        ];
    }
}
