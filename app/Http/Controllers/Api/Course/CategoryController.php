<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\FileUploader;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Traits\CanLoadRelationships;

class CategoryController extends Controller
{
    use HttpResponses;
    use FileUploader;
    use CanLoadRelationships;

    private array $relations = ['courses'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $category = CategoryResource::collection(Category::all());
        // return $this->success($category, "data is here", 200);
        $query = $this->loadRelationships(Category::query());
        $categorys = CategoryResource::collection($query->paginate());
        return $this->success($categorys, "data is here", 200, true);
   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        $category = Category::create(
            $request->all()
        );
        $this->uploadImage($request, $category, "category", $inputName = 'image');
        // return $category->image;
        return $this->success(
            new CategoryResource($category),
            'Category created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // $category = new CategoryResource($category);
        // return $this->success($category, "data is here", 200);

        $query = $this->loadRelationships($category);
        $categorys = new CategoryResource($query);
        return $this->success($categorys, "data is here", 200);
       }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update(
            $request->all()
        );

        return $this->success(
            new CategoryResource($category),
            'Category created successfully',
            201
        );
    }

    public function updateCategoryImage(CategoryRequest $request, Category $category)
    {

        $this->deleteImage($category->image);
        $this->uploadImage($request, $category, 'category');
        return $this->success($category, "image updated", 202);

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->deleteImage($category->image);
        $category->delete();
        return $this->success('', 'Category Deleted Successfully');
    }
}
