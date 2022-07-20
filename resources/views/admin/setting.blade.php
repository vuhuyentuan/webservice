@extends('layouts.master')
@section('title')
    <title>Cài đặt</title>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Cài đặt</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Cài đặt</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    @if(Session::has('flag'))
        <div class="alert alert-{{Session::get('flag')}}">{{Session::get('messege')}} </div>
    @endif
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h4>Giao diện</h4>
                </div> <!-- /.card-body -->
              <div class="card-body box-profile">
                    <form class="form-horizontal" action="{{ route('settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data"  id="setting_form">
                      @csrf
                      @method('PUT')
                      <div class="form-group row">
                          <label for="password" class="col-sm-2 col-form-label">Logo</label>
                          <div class="col-sm-10">
                              <input id="fImages" type="file" name="logo" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                              <img id="img" class="img" style="width: 100px; height: 100px;" src="{{ asset($setting->logo) }}">
                          </div>
                      </div>
                      <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Logo text</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="logo_text" placeholder="Logo text" value="{{ $setting->logo_text }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Background <br> Đăng nhập / Đăng ký</label>
                        <div class="col-sm-10">
                            <input id="banner" type="file" name="banner" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeBanner(this)">
                            <img id="banner-img" class="banner" style="width: 250px; height: 120px;" src="{{ asset($setting->banner) }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Cập nhật</button>
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
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h4>Liên hệ</h4>
                </div> <!-- /.card-body -->
                <div class="card-body box-profile">
                    <form class="form-horizontal" action="{{ route('settings.update_contact', $setting->id) }}" method="POST" enctype="multipart/form-data"  id="setting_form">
                      @csrf
                      <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Facebook</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="facebook" placeholder="https://www.facebook.com/admin" value="{{ json_decode($setting->contacts)->facebook }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Zalo</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="zalo" placeholder="https://zalo.me/011564897" value="{{ json_decode($setting->contacts)->zalo }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Số điện thoại</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="phone" placeholder="Số điện thoại" value="{{ json_decode($setting->contacts)->phone }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" name="email" placeholder="Email" value="{{ json_decode($setting->contacts)->email }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Cập nhật</button>
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
  <!-- /.content -->
@endsection
@section('script')
<script>
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

    function changeBanner(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#banner-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
        $('#banner-img').click(function() {
        $('#banner').click();
    });

</script>
@endsection
