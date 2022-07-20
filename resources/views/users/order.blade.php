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
                    <form action="{{ route('order.order-service-pack', $service->slug) }}" method="POST" enctype="multipart/form-data" id="bank_add_form">
                        {{-- <div class="row">
                            <div class="col-lg-8"> --}}
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
                                    @include('users.utilities.quantity')
                                </div>
                                <div class="form-group row">
                                    <label class="form-control-label col-lg-3" for="basic-url">Ghi chú đơn hàng</label>
                                    <textarea class="form-control col-lg-9" name="note" id="note" rows="2" placeholder="Nhập ghi chú đơn hàng nếu có"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-center">
                                            <div class="alert alert-default" style="border: 2px solid #17a2b8;">
                                                <h4>Số tiền cần thanh toán: <b id="total"></b></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" style="text-align: center">
                                        <button type="submit" class="btn btn-primary text-center"> Đặt đơn hàng</button>
                                    </div>
                                </div>
                            {{-- </div>
                        </div> --}}
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
<script>
    $(document).on('click', 'input[name="service_pack"]:checked', function(){
        let id = $(this).val();
        let url = "{{ route('order.get-service-pack',':id') }}";
        url = url.replace(':id', id);
        $.get(url, function(data){
            $('#type_content').html('');
            if(data.feeling == 'show'){
                $('#type_content').html(`@include('users.utilities.feeling')`);
                $('#quantity_content').html(`@include('users.utilities.quantity')`);
            }else if(data.comment == 'show'){
                $('#type_content').html(`@include('users.utilities.comment')`);
                $('#quantity_content').html('');
            }else if (data.eyes == 'show'){
                $('#type_content').html(`@include('users.utilities.eyes')`);
                $('#quantity_content').html(`@include('users.utilities.quantity')`);
            }
            if(data.vip == 'show'){
                $('#vip_content').html(`@include('users.utilities.vip')`);
            }else{
                $('#vip_content').html('');
            }
            total();
        });

    });
    $(document).on('keyup', '#quantity', function () {
        total();
    });
    $(document).on('keyup', '#comment', function () {
        total();
    });
    $(document).on('change', '#vip', function () {
        total();
    });

    function total(){
        let total = 0;
        let service_pack = $('#bank_add_form').find("input[name=service_pack]:checked").attr('data-price');
        if($('#feeling').length > 0){
            total = service_pack
        }else if($('#comment').length > 0){
            let lineCount = 0;
            var lines = $('#comment').val().split("\n");
            for (var i = 0; i < lines.length; i++) {
                if (lines[i].length > 0) lineCount++;
            }
            total = service_pack * lineCount
        }else if($('#eyes').length > 0){
            let eyes = $('#eyes').val();
            if(eyes == ''){
                eyes = 0;
            }
            total = service_pack * eyes;
        }
        if($('#quantity').length > 0){
            let quantity = $('#quantity').val();
            if(quantity == ''){
                quantity = 0;
            }
            total = total * quantity
        }
        if($('#vip').length > 0){
            let day_number = $('#vip').val();
            total = total * day_number
        }
        $('#total').html(`${total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}đ`);
    }
</script>

@endsection
