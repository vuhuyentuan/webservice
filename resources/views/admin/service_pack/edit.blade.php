<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('edit_account') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('service_account.update') }}" method="POST" enctype="multipart/form-data" id="service_account_edit_form">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" id="id_account_edit">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('account') }} </label>
                            <textarea class="form-control" id="data_account_edit" name="data_account" rows="5"  style="padding:10px; width:100%;border: 1px solid #9d9e9f;border-radius: 5px;"></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit_account_edit">{{ __('save') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('close') }}</button>
            </div>
        </form>
    </div>
</div>
