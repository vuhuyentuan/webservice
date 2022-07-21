<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Cập nhật trạng thái</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('update.status', $status->id) }}" method="POST" enctype="multipart/form-data" id="update_form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="exampleSelectRounded0">Trạng thái</label>
                            <select class="custom-select rounded-0" name="status" id="exampleSelectRounded0">
                              @foreach (['pending' => 'Đang xử lý', 'running' => 'Đang chạy', 'completed' => 'Hoàn thành', 'cancel' => 'Hủy (hoàn tiền)'] as $key => $value)
                                @if ($status->status == $key)
                                    <option selected value="{{ $key }}">{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                              @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit_update">Cập nhật</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('.select2').select2({
        dropdownParent: $('#update_form')
    });

    $('form#update_form').submit(function(e) {
        e.preventDefault();
        $('.submit_update').attr('disabled', true);
        let data = new FormData($('#update_form')[0]);
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false,
            success: function(result) {
                if (result.success == true) {
                    $('.submit_update').removeAttr('disabled');
                    $('div.status_modal').modal('hide');
                    toastr.success(result.msg);
                    if (typeof($('#purchase_history_table').DataTable()) != 'undefined') {
                        $('#purchase_history_table').DataTable().ajax.reload();
                    }
                } else {
                    toastr.error(result.msg);
                    $('.submit_update').attr('disabled', false);
                }
            }
        });
    });
</script>
