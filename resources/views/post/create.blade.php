@extends('layouts.app')
@section('contend')
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Category Post</h6>
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <ul>
                    <li>
                        <p class="text-danger">{{ $error }}</p>
                    </li>
                </ul>
            @endforeach
        @endif
        <form class="forms-sample" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputUsername1">Post Title</label>
                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off"
                     name="post_title">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">Post Slug</label>
                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off"
                     name="post_slug">
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">Post Thumbnail</label>
                <input type="file" class="form-control" id="exampleInputUsername1" autocomplete="off"
                     name="post_thumbnail">
            </div>
            <div class="form-group">
                <label for="parent_category">Parent Category</label>
                <select name="post_category" id="parent_category">
                    <option value="">Select Parent Category</option>
                    @foreach ($parent_category as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="post_subCategory">Post SubCategory</label>
                <select  name="post_subCategory" id="post_subCategory">

                </select>
            </div>
            <div class="form-group">
                <label for="post_tags">Post Tags</label>
                <select class="PostTags " name="post_tags[]" id="post_tags" multiple="multiple">
                    @foreach ($post_tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="pstatus">Post Status</label>
                <select name="post_status" id="pstatus">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pty">Post Type</label>
                <select name="post_type" id="pty">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="postkind">Post Type</label>
                <select name="post_kind" id="postkind">
                    <option value="top">Top</option>
                    <option value="populer">Populer</option>
                    <option value="treanding">Treanding</option>
                </select>
            </div>


            <div class="form-group">
                <label for="exampleInputUsername1">Post Description</label>
                <textarea name="post_description" id="summernote" ></textarea>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Create POST</button>

        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("#summernote").summernote({
            placeholder: 'describe your post',
            height: 400,
        });
        $('.select_js').select2();
    });
</script>
<!-- ajax code -->
<script>
    $(document).ready(function() {
        // category ajax
        $('#parent_category').change(function() {
            var category_id = $(this).val();
            if (category_id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '/admin/post/subCategoryList',
                    data: {
                        category_id: category_id
                    },
                    success: function(data) {
                        $("#post_subCategory").html(data);
                    }
                });
            }
        })
    })
</script>

<script>//select2
    $(document).ready(function() {
        $('.PostTags').select2();
    });
</script>
@endsection

