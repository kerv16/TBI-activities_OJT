<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{    public function index()
    {
        $categories = Category::whereHas('posts', function ($query) {
            $query->published();
        })->take(100)->get();

        return view(
            'posts.index',
            [
                'categories' => $categories
            ]
        );
    }

    public function show(Post $post)
    {
        return view(
            'posts.show',
            [
                'post' => $post
            ]
        );
    }

    public function report(Post $post)
    {
        return view(
            'posts.report',
            [
                'post' => $post
            ]
        );
    }
}
