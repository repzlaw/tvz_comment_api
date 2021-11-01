<?php

// use DateTime;
use App\Models\Team;
use App\Models\Friend;
use App\Models\Player;
use App\Models\TeamFollower;
use App\Models\PlayerFollower;
use App\Models\CompetitionFollower;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

//process image function
function process_image($image)
{
    // Get filename with the extension
    $filenameWithExt = $image->getClientOriginalName();
    //get file name with the extension
    $filename = Hash::make(pathinfo($filenameWithExt, PATHINFO_FILENAME));
    //get just extension
    $extension = $image->getClientOriginalExtension();
    
    //filename to store
    $fileNameToStore = $filename.'_'.time().'.'.$extension;

    return $fileNameToStore;
}

//func to get browser information
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

//get parent model
function getCommentModel($mod)
{
    $model = '';
    $parentModel = '';

    if ($mod === 'news') {
        $model = 'App\Models\NewsCommentUpvote';
        $parentModel = 'App\Models\NewsComment';
    } else if($mod === 'player') {
        $model = 'App\Models\PlayerCommentUpvote';
        $parentModel = 'App\Models\PlayerComment';
    } else if($mod === 'team') {
        $model = 'App\Models\TeamCommentUpvote';
        $parentModel = 'App\Models\TeamComment';
    } else if($mod === 'match') {
        $model = 'App\Models\MatchCommentUpvote';
        $parentModel = 'App\Models\MatchComment';
    }
    if ($model) {
        return response()->json(['model'=>$model, 'parentModel'=>$parentModel]);
    }
    return abort(404,"Page not found");

}

//func to check if a user has upvoted a comment
function checkUpvoted($mod, $comment_id, $user_id){
    // if (Auth::check()) {
        $model = '';
        $parentModel = '';

        if ($mod === 'news') {
            $model = 'App\Models\NewsCommentUpvote';
            $parentModel = 'App\Models\NewsComment';
        } else if($mod === 'player') {
            $model = 'App\Models\PlayerCommentUpvote';
            $parentModel = 'App\Models\PlayerComment';
        } else if($mod === 'team') {
            $model = 'App\Models\TeamCommentUpvote';
            $parentModel = 'App\Models\TeamComment';
        } else if($mod === 'match') {
            $model = 'App\Models\MatchCommentUpvote';
            $parentModel = 'App\Models\MatchComment';
        }

        if ($model) {
            $upvote = $model::where(['user_id'=>$user_id, 'comment_id'=>$comment_id])->first();
            $status = $upvote ? true : false;

            return response()->json(['status'=>$status, 'upvote'=>$upvote, 'model'=>$model, 'parentModel'=>$parentModel]);
        }
    // }
    return response()->json(['status'=>false]);
}
