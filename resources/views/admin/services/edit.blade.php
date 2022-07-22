<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Sửa dịch vụ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('services.update') }}" method="POST" enctype="multipart/form-data" id="service_edit_form">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value="{{ $service->id }}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Tên dịch vụ</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Tên dịch vụ" value="{{ $service->name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleSelectRounded0">Trạng thái</label>
                            <select class="custom-select rounded-0" name="status" id="exampleSelectRounded0">
                                @foreach (['show' => 'Hiển thị', 'hide' => 'Ẩn'] as $key => $value)
                                    @if($service->status == $key)
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
                    <div class="col-lg-12">
                        <div class="form-group">
                          <label for="company_id">Danh mục</label><b class="text-danger">*</b><br>
                          <select class="form-control select2" name="category_id" id="category_id" style="width: 100%;">
                            <option value="">--Chọn danh mục--</option>
                            @foreach ($categories as $key => $value)
                                @if($service->category_id == $key)
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
                            <label class="form-control-label" for="basic-url">Icon</label> <br>
                            <div class="input-group">
                                <input id="fImages" type="file" name="image" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                                <img id="img" class="img" style="width: 100px; height: 100px;" src="{{ asset($service->image ? $service->image : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                            </div>
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
                                        <textarea name="description" id="description" class="form-control" rows="10">{{ $service->description }}</textarea>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
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
    $(function () {
        $('#description').summernote();
    })
    $('.select2').select2({
        dropdownParent: $('#service_edit_form')
    });
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

    $('form#service_edit_form').validate({
        rules: {
            "name": {
                required: true,
                maxlength: 190
            },
            "category_id": {
                required: true,
            }
        },
        messages: {
            "name": {
                required: 'Vui lòng không để trống',
                maxlength: 'Giới hạn 190 ký tự'
            },
            "category_id": {
                required: 'Vui lòng chọn danh mục',
            }
        }
    });

    $('form#service_edit_form').submit(function(e) {
        e.preventDefault();
        if ($('form#service_edit_form').valid() == true) {
            $('.submit_edit').attr('disabled', true);
            let data = new FormData($('#service_edit_form')[0]);
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
                        $('div.service_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#service_table').DataTable()) != 'undefined') {
                            $('#service_table').DataTable().ajax.reload(null, false);
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
