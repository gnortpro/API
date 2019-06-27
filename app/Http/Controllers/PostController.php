<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Posts;
class PostController extends Controller
{
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'author_id' => 'required|numeric',
            'content' => 'required'
        ]);
        if($validator->fails()){
            return $this->errorResponse(self::ERROR_BAD_REQUEST, [], self::getErrorMessage(self::ERROR_BAD_REQUEST));            
        } 
        $post = new Posts;
        $post->author_id = $request->author_id;
        $post->content = $request->content;
 
        $post->save();
        return $this->successResponse([], "Create post successfully");  
    }
}
