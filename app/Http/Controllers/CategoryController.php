<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Category;
use App\Libs\LogFile;


class CategoryController extends Controller
{
    public function create(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            'category_name' => 'required|string',
            'category_slug' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse(self::ERROR_BAD_REQUEST, [], self::getErrorMessage(self::ERROR_BAD_REQUEST));
        }
        if (Category::where('category_id', $request->category_id)->exists()) {
            LogFile::writeLog('updateCategory', json_encode($request->all()));
            Posts::where('category_id', $request->category_id)
            ->update([
            'name' => $request->category_name, 
            'slug' => $request->category_slug, 
            ]);
            return $this->successResponse([], "Update category successfully");

        }
        LogFile::writeLog('createCategory', json_encode($request->all()));
        $cate = new Category;
        $cate->category_id = $request->category_id; // wordpress post id
        $cate->name = $request->category_name;
        $cate->slug = $request->category_slug;
        $cate->save();

        return $this->successResponse([], "Create category successfully");
    }
}
