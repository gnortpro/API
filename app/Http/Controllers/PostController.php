<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Posts;
use App\Libs\LogFile;
class PostController extends Controller
{
    public function create(Request $request) {
        LogFile::writeLog('creatPost',json_encode($request->all()));
        $validator = Validator::make($request->all(), [
            'author_id' => 'required|numeric',
            'content' => 'required',
            'title' => 'required'
        ]);
        if($validator->fails()){
            return $this->errorResponse(self::ERROR_BAD_REQUEST, [], self::getErrorMessage(self::ERROR_BAD_REQUEST));            
        } 
        $post = new Posts;
        $post->author_id = $request->author_id;
        $post->content = $request->content;
        $post->title = $request->title;
        $post->thumbnail = $request->thumbnail;
        $post->save();
        
        return $this->successResponse([], "Create post successfully");  
    }
}
