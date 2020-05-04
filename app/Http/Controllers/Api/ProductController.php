<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Http\Resources\ProductResource;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        $data = Product::insert([
            'name'  =>  $request->name,
            'description'   =>  $request->description,
            'price' =>  $request->price,
            'user_id' => Auth::user()->id,
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
        $data = Product::where('id', '=', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        if ($data == 1) :
            return response()->json(['success' => true, 'message' => 'Updated successfully.']);
        else :
            return response()->json(['success' => false, 'message' => 'Failed.']);
        endif;
    }

    public function show(Product $product, $id)
    {
        return Product::find($id);
    }

    public function destroy(Request $request)
    {
        $data = Product::where('id', '=', $request->id)->delete();
        if ($data == 1) :
            return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
        else :
            return response()->json(['success' => false, 'message' => 'Delete failed.']);
        endif;
    }
}
