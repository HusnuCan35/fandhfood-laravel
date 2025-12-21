<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Increment helpful count for a comment.
     */
    public function like(Comment $comment)
    {
        $comment->incrementHelpful();

        return response()->json([
            'success' => true,
            'helpful' => $comment->helpful,
        ]);
    }

    /**
     * Increment not helpful count for a comment.
     */
    public function dislike(Comment $comment)
    {
        $comment->incrementNotHelpful();

        return response()->json([
            'success' => true,
            'not_helpful' => $comment->not_helpful,
        ]);
    }
}
