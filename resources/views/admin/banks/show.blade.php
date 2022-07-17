
<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="service_pack_tab" data-toggle="pill" href="#service_pack_tab" data-href="{{route('service_pack.index')}}" data-toggle="tab">Gói dịch vu</a>
        </li>
    </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="service_pack">
            @include('admin.service_pack.index')
        </div>
    </div>
    <!-- /.card -->
</div>

