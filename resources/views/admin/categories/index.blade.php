@extends('layouts.master')
@section('title')
    <title>Danh mục</title>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Danh sách danh mục</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Danh sách danh mục</li>
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
                            <button type="button" class="btn btn-primary add_category" data-container=".category_modal"
                            data-href="{{ route('categories.create') }}"><i class="fa fa-plus"></i> Thêm danh mục</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="category_table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Tên danh mục</th>
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
        <div class="modal fade category_modal" id="category_modal" tabindex="-1" role="dialog"></div>
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
            category_table.search($(this).val()).draw();
        }, 500);
    });

    var category_table = $('#category_table').DataTable({
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
            url: "{{ route('categories.index') }}",
        },
        order: [],
        "columns":[
            {"data": "image", orderable: false , class: 'text-center'},
            {"data": "name" },
            {"data": "status", orderable: false , class: 'text-center' },
            {"data": "action", orderable: false}
        ]
    });

    $(document).on('click', '.add_category', function(e) {
        e.preventDefault();
        $('div.category_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

    $(document).on('click', '.edit_category', function(e) {
        e.preventDefault();
        $('div.category_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

     // delete
     $(document).on('click', '.delete_category', function(e) {
        let name = $(this).data('name');
        var url = $(this).data('href');
        Swal.fire({
            title: 'Bạn muốn xóa danh mục ' +name,
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
                    category_table.ajax.reload();
                }
            })
        }
        });
    });
</script>
@endsection
