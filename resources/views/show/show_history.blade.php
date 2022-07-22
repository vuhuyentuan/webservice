
<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="history_tab" data-toggle="pill" href="#history_tab" data-toggle="tab">Chi tiết</a>
        </li>
    </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="history_purchase">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="form-group row">
                    <div class="col-md-6 col-lg-4 col-5">
                        <strong>Mã đơn hàng:</strong>
                    </div>
                    <div class="col-md-6 col-lg-8 col-7">
                        {{ $service_bill->order_code }}
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-6 col-lg-4 col-5">
                        <strong>Dịch vụ:</strong>
                    </div>
                    <div class="col-md-6 col-lg-8 col-7">
                        {{ $service_bill->service->name.' - '. $service_bill->service_pack->name}}
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-6 col-lg-4 col-5">
                        <strong>Số lượng:</strong>
                    </div>
                    <div class="col-md-6 col-lg-8 col-7">
                        {{ number_format($service_bill->quantity) }}
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-6 col-lg-4 col-5">
                        <strong>Số tiền:</strong>
                    </div>
                    <div class="col-md-6 col-lg-8 col-7">
                        {{ number_format($service_bill->amount) }} đ
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="form-group row">
                    <div class="col-md-6 col-lg-4 col-5">
                        <strong>URL/ID:</strong>
                    </div>
                    <div class="col-md-6 col-lg-8 col-7">
                        {{ $service_bill->url }}
                    </div>
                  </div>
                  @if($service_bill->feeling)
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-4 col-5">
                            <strong>Cảm xúc:</strong>
                        </div>
                        <div class="col-md-6 col-lg-8 col-7">
                            <img src="{{ asset('icon/'.$service_bill->feeling.'.png') }}" class="rounded-circle user-photo" style="width:30px; height:30px;">
                        </div>
                    </div>
                  @endif
                  @if($service_bill->eyes)
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-4 col-5">
                            <strong>Thời gian:</strong>
                        </div>
                        <div class="col-md-6 col-lg-8 col-7">
                            {{ $service_bill->eyes }} phút
                        </div>
                    </div>
                  @endif
                  @if($service_bill->vip_date)
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-4 col-5">
                            <strong>Thời hạn:</strong>
                        </div>
                        <div class="col-md-6 col-lg-8 col-7">
                            {{ $service_bill->eyes }} ngày
                        </div>
                    </div>
                  @endif
                  @if($service_bill->comment)
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-4 col-5">
                            <strong>Bình luận:</strong>
                        </div>
                        <div class="col-md-6 col-lg-8 col-7" style="max-height: calc(100vh - 500px); overflow-y: auto; background-color: #dbe6e6">
                            @foreach (json_decode($service_bill->comment) as $comment)
                                {{ $comment }} <br>
                            @endforeach
                            {{-- <textarea class="form-control col-lg-12" rows="10" style="width:100%;border: 1px solid #9d9e9f;border-radius: 5px;" readonly>

                            </textarea> --}}
                        </div>
                    </div>
                  @endif
                  <div class="form-group row">
                    <div class="col-md-6 col-lg-4 col-5">
                        <strong>Ghi chú</strong>
                    </div>
                    <div class="col-md-6 col-lg-8 col-7">
                        {{ $service_bill->note }}
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</div>

