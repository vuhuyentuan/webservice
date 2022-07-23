<span class="dropdown-item dropdown-header">
    <span class="float-left text-muted text-sm">Có {{ $count }} đơn hàng</span>
    <a href="#" style="color: rgb(35, 138, 216)" class="float-right text-muted text-sm markAllAsRead">Đánh dấu đã đọc</a>
</span>
@foreach ($notifications as $notifi)
@php
    $active = '';
    $noti = json_decode($notifi['data'])->notification;
    if(empty($notifi->read_at)){
        $active = 'text-bold';
    }
@endphp
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item" style="color: rgb(35, 138, 216)">
    <p class="{{ $active }} mess" style="word-wrap: break-word">{{ $noti->message }}</p>
</a>
@endforeach
{{-- <div class="dropdown-divider"></div>
<a href="#" class="dropdown-item dropdown-footer">Xem tất cả đơn hàng</a> --}}
