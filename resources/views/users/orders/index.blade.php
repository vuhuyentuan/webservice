@extends('layouts.master')
@section('title')
    <title>{{$service->name}}</title>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{$service->name}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{$service->name}}</li>
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
        <section class="col-lg-8 connectedSortable ui-sortable">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Thêm đơn</h3>
                </div> <!-- /.card-body -->
                <div class="card-body">
                    <form action="{{ route('order.order-service-pack', $service->id) }}" method="POST" enctype="multipart/form-data" id="order_form">
                        @csrf
                        <div class="form-group row">
                            <label class="form-control-label col-lg-3" for="basic-url">ID bài viết</label>
                            <input type="text" class="form-control col-lg-9" name="url" id="url" placeholder="Nhập ID hoặc Link tùy theo gói">
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="form-control-label" for="basic-url">Gói dịch vụ</label>
                            </div>
                            <div class="form-group col-sm-9">
                            @if (!empty($service->service_pack))
                            @foreach ($service->service_pack as $service_pack)
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio{{$service_pack->id}}" name="service_pack" data-price="{{$service_pack->price}}" value="{{$service_pack->id}}">
                                <label for="customRadio{{$service_pack->id}}" class="custom-control-label">{{$service_pack->name}}</label>
                            </div>
                            @endforeach
                            @endif
                            </div>
                        </div>
                        <div id="type_content">
                        </div>
                        <div id="vip_content">
                        </div>
                        <div id="quantity_content">
                            @include('users.orders.partials.quantity')
                        </div>
                        <div class="form-group row">
                            <label class="form-control-label col-lg-3" for="basic-url">Ghi chú đơn hàng</label>
                            <textarea class="form-control col-lg-9" name="note" id="note" rows="2" placeholder="Nhập ghi chú đơn hàng nếu có"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group text-center">
                                    <div class="alert1 alert-default" style="border: 2px solid #17a2b8;">
                                        <h4>Số tiền cần thanh toán: <b id="total">0đ</b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="text-align: center">
                                <button type="submit" class="btn btn-primary text-center" id="order_submit"> Đặt đơn hàng</button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.card-body -->
            </div>
        </section>
        <section class="col-lg-4 connectedSortable ui-sortable">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Lưu ý</h3>
                    </div> <!-- /.card-body -->
                    <div class="card-body">
                    </div><!-- /.card-body -->
                </div>
        </section>
    </div>
</div>
</section>

  <!-- /.content -->
@endsection
@section('script')
<script src="{{asset('js/order.js')}}"></script>
@endsection
