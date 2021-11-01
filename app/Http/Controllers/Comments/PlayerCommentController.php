<?php

namespace App\Http\Controllers\Comments;

use Illuminate\Http\Request;
use App\Models\PlayerComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsCommentRequest;
use App\Http\Requests\StorePlayerCommentRequest;
use App\Http\Requests\StorePlayerCommentReplyRequest;

class PlayerCommentController extends Controller
{
    //store comment
    public function storePlayerComment(StorePlayerCommentRequest $request)
    {
        // return($request->all());
       $post = new PlayerComment();

       $post->uuid = $request->uuid;
       $post->player_id = $request->player_id;
       $post->content = $request->content;
       $post->language= $request->language;
       $post->user_id= $request->user_id;
       $post->username= $request->username;
       $post->display_name= $request->display_name;
       $post->profile_pic= $request->profile_pic;
       $post->parent_comment_id = null;
       $post->status= 'visible';
       $post->numRecommends= 0;

       $post->save();
        if ($post) {
            return response()->json(["result" => "ok"], 200);
        }else {
            return response()->json(["result" => "failed"], 400);
        }

    }

    //save users comments replies 
    public function storePlayerReply(StorePlayerCommentReplyRequest $request)
    {
        // dd($request->all());
        $post = new PlayerComment;

        $post->uuid = $request->uuid;
        $post->parent_comment_id = $request->parent_comment_id;;
        $post->player_id = $request->player_id;
        $post->content = $request->content;
        $post->language= $request->language;
        $post->user_id= $request->user_id;
        $post->username= $request->username;
        $post->display_name= $request->display_name;
        $post->profile_pic= $request->profile_pic;
        $post->status= 'visible';
        $post->numRecommends= 0;
        $post->save();
        
        if ($post) {
            return response()->json(["result" => "ok"], 200);
        }else {
            return response()->json(["result" => "failed"], 400);
        }
    }
}
