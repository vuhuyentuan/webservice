@extends('layouts.master')
@section('title')
    <title>Dashboard</title>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <form>
                <div class="row" style="float: right;">
                    <div class="col-12" style="padding-left: 0px;padding-right: 2px; margin-bottom: 3px">
                        <div class="input-group date" id="daterangepicker"
                            style="margin-left: 0px; padding-left: 0px;padding-right: 2px; margin-bottom: 3px">
                            <input class="form-control" id="date" data-date-format="yyyy-mm-dd" name="dates"
                                type="text"
                                value="{{ date('d/m/Y', strtotime($first_day)) . ' - ' . date('d/m/Y', strtotime($last_day)) }}">
                            <span class="input-group-addon"><i class="fas fa-calendar" style="position:absolute; bottom:4px; right:15px; height:24px; color: #495057;opacity:0.7"></i></span>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3 id="service_bill_pending">0</h3>

              <p>Đơn hàng đang chờ</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{route('order.history')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3 id="service_bill_done">0</h3>
              <p>Đơn hàng thành công</p>
            </div>
            <div class="icon">
                <i class="fas fa-cart-plus"></i>
            </div>
            <a href="{{route('order.history')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="user_number">0</h3>

                <p>Thành viên</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="{{route('users.index')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3 id="total_revenue_from_to_date">0</h3>

              <p>Tổng doanh thu</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{route('dashboard')}}" class="small-box-footer">Chi tiết <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    {{-- <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <center>
                        <h3><b>Thống kê tổng doanh thu theo tháng đã chọn</b></h3>
                    </center>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <center>
                        <h3>Tổng doanh thu: <b id="total_revenue_from_to_date">0</b><b> VNĐ</b></h3>
                    </center>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div><!-- /.container-fluid --> --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <center>
                        <h3><b>Thống kê doanh thu theo ngày trong tháng</b></h3>
                    </center>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div id="statistical_content">

                    </div>

                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <div class="modal fade service_modal" id="service_modal" tabindex="-1" role="dialog"></div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $.ajax({
            method: 'GET',
            url: "{{ route('dashboard') }}",
            dataType: 'json',
            data: {
                dates: $('#date').val()
            },
            success: function(result) {
                $('#service_bill_pending').html(result.data.service_bill_pending)
                $('#service_bill_done').html(result.data.service_bill_done)
                $('#user_number').html(result.data.user)
                $('#total_revenue_from_to_date').html(result.data.totalRevenueFromToDate)
                $('#statistical_content').html(result.table);
            },
        });
    })
    $('input[name="dates"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
    $(document).on('change', '#daterangepicker', function(){
        $.ajax({
            method: 'GET',
            url: "{{ route('dashboard') }}",
            dataType: 'json',
            data: {
                dates: $('#date').val()
            },
            success: function(result) {
                $('#service_bill_pending').html(result.data.service_bill_pending)
                $('#service_bill_done').html(result.data.service_bill_done)
                $('#user_number').html(result.data.user);
                $('#total_revenue_from_to_date').html(result.data.totalRevenueFromToDate)
                $('#statistical_content').html(result.table);
            },
        });
    })
</script>
@endsection
