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
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
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
              <h3>150</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    <div class="container-fluid">
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
                        <h3>Tổng doanh thu: <b> {{ $totalRevenueFromToDate }} VNĐ </b></h3>
                    </center>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <div class="modal fade service_modal" id="service_modal" tabindex="-1" role="dialog"></div>
    </div><!-- /.container-fluid -->
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
                    <form action="{{ route('admin.search') }}" id="" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row" style="margin-left: 2px">
                            <div class="col-3" style="padding-left: 0px;padding-right: 2px; margin-bottom: 3px">
                                <div class="input-group date" id="daterangepicker"
                                    style="margin-left: 0px; padding-left: 0px;padding-right: 2px; margin-bottom: 3px">
                                    <input class="form-control" name="dates" id="date" data-date-format="yyyy-mm-dd" name="dates"
                                        type="text"
                                        value="{{ date('d/m/Y', strtotime($first_day)) . ' - ' . date('d/m/Y', strtotime($last_day)) }}">
                                    <span class="input-group-addon"><i class="fas fa-calendar" style="position:absolute; bottom:4px; right:15px; height:24px; color: #495057;opacity:0.7"></i></span>
                                </div>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-default" id="btnsearch" type="submit"><i class="fas fa-search" style="color: black"></i></button>
                            </div>
                        </div>
                    </form>
                    <table id="statistical_table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center; ">Ngày</th>
                            <th style="text-align: center; ">Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($arrRevenueMonthDone); $i++)
                            <tr role="row">
                                <td style="text-align: center">
                                    <h6>{{ date('d/m/Y', strtotime($dates[$i])) }}</h6>
                                </td>
                                <td style="text-align: center">
                                    <h6>{{ $arrRevenueMonthDone[$i] }} vnđ </h6>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                    </table>
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
    $('#statistical_table').DataTable({
        "destroy": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 15,
        "pagingType": "full_numbers",
        "language": {
            "info": 'Hiển thị _START_ đến _END_ của _TOTAL_ mục',
            "infoEmpty": 'Hiển thị 0 đến 0 của 0 mục',
            "infoFiltered": '',
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": 'Hiển thị _MENU_ mục',
            "loadingRecords": 'Đang tải...',
            "processing": 'Đang xử lý...',
            "emptyTable": 'Không có dữ liệu',
            "zeroRecords": 'Không tìm thấy kết quả',
            "search": 'Tìm kiếm',
            "paginate": {
                'first': '<i class="fa fa-angle-double-left"></i>',
                'previous': '<i class="fa fa-angle-left" ></i>',
                'next': '<i class="fa fa-angle-right" ></i>',
                'last': '<i class="fa fa-angle-double-right"></i>'
            },
        }
    });

    $('input[name="dates"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
</script>
@endsection
