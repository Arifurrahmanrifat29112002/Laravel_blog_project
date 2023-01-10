@extends('layouts.app')
@section('contend')
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Admin || user create form</h6>

            <form class="forms-sample" action="{{ route('users.create') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleInputUsername1">Username</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off"
                        placeholder="Username" name="name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" autocomplete="off"
                        placeholder="Password" name="password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Role</label>
                    <select name="role" id="">
                        <option value="admin">Admin</option>
                        <option value="writer" selected>Writer</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>

            </form>
        </div>
    </div>



    <div class="card mt-2">
        <div class="card-body">
            <h6 class="card-title">Admin and Writer list</h6>
            <div class="table-responsive">
                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user_list as $users)
                            <tr>
                                <th>{{ $user_list->firstItem() + $loop->index}}</th>
                                <td>{{ $users->name }}</td>
                                <td>{{ $users->email }}</td>
                                <td>
                                    <p
                                        class="badge @if ($users->role == 'admin') badge-success
                            @else
                            badge-warning @endif">
                                        {{ $users->role }}</p>
                                </td>
                                <td><button value="{{ route('users.destroy', ['id' => $users->id]) }}"
                                        class="btn btn-danger delete">Delete</button></td>
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
                {{ $user_list->links() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>//user create successfull message show
        @if (session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            })
        @endif
    </script>
    <script>//user delete button show messasge
        $(document).ready(function() {
            $('.delete').click(function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.assign($(this).val())
                    }
                })
            })
        })
    </script>
@endsection
