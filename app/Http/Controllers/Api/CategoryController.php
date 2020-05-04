<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Http\Resources\CategoryResource;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        $data = Category::insert([
            'name'  =>  $request->name,
            'description'   =>  $request->description,
            'created_at' => Carbon::now('GMT+7'),
            'updated_at' =>  Carbon::now('GMT+7')
        ]);

        if ($data == 1) {
            return response()->json(['success' => true, 'message' => 'New Data Added.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed.']);
        }
    }

    public function update(Request $request)
    {
        $data = Category::where('id', '=', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        if ($data == 1) :
            return response()->json(['success' => true, 'message' => 'Updated successfully.']);
        else :
            return response()->json(['success' => false, 'message' => 'Failed.']);
        endif;
    }

    public function show(Category $category, $id)
    {
        return Category::find($id);
    }

    public function destroy(Request $request)
    {
        $data = Category::where('id', '=', $request->id)->delete();
        if ($data == 1) :
            return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
        else :
            return response()->json(['success' => false, 'message' => 'Delete failed.']);
        endif;
    }
}
