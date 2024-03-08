<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generatePdfReport($year, $month = null)
    {
        // Validate input
        if (!is_numeric($year) || ($month && (!is_numeric($month) || $month < 1 || $month > 12))) {
            return response('Invalid input.', 400);
        }

        // Determine start and end dates based on month and year
        if ($month) {
            $startDate = "$year-$month-01";
            $endDate = date('Y-m-t', strtotime($startDate)); // Get last day of the month
        } else {
            $startDate = "$year-01-01";
            $endDate = "$year-12-31";
        }

        // Fetch posts based on start and end dates
        $posts = Post::whereBetween('published_at', [$startDate, $endDate])
            ->orderBy('published_at', 'asc')
            ->get();

        // Determine the event label based on the count of posts
        $eventLabel = $posts->count() > 1 ? 'Events' : 'Event';

        // Check if there are no events
        if ($posts->isEmpty()) {
            $monthName = $month ? date('F', mktime(0, 0, 0, $month, 10)) : null; // Convert month number to month name
            $message = $monthName ? "No events for $monthName $year" : "No events for $year";
            return response($message, 204);
        }

        try {
            // Initialize DOMpdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $dompdf = new Dompdf($options);
            $options->set('isPhpEnabled', true);

            // Determine the date label
            $dateLabel = $month ? date('F Y', strtotime($startDate)) : "Year $year";

            // HTML content for the PDF
            $html = view('generateReport.pdf', compact('eventLabel', 'dateLabel', 'posts'))->render();

            // Load HTML content into DOMpdf
            $dompdf->loadHtml($html);

            // Render the PDF
            $dompdf->render();

            // Output the generated PDF (inline or download)
            $dompdf->stream('TBI-Report.pdf', ['Attachment' => 0]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during PDF generation
            return response('Error generating PDF.', 500);
        }
    }
}
