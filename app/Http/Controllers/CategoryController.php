<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index', [
            'categories' => Category::paginate(5)->withQueryString(),
            'subcategories' => SubCategory::paginate(5)->withQueryString(),
            'trashCategories' => Category::onlyTrashed()->get(),
            'trashSubCategories' => SubCategory::onlyTrashed()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create', [
            'parent_categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required |unique:categories,category_name,'.$request->id,
            'description' => 'required|unique:categories,category_slug,'.$request->id,
            'image' => 'required|mimes:jpg'
        ]);
        $slug = '';
        if ($request->slug) {
            $slug = Str::slug($request->slug, '-');
        } else {
            $slug = Str::slug($request->name, '-');
        }
        //parent id check
        if ($request->parent_id != 0) {
            //category image upload code
            $file_name = auth()->id() . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $img = Image::make($request->file('image'));
            $img->save(base_path('public/upload/subcategory_image/' . $file_name), 80);
            // subcategory data insert a table
            SubCategory::insert([
                'parent_id' => $request->parent_id,
                'subcategory_name' => $request->name,
                'subcategory_slug' => $slug,
                'subcategory_description' => $request->description,
                'subcategory_status' => $request->status,
                'subcategory_image' => $file_name,
                'created_at' => now(),
            ]);
            return back();
        } else {

            //category image upload code
            $file_name = auth()->id() . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $img = Image::make($request->file('image'));
            $img->save(base_path('public/upload/category_image/' . $file_name), 80);
            //category data insert a table
            Category::insert([
                'category_name' => $request->name,
                'category_slug' => $slug,
                'category_description' => $request->description,
                'category_status' => $request->status,
                'category_image' => $file_name,
                'created_at' => now(),
            ]);
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //category edit
       return view('categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //category update
        $request->validate([
            'name' => 'required |unique:categories,category_name,'.$request->id,
            'description' => 'required|unique:categories,category_slug,'.$request->id,
            //'image' => 'required|mimes:jpg'
        ]);
        $slug = '';
        if ($request->slug) {
            $slug = Str::slug($request->slug, '-');
        } else {
            $slug = Str::slug($request->name, '-');
        }
        $category->update([
                'category_name' => $request->name,
                'category_slug' => $slug,
                'category_description' => $request->description,
                'category_status' => $request->status,

        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $id = $category->id;
        $subcategories = SubCategory::where('parent_id', $id)->get();
        foreach ($subcategories as $subcategory) {
            $subcategory->delete();
        }
        $category->delete();
        return back();
    }
    //category restore
    public function restore($id)
    {
        Category::onlyTrashed()->find($id)->restore();
        return back();
    }
    //category delete
    public function delete($id)
    {
        $category =Category::onlyTrashed()->find($id);
        $id = $category->id;
        $image_name=$category->category_image;
        $subcategories = SubCategory::onlyTrashed()->where('parent_id', $id)->get();
        foreach ($subcategories as $subcategory) {
            unlink(base_path("public/upload/subcategory_image/" . $subcategory->subcategory_image));

            $subcategory->delete();
        }
        unlink(base_path("public/upload/category_image/" . $image_name));
        Category::onlyTrashed()->find($id)->forceDelete();
        return back();
    }
    //SubCategory destroy
    public function SubDestroy($id)
    {
        SubCategory::find($id)->delete();
        return back();
    }
    //Subcategory restore
    public function SubRestore($id)
    {
        $parent_id = SubCategory::onlyTrashed()->find($id)->parent_id;
        $parent_deleted_at_check = Category::withTrashed()->find($parent_id)->deleted_at;

        if ($parent_deleted_at_check == null) {
            SubCategory::onlyTrashed()->find($id)->restore();
            return back();
        }else{
            return 'no';
        }
    }
}
