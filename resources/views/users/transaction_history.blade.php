@extends('layouts.master')
@section('title')
    <title>Biến động số dư</title>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Biến động số dư</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Biến động số dư</li>
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
                <div class="card-header">
                    <div class="row">
                        <div class="input-group col-lg-12">
                            <div class="col-lg-2">
                                <div class="form-inline">
                                    <div class="input-group" data-widget="sidebar-search">
                                    <input class="form-control form-control-sidebar" type="text" placeholder="Tìm kiếm..." id="search-btn" class=" aria-label="Search">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group date" id="daterangepicker"
                                style="margin-left: 0px; padding-left: 0px;padding-right: 2px; margin-bottom: 3px">
                                <input class="form-control" name="date" id="date" data-date-format="yyyy-mm-dd" type="text"
                                value="{{ date('d/m/Y', strtotime($first_day)) . ' - ' . date('d/m/Y', strtotime($last_day)) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="transaction_history_table" class="table table-bordered table-hover ajax_view">
                    <thead>
                        <tr>
                            <th>Trạng thái</th>
                            <th>Số tiền</th>
                            <th>Biến động</th>
                            <th>Nội dung</th>
                            <th>Ngày</th>
                        </tr>
                    </thead>
                    </table>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('script')
<script>
    $(document).ready(function (e) {
        $('input[name="date"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
        });

        $(document).on('change', '#date', function(){
            transaction_history_table.ajax.reload();
        })

        var debounceTripDetail = null;
        $('#search-btn').on('input', function(){
            clearTimeout(debounceTripDetail);
            debounceTripDetail = setTimeout(() => {
                transaction_history_table.search($(this).val()).draw();
            }, 500);
        });
        var transaction_history_table =$('#transaction_history_table').DataTable({
            "destroy": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 15,
            aaSorting: [
                [0, 'desc']
            ],
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
            },
            ajax: {
                url: "{{ route('transaction.history') }}",
                data: function(d) {
                    var start = '';
                    var end = '';
                    if ($('#date').val()) {
                        start = $('#date')
                            .data('daterangepicker')
                            .startDate.format('YYYY-MM-DD');
                        end = $('#date')
                            .data('daterangepicker')
                            .endDate.format('YYYY-MM-DD');
                    }
                    d.start_date = start;
                    d.end_date = end;
                }
            },
            order: [],
            "columns":[
                {"data": "status", class: 'text-center', orderable: false  },
                {"data": "price", class: 'text-center' },
                {"data": "volatility", class: 'text-center' },
                {"data": "content" },
                {"data": "created_at", class: 'text-center', orderable: false },
            ]
        });
    });
</script>
@endsection
