<?php

namespace App\Http\Controllers;

use App\Models\FailedAccess;
use Illuminate\Http\Request;

class FailedAccessController extends Controller
{
    //
    public function index()
    {
        $accesses = FailedAccess::paginate(30);

        return view('admin.failed-access')->with(['logs'=>$accesses]);

    }
}
