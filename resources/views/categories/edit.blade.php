@extends('layouts.app')
@section('contend')
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Category Update</h6>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <ul>
                        <li>
                            <p class="text-danger">{{ $error }}</p>
                        </li>
                    </ul>
                @endforeach
            @endif
            <form class="forms-sample" action="{{ route('category.update', ['category' => $category->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="exampleInputUsername1">Category Name</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="name"
                        value="{{ $category->category_name }}">
                </div>
                <div class="form-group">
                    <label for="Slug">Category Slug</label>
                    <input type="text" class="form-control" id="Slug" name="slug"
                        value="{{ $category->category_slug }}">
                </div>
                <div class="form-group">
                    <label for="description">Category Description</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="{{ $category->category_description }}">
                </div>

                <div class="form-group">
                    <label for="Status">Category Status</label>
                    <select name="status" id="Status">
                        <option value="active" @selected($category->category_status == 'active')>Active</option>
                        <option value="inactive" @selected($category->category_status == 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Category Status</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <button type="submit" class="btn btn-primary mr-2">Update Category</button>

            </form>
        </div>
    </div>
@endsection
