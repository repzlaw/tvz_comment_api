<?php

namespace App\Http\Controllers;

use App\Models\NewsComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Requests\GetCommentRequest;
use App\Http\Requests\StoreUpvoteRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Services\Users\Comments\CommentService;
use App\Http\Requests\StoreNewsCommentReplyRequest;
use App\Models\NewsCommentUpvote;

class CommentsController extends Controller
{
    protected $CommentService;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(CommentService $CommentService)
    {
        $this->CommentService = $CommentService;
    }


    //get comments based on specified parameters
    public function getComments(GetCommentRequest $request)
    {
        $id = $request->get('c');
        $category = $request->get('cat');
        $language = $request->get('lang');
        $orderColumn = 'created_at';
        $ordertype = 'desc';
        $order = $request->get('orderby');
        if ($order === 'oldest') {
            $ordertype = 'asc';
        }elseif ($order === 'upvote') {
            $orderColumn = 'numRecommends';
        }
        $page = 50;
        if ($request->has('pages')) {
            $page = $page * $request->get('pages');
        }
        
        //get language specified
        $lang= '';
        if ($language == 'en-US' || $language == 'en-us') {
            $lang = 'English';
        }elseif ($language === 'pt') {
            $lang = 'Portuguese';
        }elseif ($language === 'es') {
            $lang = 'Spanish';
        }elseif ($language === 'ru') {
            $lang = 'Russian';
        }

        //get comments based on category specified
        if ($lang) {
            if ($category === 'news') {
                $comments = $this->CommentService->newsComments($id, $lang, $orderColumn, $ordertype, $language, $page);
                return $comments;
            } elseif ($category === 'players') {
                $comments = $this->CommentService->playerComments($id, $lang, $orderColumn, $ordertype, $language, $page);
                return $comments;
            } elseif ($category === 'teams') {
                $comments = $this->CommentService->teamComments($id, $lang, $orderColumn, $ordertype, $language, $page);
                return $comments;
            } elseif ($category === 'matches') {
                $comments = $this->CommentService->matchComments($id, $lang, $orderColumn, $ordertype, $language, $page);
                return $comments;
            }
        }
    }
    
    //store comment
    public function storeNewsComment(StoreCommentRequest $request)
    {
        // return($request->all());
       $post = new NewsComment;

       $post->uuid = $request->uuid;
       $post->parent_comment_id = null;
       $post->competition_news_id = $request->competition_news_id;
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

    //save users comments replies 
    public function storeNewsReply(StoreNewsCommentReplyRequest $request)
    {
        // dd($request->all());
        $post = new NewsComment;

        $post->uuid = $request->uuid;
        $post->parent_comment_id = $request->parent_comment_id;;
        $post->competition_news_id = $request->competition_news_id;
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

    //check if user upvoted a comment
    public function checkUpvote(StoreUpvoteRequest $request)
    {
        $mod = $request->get('cat');
        $comment_id = $request->get('comment_id');
        $user_id = Auth::id();
        
        $check = checkUpvoted($mod, $comment_id, $user_id);

        return $check->getData()->status;
    }

    //upvote or remove upvote
    public function upvoteComment(StoreUpvoteRequest $request)
    {
      
        $mod = $request->get('mod');
        $comment_uuid = $request->get('comment_uuid');
        $user_id = $request->get('user_id');

        $model =  getCommentModel($mod);
        $model = $model->getData();

        $comment = $model->parentModel::where('uuid',$comment_uuid)->firstOrFail();
        $comment_id = $comment->id;

        $check = checkUpvoted($mod, $comment_id, $user_id);
        $check = $check->getData();

        if ($check->status) {
            $upvote = $check->model::where(['user_id'=>$user_id, 'comment_id'=>$comment_id])->delete();

            //update numrecord column 
            $num = $check->parentModel::findOrFail($comment_id);
            $numrecord = $num->decrement('numRecommends');

            // $numRecommends =$num->numRecommends - 1;
            // $numrecord = $num->update([
            //     'numRecommends'=> $numRecommends,
            // ]);
            return response()->json(['status'=>false, 'numRecommends'=>$num->numRecommends, "result" => "ok"]);
        }else {
            
            // $upvote = $check->model::firstOrNew([
            //     'user_id'=>$user_id,
            //     'comment_id'=>$comment_id,
            // ]);
            $upvote = new $check->model();
            $upvote->user_id= $user_id;
            $upvote->comment_id= $comment_id;
            $upvote->save();

            //update numrecord column 
            $num = $check->parentModel::findOrFail($comment_id);
            $numrecord = $num->increment('numRecommends');
            // $numRecommends =$num->numRecommends + 1;

            // $numrecord = $num->update([
            //     'numRecommends'=> $numRecommends,
            // ]);

            return response()->json(['status'=>true, 'numRecommends'=>$num->numRecommends, "result" => "ok"]);
        }
    }

    //get single user comment
    public function getUserComment(GetIndividualCommentRequest $request)
    {
        $model ='';
        $mod = $request->get('cat');
        $id = Auth::id();

        if ($mod === 'news') {
            $model = 'App\Models\NewsComment';
        } else if($mod === 'player') {
            $model = 'App\Models\PlayerComment';
        } else if($mod === 'team') {
            $model = 'App\Models\TeamComment';
        } else if($mod === 'match') {
            $model = 'App\Models\MatchComment';
        }

        if ($model) {
            $comments = $model::where('user_id',$id)->latest()->get();
            return view('userProfile/user-comments')->with(['type'=>$mod,'comments'=>$comments]);
        }
        
    }
    public function index()
    {
        $r = NewsComment::all();
        // $comment = new CommentResource($r);
        $comments = CommentResource::collection($r); 
        return response()->json(['comments'=>$comments, 'status'=>'success'],200);
    }


}
// content-type:application/json
// type