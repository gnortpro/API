<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Posts;
use App\Libs\LogFile;

class PostController extends Controller
{
    public function create(Request $request)
    {
        LogFile::writeLog('creatPost', json_encode($request->all()));
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|numeric',
            'author_id' => 'required|numeric',
            'title' => 'string|required',
            'post_type' => 'string|required',
            'post_slug' => 'string|required',
            'post_status' => 'string|required'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse(self::ERROR_BAD_REQUEST, [], self::getErrorMessage(self::ERROR_BAD_REQUEST));
        }
        if (Posts::where('post_id', $request->post_id)->exists()) {
            Posts::where('post_id', $request->post_id)
            ->update(['content' => $request->content, 
            'title' => $request->title, 
            'thumbnail' => $request->thumbnail, 
            'post_type' => $request->post_type, 
            'post_status' => $request->post_status, 
            'post_slug' => $request->post_slug,
            'menu_order' => $request->menu_order
            ]);
            return $this->successResponse([], "Update post successfully");

        }

        $post = new Posts;
        $post->post_id = $request->post_id; // wordpress post id
        $post->author_id = $request->author_id;
        $post->content = $request->content;
        $post->title = $request->title;
        $post->thumbnail = $request->thumbnail;
        $post->post_type = $request->post_type; // wordpress post type
        $post->post_status = $request->post_status;
        $post->post_slug = $request->post_slug;
        $post->menu_order = $request->menu_order;
        $post->save();

        return $this->successResponse([], "Create post successfully");
    }

    public function getProduct()
    {
        $products = Posts::where('post_type', 'product')->get();
        return $this->successResponse($products, 'get all products successfully');
    }
}
