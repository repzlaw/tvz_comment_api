<?php

namespace App\Http\Controllers\Comments;

use App\Models\NewsComment;
use App\Models\TeamComment;
use Illuminate\Http\Request;
use App\Models\PlayerComment;
use App\Models\ReportedNewsComment;
use App\Models\ReportedTeamComment;
use App\Http\Controllers\Controller;
use App\Models\ReportedPlayerComment;
use App\Http\Requests\ReportCommentRequest;

class ReportCommentController extends Controller
{
    //report news comment
    public function reportNewsComment(ReportCommentRequest $request)
    {
        // return($request->all());
        $post = new ReportedNewsComment;

        $post->policy_id = $request->policy_id;
        $post->user_notes = $request->user_notes;
        $post->comment_id = $request->comment_id;
        $post->user_id = $request->user_id;
        $post->save();

        if($post){
            $posts = NewsComment::findOrFail($request->comment_id);
            $posts->status = 'reported';
            $posts->save();
            if ($posts) {
                return response()->json(["result" => "ok",'competition_news_id'=>$posts->competition_news_id], 200);
            }
        }

        return response()->json(["result" => "failed"], 400);
    }

    //report team comment
    public function reportTeamComment(ReportCommentRequest $request)
    {
        // return($request->all());
        $post = new ReportedTeamComment;

        $post->policy_id = $request->policy_id;
        $post->user_notes = $request->user_notes;
        $post->comment_id = $request->comment_id;
        $post->user_id = $request->user_id;
        $post->save();

        if($post){
            $posts = TeamComment::findOrFail($request->comment_id);
            $posts->status = 'reported';
            $posts->save();
            if ($posts) {
                return response()->json(["result" => "ok",'team_id'=>$posts->team_id], 200);
            }
        }

        return response()->json(["result" => "failed"], 400);
    }

    //report player comment
    public function reportPlayerComment(ReportCommentRequest $request)
    {
        $post = new ReportedPlayerComment;

        $post->policy_id = $request->policy_id;
        $post->user_notes = $request->user_notes;
        $post->comment_id = $request->comment_id;
        $post->user_id = $request->user_id;
        $post->save();

        if($post){
            $posts = PlayerComment::findOrFail($request->comment_id);
            $posts->status = 'reported';
            $posts->save();
            if ($posts) {
                return response()->json(["result" => "ok",'player_id'=>$posts->player_id], 200);
            }
        }

        return response()->json(["result" => "failed"], 400);
    }
}
