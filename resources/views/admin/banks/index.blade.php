@extends('layouts.master')
@section('title')
    <title>Tài khoản bank</title>
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
          <h1 class="m-0">Danh sách tài khoản ngân hàng</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Danh sách tài khoản ngân hàng</li>
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
                            <button type="button" class="btn btn-primary add_bank" data-container=".bank_modal"
                            data-href="{{ route('banks.create') }}"><i class="fa fa-plus"></i> Thêm tài khoản</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="bank_table" class="table table-bordered table-hover ajax_view">
                    <thead>
                        <tr>
                            <th style="width: 14%">Hình ảnh</th>
                            <th style="width: 20%">Họ và tên</th>
                            <th style="width: 18%">Số tài khoản</th>
                            <th style="width: 18%">Tên ngân hàng</th>
                            <th style="width: 18%">Chi nhánh</th>
                            <th style="width: 12%">Thao tác</th>
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
        <div class="modal fade bank_modal" id="bank_modal" tabindex="-1" role="dialog"></div>
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
            bank_table.search($(this).val()).draw();
        }, 500);
    });

    var bank_table = $('#bank_table').DataTable({
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
            url: "{{ route('banks.index') }}",
        },
        order: [],
        "columns":[
            {"data": "image", orderable: false , class: 'text-center'},
            {"data": "account_name" },
            {"data": "account_number" },
            {"data": "bank_name" },
            {"data": "branch" },
            {"data": "action", orderable: false}
        ]
    });

    $(document).on('click', '.add_bank', function(e) {
        e.preventDefault();
        $('div.bank_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

    $(document).on('click', '.edit_bank', function(e) {
        e.preventDefault();
        $('div.bank_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

     // delete
     $(document).on('click', '.delete_bank', function(e) {
        let account_number = $(this).data('account-number');
        var url = $(this).data('href');
        Swal.fire({
            title: 'Bạn muốn xóa số tài khoản ' + account_number + '?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            cancelButtonText: "Hủy",
            confirmButtonText: "Xóa",
        }).then((result) => {
        if (result.value) {
            $.ajax({
                method: "DELETE",
                url: url,
                dataType: "json",
                success: function(result) {
                    if (result.success == true) {
                        toastr.success(result.msg);
                    }else{
                        toastr.error(result.msg);
                    }
                    bank_table.ajax.reload(null, false);
                }
            })
        }
        });
    });
</script>
@endsection
