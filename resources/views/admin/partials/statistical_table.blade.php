<table id="statistical_table" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center; ">Ngày</th>
            <th style="text-align: center; ">Doanh thu</th>
        </tr>
    </thead>
    <tbody id="statistical_content">
        @for ($i = 0; $i < count($arrRevenueMonthDone); $i++)
            <tr role="row">
                <td style="text-align: center">
                    <h6>{{ date('d/m/Y', strtotime($dates[$i])) }}</h6>
                </td>
                <td style="text-align: center">
                    <h6>{{ $arrRevenueMonthDone[$i] }} VNĐ </h6>
                </td>
            </tr>
        @endfor
    </tbody>
</table>
<script>
    $(document).ready(function(){
        $('#statistical_table').DataTable({
            "destroy": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 15,
            "pagingType": "full_numbers",
            "language": {
                "info": 'Hiển thị _START_ đến _END_ của _TOTAL_ mục',
                "infoEmpty": 'Hiển thị 0 đến 0 của 0 mục',
                "infoFiltered": '',
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": 'Hiển thị _MENU_ mục',
                "loadingRecords": 'Đang tải...',
                "processing": 'Đang xử lý...',
                "emptyTable": 'Không có dữ liệu',
                "zeroRecords": 'Không tìm thấy kết quả',
                "search": 'Tìm kiếm',
                "paginate": {
                    'first': '<i class="fa fa-angle-double-left"></i>',
                    'previous': '<i class="fa fa-angle-left" ></i>',
                    'next': '<i class="fa fa-angle-right" ></i>',
                    'last': '<i class="fa fa-angle-double-right"></i>'
                },
            }
        });
    })
</script>
