<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostObserver
{
    public function deleting(Post $post)
    {
        // Retrieve the image path from the post
        $imagePath = $post->images;

        // Check if the file exists and delete it
        if ($imagePath && Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    }

}
