<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Posts;
use App\PostCategory;
use App\Libs\LogFile;

class PostController extends Controller
{
    public function create(Request $request)
    {
        
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

            PostCategory::where('post_id', $request->post_id)->whereNotIn('category_id', jsons_decode($request->category))->delete();
            
            LogFile::writeLog('updatePost', json_encode($request->all()));
            Posts::where('post_id', $request->post_id)
            ->update(['content' => $request->content, 
            'title' => $request->title, 
            'thumbnail' => $request->thumbnail, 
            'post_type' => $request->post_type, 
            'post_status' => $request->post_status, 
            'post_slug' => $request->post_slug,
            'category' => $request->category,
            'menu_order' => $request->menu_order
            ]);
            return $this->successResponse([], "Update post successfully");

        }
        LogFile::writeLog('createPost', json_encode($request->all()));
        $post = new Posts;
        $post->post_id = $request->post_id; // wordpress post id
        $post->author_id = $request->author_id;
        $post->content = $request->content;
        $post->title = $request->title;
        $post->thumbnail = $request->thumbnail;
        $post->post_type = $request->post_type; // wordpress post type
        $post->post_status = $request->post_status;
        $post->post_slug = $request->post_slug;
        $post->category = $request->category;
        $post->menu_order = $request->menu_order;
        $post->save();

        foreach (json_decode($request->category) as $value) {
            $post_relationship = new PostCategory;
            $post_relationship->category_id = $value;
            $post_relationship->post_id = $request->post_id;
            $post_relationship->save();
        }
        
        return $this->successResponse([], "Create post successfully");
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|numeric',
            'post_status' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse(self::ERROR_BAD_REQUEST, [], self::getErrorMessage(self::ERROR_BAD_REQUEST));
        }
        LogFile::writeLog('updatePostStatus', json_encode($request->all()));
        Posts::where('post_id', $request->post_id)
        ->update(['post_status' => $request->post_status]);

        return $this->successResponse([], "Update post successfully");
    }
    
    public function read(Request $request) {
        if (isset($request->post_slug)) {
            $post = Posts::where('post_slug', $request->post_slug)->first();
        } else {
            $post = Posts::all();
        }
        
        return $this->successResponse(['post' => $post], "Get post successfully");
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse(self::ERROR_BAD_REQUEST, [], self::getErrorMessage(self::ERROR_BAD_REQUEST));
        }
        LogFile::writeLog('deletePost', json_encode($request->all()));
        Posts::where('post_id', $request->post_id)->delete();

        return $this->successResponse([], "Delete post successfully");
    }

    public function getProduct()
    {
        $products = Posts::where('post_type', 'product')->get();
        return $this->successResponse($products, 'get all products successfully');
    }
}
