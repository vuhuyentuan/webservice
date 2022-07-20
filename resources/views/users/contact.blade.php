@extends('layouts.master')
@section('title')
    <title>Liên hệ</title>
@endsection
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Liên hệ</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
              <li class="breadcrumb-item active">Liên hệ</li>
            </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <section class="col-lg-6 connectedSortable ui-sortable">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin</h3>
                    </div> <!-- /.card-body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 text-center">
                                <div class="image">
                                    <a href="{{ json_decode($contact->contacts)->facebook }}" target="__blank">
                                        <img src="{{ asset('AdminLTE-3.1.0/dist/icon/facebook.png') }}" width="50px" height="50px" class="img-circle elevation-2" title="Facebook">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-1 text-center">
                                <div class="image">
                                    <a href="{{ json_decode($contact->contacts)->zalo }}" target="__blank">
                                        <img src="{{ asset('AdminLTE-3.1.0/dist/icon/zalo-logo.png') }}" width="50px" height="50px" class="img-circle elevation-2" title="Facebook">
                                    </a>
                                </div>
                            </div>
                        </div><br>
                        <p><b>Số điện thoại:</b> {{ json_decode($contact->contacts)->phone }}</p>
                        <p><b>Email:</b> {{ json_decode($contact->contacts)->email }}</p>
                        <p><b>Dịch vụ hỗ trợ 24/7</b></p>
                    </div><!-- /.card-body -->
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
