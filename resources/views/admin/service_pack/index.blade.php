<div class="row">
    <div class="col-lg-12 group-btn">
        <div class="row">
            <div class="input-group col-lg-4">
            </div>
            <div class="col-lg-8 group-btn text-right">
                <button type="button" class="btn btn-primary add_service_pack" data-container=".service_pack_modal"
                data-href="{{ route('service_pack.create') }}"><i class="fa fa-plus"></i> Thêm gói</button>&nbsp;
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="margin-top: 15px">
        <table id="service_pack_table" class="table table-bordered table-hover">
          <thead>
          <tr>
            <th>Tên gói</th>
            <th width="10%">Giá</th>
            <th width="15%">Mua tối thiểu</th>
            <th>Mô tả</th>
            <th>Tiện ích</th>
            <th>Trạng thái</th>
            <th width="15%">Thao tác</th>
          </tr>
          </thead>
        </table>
    </div>
</div>
<script>
 $(document).ready(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var service_pack_table = $('#service_pack_table').DataTable({
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
            url: "{{ route('service_pack.index') }}",
            data: function(d) {
                d.id = $('.bg-row-child').data('id');
            }
        },
        order: [],
        "columns":[
            {"data": "name", class: 'bg-row-child'},
            {"data": "price", class: 'bg-row-child text-center' },
            {"data": "min", class: 'bg-row-child text-center' },
            {"data": "description", class: 'bg-row-child', orderable: false },
            {"data": "addon", class: 'bg-row-child', orderable: false },
            {"data": "status", class: 'bg-row-child text-center' },
            {"data": "action", class: 'bg-row-child', orderable: false}
        ]
    });

    $(document).on('click', '.add_service_pack', function(e) {
        e.preventDefault();
        $('div.service_pack_modal').load($(this).attr('data-href'), function() {
            $('#id_account').attr('value', $('.bg-row-child').data('id'));
            $(this).modal('show');
        });
    });

    $(document).on('click', '.edit_service_pack', function(e) {
        e.preventDefault();
        $('div.service_pack_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

    $('form#service_account_form').submit(function(e) {
        e.preventDefault();
        if ($('form#service_account_form').valid() == true) {
            $('.submit_account').attr('disabled', true);
            let data = new FormData($('#service_account_form')[0]);
            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success == true) {
                        $('.submit_account').removeAttr('disabled');
                        $('div.service_account_add_modal').modal('hide');
                        toastr.success(result.msg);
                        service_pack_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                        $('.submit_account').attr('disabled', false);
                    }
                },
                error: function(err){
                    toastr.error('');
                    $('.submit_account').attr('disabled', false);
                }
            });
        }
    });

    $('form#service_account_edit_form').submit(function(e) {
        e.preventDefault();
        if ($('form#service_account_edit_form').valid() == true) {
            $('.submit_account_edit').attr('disabled', true);
            let data = new FormData($('#service_account_edit_form')[0]);
            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success == true) {
                        $('.submit_account_edit').removeAttr('disabled');
                        $('div.service_account_edit_modal').modal('hide');
                        toastr.success(result.msg);
                        service_pack_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                        $('.submit_account_edit').attr('disabled', false);
                    }
                }
            });
        }
    })

    // delete
    $(document).on('click', '.delete_service_pack', function(e) {
        let name = $(this).data('name');
        let url = $(this).data('href');
        Swal.fire({
            title: 'Bạn muốn xóa gói ' +name,
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
                    service_pack_table.ajax.reload(null, false);
                }
            })
        }
        });
    });
});

function updateForm(el, id){
        let status = 'hide';
        if(el.checked){
            status = 'show';
        }
        $.ajax({
            method: 'POST',
            url: "{{ route('service_pack.update_form') }}",
            data: {
                id: id,
                name: el.value,
                status: status,
            },
            success: function(result) {
                toastr.success(result.msg);
                $('#service_pack_table').DataTable().ajax.reload(null, false);
            }
        })
    }
</script>
