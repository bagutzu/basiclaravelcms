<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    protected $fillable = ['comment_id', 'author', 'email', 'body', 'is_active', 'photo_id'];

    public function comment(){
        return $this->belongsTo('App\Comment');
    }

    public function photo(){
        return $this->belongsTo('App\Photo');
    }

}
