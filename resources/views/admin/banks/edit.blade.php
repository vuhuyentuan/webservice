<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Cập nhật thông tin tài khoản</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('banks.update', $bank->id) }}" method="POST" enctype="multipart/form-data" id="bank_edit_form">
            @method('PUT')
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Họ và Tên</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="account_name" id="account_name" placeholder="Họ và tên" value="{{ $bank->account_name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Số tài khoản</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="account_number" id="account_number" placeholder="Số tài khoản" value="{{ $bank->account_number }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Tên ngân hàng</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Số tài khoản" value="{{ $bank->bank_name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Chi nhánh</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="branch" id="branch" placeholder="Chi nhánh" value="{{ $bank->branch }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Hình ảnh</label> <br>
                            <div class="input-group">
                                <input id="fImages" type="file" name="image" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                                <img id="img" class="img" style="width: 100px; height: 100px;" src="{{ asset($bank->image ? $bank->image : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit_edit">Cập nhật</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </form>
    </div>
</div>
<script>
    function changeImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
        $('#img').click(function() {
        $('#fImages').click();
    });

    $('form#bank_edit_form').validate({
        rules: {
            "account_name": {
                required: true,
                maxlength: 50
            },
            "account_number": {
                required: true,
                maxlength: 20
            },
            "bank_name": {
                required: true,
                maxlength: 20
            },
            "branch": {
                // required: true,
                maxlength: 255
            },
        },
        messages: {
            "account_name": {
                required: 'Vui lòng không để trống',
                maxlength: 'Giới hạn 50 ký tự'
            },
            "account_number": {
                required: 'Vui lòng không để trống',
                maxlength: 'Giới hạn 20 ký tự'
            },
            "bank_name": {
                required: 'Vui lòng không để trống',
                maxlength: 'Giới hạn 20 ký tự'
            },
            "branch": {
                // required: 'Vui lòng không để trống',
                maxlength: 'Giới hạn 255 ký tự'
            },
        }
    });

    $('form#bank_edit_form').submit(function(e) {
        e.preventDefault();
        if ($('form#bank_edit_form').valid() == true) {
            $('.submit_edit').attr('disabled', true);
            let data = new FormData($('#bank_edit_form')[0]);
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
                        $('div.bank_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#bank_table').DataTable()) != 'undefined') {
                            $('#bank_table').DataTable().ajax.reload(null, false);
                        }
                    } else {
                        toastr.error(result.msg);
                        $('.submit_edit').attr('disabled', false);
                    }
                },
                error: function(err) {
                    if (err.status == 422) {
                        $('#category-error').html('');
                        $.each(err.responseJSON.errors, function(i, error) {
                            $(document).find('[name="' + i + '"]').after($('<span id="category-error" class="error">' + error + '</span>'));
                        });
                    }
                    $('.submit_edit').attr('disabled', false);
                }
            });
        }
    });
</script>
