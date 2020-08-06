<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use JWTAuth;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        return $this->product
            ->categories()
            ->get(['name', 'description'])
            ->toArray();
    }

    public function show($id)
    {
        $category = $this->product->categories()->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, category with id ' . $id . ' cannot be found'
            ], 400);
        }

        return $category;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;

        if ($this->product->categories()->save($category))
            return response()->json([
                'success' => true,
                'category' => $category
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $category = $this->product->categories()->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, category with id ' . $id . ' cannot be found'
            ], 400);
        }

        $updated = $category->fill($request->all())
            ->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, category could not be updated'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $category = $this->product->categories()->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($category->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Category could not be deleted'
            ], 500);
        }
    }
}
