<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{

    // Save new comment
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'content' => 'required|max:160',
        ]);

        $comment = new Comment;
        $comment->article_id = $articleId;
        $comment->user_id = Auth::id();
        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->route('articles.show', $articleId)->with('success', 'Comment added successfully!');
    }

}
