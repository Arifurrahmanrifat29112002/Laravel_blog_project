@extends('layouts.app')
@section('contend')
    <div class="profile-page mt-0">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="profile-header">
                    <div class="cover">
                        <div class="gray-shade"></div>
                        <figure>
                            <img src="https://via.placeholder.com/1148x272" class="img-fluid" alt="profile cover">
                        </figure>
                        <div class="cover-body d-flex justify-content-between align-items-center">
                            <div>
                                <img class="profile-pic" src="https://via.placeholder.com/100x100" alt="profile">
                                <span class="profile-name">Amiah Burton</span>
                            </div>

                        </div>
                    </div>
                    <div class="header-links">

                    </div>
                </div>
            </div>
        </div>
        <!--profile update form-->
        <div class="row profile-body">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">profile Update Form</h6>
                        <form class="forms-sample" action="{{ route('profile.update',["id"=>auth()->id()]) }}"  method="POST" >
                        @csrf
                            <div class="form-group row">
                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="exampleInputUsername2"
                                        placeholder="Username" name="name" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="exampleInputEmail2" readonly
                                        placeholder="Email" name="email" value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Mobile</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="exampleInputMobile"
                                        placeholder="Mobile number" name="phone_number" value="{{ Auth::user()->phone_number }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="exampleInputMobile"
                                        placeholder="Address" name="address" value="{{ Auth::user()->address }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Gender</label>
                                <div class="col-sm-9">
                                    <select name="gender" id="" >
                                        <option value="male" @selected(auth()->user()->gender == 'male')>Male</option>
                                        <option value="female" @selected(auth()->user()->gender == 'female')>Female</option>
                                        <option value="other" @selected(auth()->user()->gender == 'other')>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Profile Image</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="exampleInputMobile" name="profile_image">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Cover Photo</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="exampleInputMobile" name="cover_photo">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Submit</button>

                        </form>
                    </div>
                </div>
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

@endsection
