@extends('layouts.master')
@section('title')
    <title>Dịch vụ</title>
@endsection
@section('style')
<style>
.select2-container .select2-selection--single{
    height: 38px;
}
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Danh sách dịch vụ</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Danh sách dịch vụ</li>
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
                        <div class="col-lg-4">
                            <div class="form-inline">
                                <div class="input-group" data-widget="sidebar-search">
                                <input class="form-control form-control-sidebar" type="text" placeholder="Tìm kiếm..." id="search-btn" class=" aria-label="Search">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 group-btn text-right">
                            <button type="button" class="btn btn-primary add_service" data-container=".service_modal"
                            data-href="{{ route('services.create') }}"><i class="fa fa-plus"></i> Thêm dịch vụ</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="service_table" class="table table-bordered table-hover ajax_view">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Tên dịch vụ</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
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
        <div class="modal fade service_modal" id="service_modal" tabindex="-1" role="dialog"></div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var debounceTripDetail = null;
    $('#search-btn').on('input', function(){
        clearTimeout(debounceTripDetail);
        debounceTripDetail = setTimeout(() => {
            service_table.search($(this).val()).draw();
        }, 500);
    });

    var service_table = $('#service_table').DataTable({
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
            url: "{{ route('services.index') }}",
        },
        order: [],
        "columns":[
            {"data": "image", orderable: false , class: 'text-center'},
            {"data": "name" },
            {"data": "name_type" },
            {"data": "status", orderable: false , class: 'text-center' },
            {"data": "action", orderable: false}
        ]
    });

    $(document).on('click', '.add_service', function(e) {
        e.preventDefault();
        $('div.service_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

    $(document).on('click', '.edit_service', function(e) {
        e.preventDefault();
        $('div.service_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

     // delete
     $(document).on('click', '.delete_service', function(e) {
        let name = $(this).data('name');
        var url = $(this).data('href');
        Swal.fire({
            title: 'Bạn muốn xóa dịch vụ ' +name,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            cancelButtonText: "Hủy",
            confirmButtonText: "Xóa",
        }).then((result) => {
        if (result.value) {
            $.ajax({
                method: "GET",
                url: url,
                dataType: "json",
                success: function(result) {
                    if (result.success == true) {
                        toastr.success(result.msg);
                    }else{
                        toastr.error(result.msg);
                    }
                    service_table.ajax.reload(null, false);
                }
            })
        }
        });
    });

    $(document).on('click', '#service_table tbody tr td:not(:last-child, .bg-row-child)', function() {
        var tr = $(this).closest('tr');
        var row = $('#service_table').DataTable().row(tr);
        if (row.child.isShown()) {
            $('div.slide', row.child()).slideUp(function() {
                tr.removeClass('bg-row');

                row.child.hide();
            });

        } else {
            $('tr.bg-row').removeClass('bg-row');
            $('#service_table').DataTable().rows().every(function() {
                var rows = this;
                if (rows.child.isShown()) {
                    rows.child.hide();
                }
            });
            tr.addClass('bg-row');

            row.child(getService(row.data()), 'no-padding bg-row-child').show();
            $('div.slide', row.child()).slideDown("fast");
        }

    });

    function getService(rowData) {
        var div = $('<div class="slide"/>')
            .addClass('loading')
            .text('Loading...');
        $.ajax({
            url: "{{ route('services.show') }}",
            data: {
                id: rowData.id
            },
            dataType: 'html',
            success: function(data) {
                div.html(data).removeClass('loading');
                $('.bg-row-child').attr('data-id', rowData.id)
            },
        });

        return div;
    }
</script>
@endsection
