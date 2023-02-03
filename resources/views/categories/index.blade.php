@extends('layouts.app')
@section('contend')
    <!--show all parent categories-->
    <div class="card mt-2">
        <div class="card-body ">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="card-title">parent categories list</h6>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#staticBackdrop">Trash</button>
            </div>
            <!-- Button trigger modal -->
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                                            <th> Name</th>
                                            <th> Slug</th>
                                            <th> Description</th>
                                            <th> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($trashCategories as $trashCategory)
                                            <tr>
                                                <th> {{ $loop->iteration }} </th>
                                                <td>{{ $trashCategory->category_name }}</td>
                                                <td>{{ $trashCategory->category_slug }}</td>
                                                <td>{{ $trashCategory->category_description }}</td>
                                                <td>
                                                    <a href="{{ route('category.restore', ['id' => $trashCategory->id]) }}" class="btn btn-warning ">Restore</a>
                                                    <form
                                                        action="{{ route('category.delete', ['id' => $trashCategory->id]) }}"
                                                        method="post">
                                                        @csrf
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
                            <button type="button" class="btn btn-primary">Understood</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th> Name</th>
                            <th> Slug</th>
                            <th> Description</th>
                            <th> Status</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <th>{{ $categories->firstItem() + $loop->index }}</th>
                                <td>{{ $category->category_name }}</td>
                                <td>{{ $category->category_slug }}</td>
                                <td>{{ $category->category_description }}</td>
                                <td>
                                    <p
                                        class="badge @if ($category->category_status == 'active') badge-success
                                     @else badge-warning @endif">
                                        {{ $category->category_status }}</p>
                                </td>
                                <td>
                                    <a href="{{ route('category.edit', ['category' => $category->id]) }}"
                                        class="btn btn-warning ">Edit</a>
                                    <form action="{{ route('category.destroy', ['category' => $category->id]) }}"
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>
    <!--show all  Subcategories-->
    <div class="card mt-2">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
                <h6 class="card-title">SubCategories list</h6>
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
                                            <th> Name</th>
                                            <th> Slug</th>
                                            <th> Description</th>
                                            <th> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($trashSubCategories as $trashSubCategory)
                                            <tr>
                                                <th> {{ $loop->iteration }} </th>
                                                <td>{{ $trashSubCategory->subcategory_name }}</td>
                                                <td>{{ $trashSubCategory->subcategory_slug }}</td>
                                                <td>{{ $trashSubCategory->subcategory_description }}</td>
                                                <td>
                                                    <a href="{{ route('subcategory.restore', ['id' => $trashSubCategory->id]) }}" class="btn btn-warning ">Restore</a>
                                                    <form
                                                        action=""
                                                        method="post">
                                                        @csrf
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
                            <button type="button" class="btn btn-primary">Understood</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th> Name</th>
                            <th> Slug</th>
                            <th> Category Name</th>
                            <th> Description</th>
                            <th> Status</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subcategories as $subcategory)
                            <tr>
                                <th>{{ $subcategories->firstItem() + $loop->index }}</th>
                                <td>{{ $subcategory->subcategory_name }}</td>
                                <td>{{ $subcategory->subcategory_slug }}</td>
                                <td>{{ $subcategory->categoryRelation->category_name }}</td>
                                <td>{{ $subcategory->subcategory_description }}</td>
                                <td>
                                    <p
                                        class="badge @if ($subcategory->subcategory_status == 'active') badge-success
                                     @else badge-warning @endif">
                                        {{ $subcategory->subcategory_status }}</p>
                                </td>
                                <td>
                                    <a href="{{ route('category.edit', ['category' => $subcategory->id]) }}"
                                        class="btn btn-warning ">Edit</a>
                                    <form action="{{ route('subcategory.destroy', ['id' => $subcategory->id]) }}"
                                        method="post">
                                        @csrf
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
                {{ $subcategories->links() }}
            </div>
        </div>
    </div>
@endsection
