<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page (v2)</title>


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/dist/css/adminlte.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/dist/css/style.css') }}">
</head>
<body class="hold-transition register-page" style="background-image: url('{{ $setting->banner }}')">
<div class="register-box" style="width:450px">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1">Đăng ký</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Đăng ký thành viên mới</p>

      <form action="{{ route('post.register') }}" method="post" id="register_form">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
            </div>
            <input type="text" class="form-control" placeholder="Họ và tên" name="name">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
            </div>
            <input type="email" class="form-control" placeholder="Email" name="email">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            <input type="text" class="form-control" id="username" placeholder="Tên đăng nhập" name="username">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
            </div>
            <input type="password" class="form-control" id="password" placeholder="Mật khẩu" name="password">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
            </div>
            <input type="password" class="form-control" placeholder="Xác nhận mật khẩu" name="confirm_password">
        </div>
      </form>
      <br>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="button" class="btn btn-primary btn-block register">Đăng ký</button>
          </div>
          <!-- /.col -->
        </div>

      <br>
      {{-- <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div> --}}

      Đã có tài khoản - <a href="{{ route('login') }}" class="text-center">Đăng nhập</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE-3.1.0/dist/js/adminlte.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{ asset('AdminLTE-3.1.0/dist/js/register.js') }}"></script>
</body>
</html>
