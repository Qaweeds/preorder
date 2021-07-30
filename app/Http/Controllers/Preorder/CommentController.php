<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Preorder\Comments;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __invoke(CommentRequest $request)
    {
        $comment = new Comments();
        $comment->user_id = Auth::user()->id;
        $comment->product_id = $request->item;
        $comment->comment = $request->comment;
        $comment->save();
    }
}
