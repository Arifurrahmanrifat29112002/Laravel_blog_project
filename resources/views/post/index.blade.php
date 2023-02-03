@extends('layouts.app')
@section('contend')
<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-title">Post list</h6>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#sub">Trash</button>
        </div>
        <!-- Button trigger modal -->
        <!-- Modal -->
        <div class="modal fade" id="sub" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">TrashBin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Title</th>
                                    <th> Category</th>
                                    <th> SubCategory</th>
                                    <th> Kind</th>
                                    <th> Status</th>
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trashPosts as $trashPost)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $trashPost->post_title }}</td>
                                        <td>{{ $trashPost->categoryRelation->category_name }}</td>
                                        <td>{{ $trashPost->SubCategoryRelation->subcategory_name }}</td>
                                        <td>{{ $trashPost->post_kind }}</td>
                                        <td>
                                            <p
                                                class="badge @if ($trashPost->post_status == 'active') badge-success
                                             @else badge-warning @endif">
                                                {{ $trashPost->post_status }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ route('posts.update', ['post' => $trashPost->id]) }}" class="btn btn-warning ">Restore</a>
                                            <form
                                                action="{{ route('post.delete', ['id' => $trashPost->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger delete">Delete</button>
                                        </td>
                                        </form>

                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            <p class="d-block text-center">no user list</p>
                                        </td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--show all post -->
 <div class="table-responsive">
    <table class="table table-hover">

        <thead>
            <tr>
                <th>#</th>
                <th> Title</th>
                <th> Category</th>
                <th> SubCategory</th>
                <th> Type</th>
                <th> Kind</th>
                <th> Status</th>
                <th> Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{ $post->post_title }}</td>
                <td>{{ $post->categoryRelation->category_name }}</td>
                <td>{{ $post->SubCategoryRelation->subcategory_name }}</td>
                <td>{{ $post->post_type }}</td>
                <td>{{ $post->post_kind }}</td>
                <td>
                    <p
                        class="badge @if ($post->post_status == 'active') badge-success
                     @else badge-warning @endif">
                        {{ $post->post_status }}</p>
                </td>
                <td>
                    <a href="{{ route('posts.edit', ['post' => $post->id]) }}"
                        class="btn btn-warning ">Edit</a>
                    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger delete">Delete</button>
                </td>
                </form>

                </td>
            </tr>
        @empty
            <tr>
                <td>
                    <p class="d-block text-center">no user list</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
    </div>
</div>
@endsection
