<?php
namespace App\Services\Users\Comments;

use App\Models\NewsComment;
use App\Models\TeamComment;
use App\Models\MatchComment;
use App\Models\PlayerComment;

class CommentService
{
    //get news comments
    public function newsComments($id, $lang, $orderColumn, $ordertype, $language, $page){
        $comments = NewsComment::where(['competition_news_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang, 'status'=>'visible'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','uuid','competition_news_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at',
                                                    'numRecommends')
                                            ->simplePaginate($page);
        $replies = NewsComment::where(['competition_news_id'=>$id, ['parent_comment_id', '!=', null], 'language'=>$lang, 'status'=>'visible'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','uuid','competition_news_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at',
                                                    'numRecommends')
                                            ->get();
        foreach ($comments as $key => $com) {
            $reply = [];
            foreach ($replies as $key => $rep) {
                if ($com->id === $rep->parent_comment_id) {
                    array_push($reply, $rep);
                }
            }
            $com->reply = $reply;
        }

        $summary = (object) ['lang_iso'=>$language, 'language'=>$lang];

        return response()->json(['summary'=>$summary,'comments'=> $comments]);
    }

    //get players comments
    public function playerComments($id, $lang, $orderColumn, $ordertype, $language, $page)
    {
        $comments = PlayerComment::where(['player_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang, 'status'=>'visible'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','uuid','player_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at',
                                                    'numRecommends')
                                            ->simplePaginate($page);

        $replies = PlayerComment::where(['player_id'=>$id, ['parent_comment_id', '!=', null], 'language'=>$lang, 'status'=>'visible'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','uuid','player_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at','numRecommends',)
                                            ->get();

        foreach ($comments as $key => $com) {
            $reply = [];
            foreach ($replies as $key => $rep) {
                if ($com->id === $rep->parent_comment_id) {
                    array_push($reply, $rep);
                }
            }
            $com->reply = $reply;
        }                                   

        $summary = (object) ['lang_iso'=>$language, 'language'=>$lang];

        return response()->json(['summary'=>$summary,'comments'=> $comments]);
    }

    //get players comments
    public function teamComments($id, $lang, $orderColumn, $ordertype, $language, $page)
    {
        $comments = TeamComment::where(['team_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang, 'status'=>'visible'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','uuid','team_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at',
                                                    'numRecommends')
                                            ->simplePaginate($page);

        $replies = TeamComment::where(['team_id'=>$id, ['parent_comment_id', '!=', null], 'language'=>$lang, 'status'=>'visible'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','uuid','team_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at','numRecommends',)
                                            ->get();

        foreach ($comments as $key => $com) {
            $reply = [];
            foreach ($replies as $key => $rep) {
                if ($com->id === $rep->parent_comment_id) {
                    array_push($reply, $rep);
                }
            }
            $com->reply = $reply;
        }  

        $summary = (object) ['lang_iso'=>$language, 'language'=>$lang];

        return response()->json(['summary'=>$summary,'comments'=> $comments]);
    }

    //get players comments
    public function matchComments($id, $lang, $orderColumn, $ordertype, $language, $page)
    {
        $comments = MatchComment::where(['match_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang, 'status'=>'visible'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','uuid','match_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at',
                                                    'numRecommends')
                                            ->simplePaginate($page);

        $replies = MatchComment::where(['match_id'=>$id, ['parent_comment_id', '!=', null], 'language'=>$lang, 'status'=>'visible'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','uuid','match_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at',
                                                    'numRecommends')
                                            ->get();

        foreach ($comments as $key => $com) {
            $reply = [];
            foreach ($replies as $key => $rep) {
                if ($com->id === $rep->parent_comment_id) {
                    array_push($reply, $rep);
                }
            }
            $com->reply = $reply;
        } 
         
        $summary = (object) ['lang_iso'=>$language, 'language'=>$lang];

        return response()->json(['summary'=>$summary,'comments'=> $comments]);
    }

}