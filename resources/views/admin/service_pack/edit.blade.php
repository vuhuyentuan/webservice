<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Sửa gói dịch vụ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('service_pack.update') }}" method="POST" enctype="multipart/form-data" id="service_pack_edit_form">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value="{{ $service_pack->id }}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Tên gói<b class="text-danger">*</b></label>
                            <input type="text" class="form-control" name="name" placeholder="Tên gói" value="{{ $service_pack->name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleSelectRounded0">Trạng thái</label>
                            <select class="custom-select rounded-0" name="status" id="exampleSelectRounded0">
                                @foreach (['show' => 'Hiển thị', 'hide' => 'Ẩn'] as $key => $value)
                                @if($service_pack->status == $key)
                                    <option selected value="{{ $key }}">{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Giá<b class="text-danger">*</b></label>
                            <input type="text" class="form-control price" name="price" value="{{ number_format($service_pack->price) }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Mua tối thiểu<b class="text-danger">*</b></label>
                            <input type="text" class="form-control" name="min" value="{{ $service_pack->min }}">
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
                                        <textarea name="description" id="description" class="form-control" rows="5">{{ $service_pack->description }}</textarea>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit_edit">Lưu</button>
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
    $('form#service_pack_edit_form').validate({
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

    $('form#service_pack_edit_form').submit(function(e) {
        e.preventDefault();
        if ($('form#service_pack_edit_form').valid() == true) {
            $('.submit_edit').attr('disabled', true);
            let data = new FormData($('#service_pack_edit_form')[0]);
            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success == true) {
                        $('.submit_edit').removeAttr('disabled');
                        $('div.service_pack_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#service_pack_table').DataTable()) != 'undefined') {
                            $('#service_pack_table').DataTable().ajax.reload();
                        }
                    } else {
                        toastr.error(result.msg);
                        $('.submit_edit').attr('disabled', false);
                    }
                },
                error: function(err) {
                    if (err.status == 422) {
                        $('.error').html('');
                        $.each(err.responseJSON.errors, function(i, error) {
                            $(document).find('[name="' + i + '"]').after($('<span class="error">' + error + '</span>'));
                        });
                    }
                    $('.submit_edit').attr('disabled', false);
                }
            });
        }
    });
</script>
