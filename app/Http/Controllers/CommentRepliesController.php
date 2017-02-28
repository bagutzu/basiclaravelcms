<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommentRepliesController extends Controller
{
    public function store(Request $request){

    }

    public function createReply(Request $request){
        $user = Auth::user();

        $data = [
            'comment_id' => $request->comment_id,
            'author' => $user->name,
            'email' => $user->email,
            'photo_id' => $user->photo->id,
            'body' => $request->body,
        ];

        CommentReply::create($data);

        Session::flash('reply_message', 'Your reply has been submitted and is awaiting moderation');

        return redirect()->back();
    }

    public function show($id){
        $comment = Comment::findOrFail($id);
        $replies = $comment->replies;
        return view('admin.comments.replies.show', compact('replies'));

    }

    public function update(Request $request, $id){
        CommentReply::findOrFail($id)->update($request->all());
        return redirect()->back();
    }

    public function destroy($id){
        CommentReply::findOrFail($id)->delete();
        return redirect()->back();
    }
}
