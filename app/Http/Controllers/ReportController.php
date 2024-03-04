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
        // Determine start and end dates based on month and year
        if ($month) {
            $startDate = "$year-$month-01";
            $endDate = date('Y-m-t', strtotime($startDate)); // Get last day of the month
        } else {
            $startDate = "$year-01-01";
            $endDate = "$year-12-31";
        }

        // Fetch posts based on start and end dates
        $posts = Post::whereBetween('published_at', [$startDate, $endDate])->get();

        // Determine the event label based on the count of posts
        $eventLabel = $posts->count() > 1 ? 'Events' : 'Event';

        // Initialize DOMpdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $options->set('isPhpEnabled', true);

        // HTML content for the PDF
        if ($month) {
            $html = '<div style="text-align:center"><h1>' . $eventLabel . ' for ' . date('F Y', strtotime($startDate)) . '</h1></div>' . '<br>';
        } else {
            $html = '<div style="text-align:center"><h1>' . $eventLabel . ' for Year ' . $year . '</h1></div>' . '<br>';
        }
        
        $html .= '<hr>';

        foreach ($posts as $post) {
            $html .= '<h4><strong>Event Name: &nbsp; </strong>' . $post->title . '</h4>';
            $html .= '<p><strong>Event Type:</strong> ' . $post->event_type . '</p>';
            $html .= '<p><strong>Date:</strong> ' . $post->published_at->format('F d, Y') . '</p>';
            $html .= '<p><strong>No. of Participants:</strong> ' . $post->number_of_participants . '</p>';

            // Description of the event
            $html .= '<p><strong></strong> ' . $post->body . '</p>';

            $html .= '<hr>'; // Add a horizontal line between posts
        }

        // Load HTML content into DOMpdf
        $dompdf->loadHtml($html);

        // Render the PDF
        $dompdf->render();

        // Output the generated PDF (inline or download)
        $dompdf->stream('TBI-Report.pdf', ['Attachment' => 0]);
    }
}