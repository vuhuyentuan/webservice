<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Thêm gói dịch vụ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('service_pack.store') }}" method="POST" enctype="multipart/form-data" id="service_pack_add_form">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" id="id_account">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Tên gói<b class="text-danger">*</b></label>
                            <input type="text" class="form-control" name="name" placeholder="Tên gói">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleSelectRounded0">Trạng thái</label>
                            <select class="custom-select rounded-0" name="status" id="exampleSelectRounded0">
                              <option value="show">Hiển thị</option>
                              <option value="hide">Ẩn</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Giá<b class="text-danger">*</b></label>
                            <input type="text" class="form-control price" name="price" value="0">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Mua tối thiểu<b class="text-danger">*</b></label>
                            <input type="text" class="form-control" name="min" value="1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="margin-left:-6px;margin-right:-6px">
                            <div class="card-header" style="background-color: #ececee">
                                <h3 class="card-title"><b>Mô tả</b></h3>
                            </div>
                            <div class="card-body p-0" style="display: block;">
                                <div class="row">
                                    <div class="col-12">
                                        <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit_add">Lưu</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </form>
    </div>
</div>
<script>
    function formatNumber(num) {
        var n = Number(num.replace(/,/g, ''));
        return n.toLocaleString("en");
    }
    $('.price').on('keyup', function() {
        var num = $(this).val().replace(/[^0-9]+/i, '');

        if (num != '') {
            let money = formatNumber(num);

            $(this).val(money)
        } else {
            $(this).val(0)
        }
    });
    $('form#service_pack_add_form').validate({
        rules: {
            "name": {
                required: true,
                maxlength: 190
            },
            "min": {
                required: true,
                number: true,
                min: 1
            }
        },
        messages: {
            "name": {
                required: 'Vui lòng không để trống',
                maxlength: 'Giới hạn 190 ký tự'
            },
            "min": {
                required: 'Vui lòng không để trống',
                number: 'Chỉ được nhập số',
                min: 'Giá trị phải lớn hơn 1'
            }
        }
    });

    $('form#service_pack_add_form').submit(function(e) {
        e.preventDefault();
        if ($('form#service_pack_add_form').valid() == true) {
            $('.submit_add').attr('disabled', true);
            let data = new FormData($('#service_pack_add_form')[0]);
            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success == true) {
                        $('.submit_add').removeAttr('disabled');
                        $('div.service_pack_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#service_pack_table').DataTable()) != 'undefined') {
                            $('#service_pack_table').DataTable().ajax.reload();
                        }
                    } else {
                        toastr.error(result.msg);
                        $('.submit_add').attr('disabled', false);
                    }
                },
                error: function(err) {
                    if (err.status == 422) {
                        $('.error').html('');
                        $.each(err.responseJSON.errors, function(i, error) {
                            $(document).find('[name="' + i + '"]').after($('<span class="error">' + error + '</span>'));
                        });
                    }
                    $('.submit_add').attr('disabled', false);
                }
            });
        }
    });
</script>
