@extends('layouts.master')
@section('title')
    <title>Thông tin</title>
@endsection
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Thông tin tài khoản</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Thông tin tài khoản</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
  <!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                @if(Session::has('flag'))
                    <div class="alert alert-{{Session::get('flag')}}">{{Session::get('messege')}} </div>
                @endif
                <form class="form-horizontal" action="{{ route('info.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data"  id="user_update_form">
                    @csrf
                    <div class="form-group row">
                      <label for="name" class="col-sm-2 col-form-label">Họ tên</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Họ tên" value="{{ Auth::user()->name }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="email" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ Auth::user()->email }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="phone" class="col-sm-2 col-form-label">Số điện thoại</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" value="{{ Auth::user()->phone }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="username" class="col-sm-2 col-form-label">Tên đăng nhập</label>
                      <div class="col-sm-10">
                        <input class="form-control" id="username" placeholder="Tên đăng nhập" readonly value="{{ Auth::user()->username }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="password" class="col-sm-2 col-form-label">Mật khẩu</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
                      </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Ảnh đại diện</label>
                        <div class="col-sm-10">
                            <input id="fImages" type="file" name="image" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                            <img id="img" class="img" style="width: 100px; height: 100px;" src="{{ asset(Auth::user()->avatar ? Auth::user()->avatar : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                        </div>
                      </div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger submit_update">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection
@section('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function changeImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
        $('#img').click(function() {
        $('#fImages').click();
    });

    $('form#user_update_form').validate({
        rules: {
            "name": {
                required: true,
                maxlength: 190
            },
            "email": {
                required: true,
                email: true,
                maxlength: 190
            },
            "phone": {
                number: true
            },
            "password": {
                maxlength: 190,
                minlength: 6
            }
        },
        messages: {
            "name": {
                required: 'Vui lòng nhập họ tên',
                maxlength: 'Giới hạn 190 ký tự'
            },
            "email": {
                required: 'Vui lòng nhập email',
                email: 'Không đúng định dạng email',
                maxlength: 'Giới hạn 190 ký tự'
            },
            "phone": {
                number: 'Chỉ được nhập số'
            },
            "password": {
                maxlength: 'Giới hạn 190 ký tự',
                minlength: 'Ít nhât 6 ký tự'
            }
        }
    });
</script>
@endsection
