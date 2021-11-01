<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;
use App\Models\ReportedNewsComment;
use App\Models\ReportedTeamComment;
use App\Models\ReportedPlayerComment;

class ReportedController extends Controller
{
    public function getNewsComment()
    { 
        $posts = ReportedNewsComment::with('comment')->get();

        return response()->json(['posts'=>$posts]);
    }

    public function getPlayersComment()
    {
        $posts = ReportedPlayerComment::with('comment')->get();

        return response()->json(['posts'=>$posts]);
    }

    public function getTeamsComment()
    {
        $posts = ReportedTeamComment::with('comment')->get();

        return response()->json(['posts'=>$posts]);
    }
}
