<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use App\Models\SubCategory;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategory = SubCategoryResource::collection(SubCategory::with('category')->paginate());
        return $this->success($subcategory, "data is here", 200, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {

        $subcategory = SubCategory::create(
            $request->all()
        );
        $subcategory->load('category');

        return $this->success(
            new subCategoryResource($subcategory),
            'subCategory created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(subCategory $subcategory)
    {
        $subcategory = new SubCategoryResource($subcategory);
        return $this->success($subcategory, "data is here", 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(subCategoryRequest $request, subCategory $subcategory)
    {
        $subcategory->update(
            $request->all()
        );
        $subcategory->load('category');

        return $this->success(
            new SubCategoryResource($subcategory),
            'subCategory created successfully',
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subCategory $subcategory)
    {
        $subcategory->delete();
        return $this->success('', 'subCategory Deleted Successfully');
    }
}
