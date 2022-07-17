@extends('layouts.master')
@section('title')
    <title>Nạp tiền</title>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Danh sách ngân hàng</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Danh sách ngân hàng</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
  <!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-body">
                    <ul style="color: rgb(210, 23, 23)">
                        <li>Nhập đúng nội dung chuyển tiền.</li>
                        <li>Cộng tiền trong vài giây.</li>
                        <li>Liên hệ BQT nếu nhập sai nội dung chuyển.</li>
                    </ul>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div><!-- /.container-fluid -->
    <div class="container-fluid">
      <div class="row">
        @foreach ($banks as $bank)
        @php
            $str = \App\Http\Controllers\UserController::utf8convert($bank->account_name);
        @endphp
        <div class="col-md-4">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img style="width: 300px; height: 120px;"
                       src="{{ asset($bank->image ? $bank->image : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                </div>
                <br>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    Số tài khoản: <b>{{ $bank->account_number }}</b>&nbsp;
                    <button type="button" onclick="copyToClipboard('{{ $bank->account_number }}')" class="copy btn btn-sm btn-outline-info btn-not-radius" ><i class="fa fa-copy"></i></button>
                  </li>
                  <li class="list-group-item">
                    Chủ tài khoản: <b>{{ $str }}</b>
                  </li>
                  <li class="list-group-item">
                    Ngân hàng: <b>{{ $bank->bank_name }}</b>
                  </li>
                  <li class="list-group-item">
                    Chi nhánh: <b>{{ $bank->branch }}</b>
                  </li>
                  <li class="list-group-item">
                    Nội dung nạp tiền: <b>{{ Auth::user()->code_name }}</b>&nbsp;
                    <button type="button" onclick="copyToClipboard('{{ Auth::user()->code_name }}')" class="copy btn btn-sm btn-outline-info btn-not-radius" ><i class="fa fa-copy"></i></button>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        @endforeach

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
<!-- /.content -->
@endsection
@section('script')
<script>

    function copyToClipboard(element) {
        navigator.clipboard.writeText(element);

        toastr.success('Đã sao chép vào bộ nhớ tạm');
    }
</script>
@endsection
