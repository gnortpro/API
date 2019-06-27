<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\LogFile;

class TestController extends Controller
{
    public function index(Request $request) {
        LogFile::writeLog('Log For Testing',json_encode($request->all()));
    }
}
