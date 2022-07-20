@extends('layouts.master')
@section('title')
    <title>Dashboard</title>
@endsection
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Trang chủ</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-soft-success border-top">
                <div class="px-4">
                    <div class="row">
                        <div class="col-xxl-5 align-self-center">
                            <div class="py-4">
                                <h2 class="display-6 coming-soon-text">Xin chào {{ Auth::user()->name }}!</h2>
                                <p class="text-success fs-15 mt-3"></p><p></p>
                                <div class="hstack flex-wrap gap-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="row">
        @foreach ($category as $cate)
            @if($cate->status == 'show')
            <div class="col-lg-6">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 me-1">
                        <i class="menu-icon me-1">
                            <img width="40px" height="40px" src="{{ asset($cate->image ? $cate->image : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                        </i>
                    </div>&nbsp;&nbsp;
                    <div class="flex-grow-1">
                        <h5 class="mb-0 fw-semibold">{{ $cate->name }}</h5>
                    </div>
                </div>
                @foreach ($cate->service as $service)
                @if($service->status == 'show')
                <div class="card">
                    <div class="card-header card-outline card-primary ajax_view" data-toggle="collapse" data-target="#collapseExample{{ $service->id }}">
                        <div class="image">
                            <img src="{{ asset($service->image ? $service->image : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}" class="rounded-circle user-photo" style="width:30px; height:30px; float:left">
                            <h3 class="card-title" style="margin-top:5px; margin-left:10px">{{ $service->name }}</h3>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="collapseExample{{ $service->id }}" class="accordion-collapse collapse">
                            <div class="accordion-body p-2">
                                @foreach ($service->service_pack as $sp)
                                <div class="list-group list-group-fill-success">
                                    <a href="{{ route('order.get-service', $service->slug) }}" class="list-group-item list-group-item-action"><i class="bx bxs-send align-middle me-2"></i>{{ $sp->name }} <span class="badge badge-label bg-primary">Giá {{ number_format($sp->price) }}đ</span></a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
        @endforeach

      </div>

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
