<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\post;
use App\Models\SubCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //show post
        return view('post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //view post>create page
        return view('post.create',[
            'parent_category' => Category::all(),
            'post_tags' =>Tag::all(),
        ]);
    }
    public function getSubCategoryList(Request $request)
    {
        //ajax
        $category_id = $request->category_id;
        $sub_categories_lists = SubCategory::where('parent_id', $category_id)->get();
        $subCategoriesOption = ' ';
        foreach ($sub_categories_lists as $value) {
            $subCategoriesOption .="<option value='$value->id'>$value->subcategory_name</option>";
        }
        return $subCategoriesOption;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //post>create hit this method
        //create page data insert database
        $request->validate([
            'post_title'=>'required|unique:posts,post_title,'.$request->id,
            'post_slug'=>'required|unique:posts,post_slug,'.$request->id,
            'post_thumbnail'=>'required|mimes:png,jpg',
            'post_category'=>'required',
            'post_tags'=>'required',
            'post_status'=>'required',
            'post_type'=>'required',
            'post_kind'=>'required',
            'post_description'=>'required',
        ]);
        if ($request->post_slug) {
            $slug = str::slug($request->post_slug, '-');
        } else {
            $slug = Str::slug($request->post_title, '-');
        }

        //post_thumbnail upload
        $file_name = auth()->id() . '-' . time() . '.' . $request->file('post_thumbnail')->getClientOriginalExtension();
        $img = Image::make($request->file('post_thumbnail'));
        $img->save(base_path('public/upload/post_thumbnail/' . $file_name), 80);

        //post_description or text_editor or summary
        // text editor
        $post_description = $request->post_description;
        libxml_use_internal_errors(true);
        $dom = new \DomDocument();
        $dom->loadHtml('<?xml encoding="utf-8" ?>' . $post_description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    // must include this to avoid font problem
        $images = $dom->getElementsByTagName('img');
        if (count($images) > 0) {
            foreach ($images as  $img) {
                $src = $img->getAttribute('src');
                # if the img source is 'data-url'
                if (preg_match('/data:image/', $src)) {
                    # get the mimetype
                    preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                    $mimetype = $groups['mime'];
                    # Generating a random filename
                    $filename =
                        Str::limit($slug, 5) . '_' . auth()->id() . '_' . time() .
                        Str::random(8) . '_' . Carbon::now()->format('Y');

                    $filepath = "upload/post_description/$filename.$mimetype";
                    $image = Image::make($src)
                        ->encode($mimetype, 100)
                        ->save(public_path($filepath), 80);
                    $new_src = asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);
                }
            }
        }
        # modified entity ready to store in database
        $post_description = $dom->saveHTML();


        //insert data in database
       $id = post::insertGetId([
            "writer" => auth()->id(),
           "post_title" => $request->post_title,
            "post_slug" => $slug,
            "post_thumbnail" => $file_name,
            "post_category" => $request->post_category,
            "post_subCategory" => $request->post_subCategory,
            "post_description" =>$post_description,
            "post_status" =>$request->post_status,
            "post_type" =>$request->post_type,
            "post_kind" =>$request->post_kind,
            "created_at" =>now(),
        ]);
        $post = new post();
        foreach ($request->post_tags as $tag) {
            $post->find($id)->tagsRelation()->attach($tag);
        }
        return back()->withSuccess('Post Create Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        //
    }
}
