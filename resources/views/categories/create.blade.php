@extends('layouts.app')
@section('contend')
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Category Create</h6>
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <ul>
                    <li>
                        <p class="text-danger">{{ $error }}</p>
                    </li>
                </ul>
            @endforeach
        @endif
        <form class="forms-sample" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputUsername1">Category Name</label>
                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off"
                     name="name">
            </div>
            <div class="form-group">
                <label for="Slug">Category Slug</label>
                <input type="text" class="form-control" id="Slug" name="slug">
            </div>
            <div class="form-group">
                <label for="description">Category Description</label>
                <input type="text" class="form-control" id="description" name="description">
            </div>


            <div class="form-group">

                <label for="pare">Select Parent Category</label>
                <select name="parent_id" id="pare" >
                    <option value="0" selected>Select a Parent Category</option>
                    @foreach ($parent_categories as $parent_category)
                    <option value="{{  $parent_category->id }}">{{  $parent_category->category_name }}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="Status">Category Status</label>
                <select name="status" id="Status">
                    <option value="active">Active</option>
                    <option value="inactive" selected>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Category Status</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary mr-2">Create Category</button>

        </form>
    </div>
</div>
@endsection


