<span class="dropdown-item dropdown-header">
    Có {{ $count }} đơn hàng
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
<a href="#" class="dropdown-item">
    <p class="{{ $active }} mess" style="word-wrap: break-word;color: rgb(35, 138, 216)">{{ $noti->message }}</p>
</a>
@endforeach
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item dropdown-footer markAllAsRead">Đánh dấu đã đọc</a>
