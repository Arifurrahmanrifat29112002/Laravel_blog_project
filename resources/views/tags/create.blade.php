@extends('layouts.app')
@section('contend')
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Category Tag</h6>
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <ul>
                    <li>
                        <p class="text-danger">{{ $error }}</p>
                    </li>
                </ul>
            @endforeach
        @endif
        <form class="forms-sample" action="{{ route('tag.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="exampleInputUsername1">Tag Name</label>
                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off"
                     name="tag_name">
            </div>


            <button type="submit" class="btn btn-primary mr-2">Create Tag</button>

        </form>
    </div>
</div>
@endsection


