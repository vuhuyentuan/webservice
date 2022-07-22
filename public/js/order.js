let type
let vip
$(document).on('click', 'input[name="service_pack"]:checked', function(){
    let id = $(this).val();
    $.get('/service-pack/'+id, function(data){
        $('#type_content').html('');
        if(data.service_pack.feeling == 'show'){
            $('#type_content').html(data.type_html);
            $('#quantity_content').html(data.quantity_html);
            type = 'feeling'
        }else if(data.service_pack.comment == 'show'){
            $('#type_content').html(data.type_html);
            $('#quantity_content').html('');
            type = 'comment'
        }else if (data.service_pack.eyes == 'show'){
            $('#type_content').html(data.type_html);
            $('#quantity_content').html(data.quantity_html);
            type = 'eyes'
        }
        if(data.service_pack.vip == 'show'){
            $('#vip_content').html(data.vip_html);
            vip = 'vip'
        }else{
            $('#vip_content').html('');
        }
        $('#description').html(data.service_pack.description);
        total();
    });

});
$(document).on('keyup', '#quantity', function () {
    total();
});
$(document).on('keyup', '#comment', function () {
    total();
});
$(document).on('change', '#vip', function () {
    total();
});

let total_amount = 0;
let total_lines = 0;
function total(){
    let total = 0;
    let service_pack = $('#order_form').find("input[name=service_pack]:checked").attr('data-price');
    total = service_pack
    if($('#comment').length > 0){
        let lineCount = 0;
        var lines = $('#comment').val().split("\n");
        for (var i = 0; i < lines.length; i++) {
            if (lines[i].length > 0) lineCount++;
        }
        total_lines = lineCount;
        total = service_pack * lineCount;
    }else if($('#eyes').length > 0){
        let eyes = $('#eyes').val();
        if(eyes == ''){
            eyes = 0;
        }
        total = service_pack * eyes;
    }
    if($('#quantity').length > 0){
        let quantity = $('#quantity').val();
        if(quantity == ''){
            quantity = 0;
        }
        total = total * quantity;
    }
    if($('#vip').length > 0){
        let day_number = $('#vip').val();
        total = total * day_number;
    }
    total_amount = total
    $('#total').html(`${total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}đ`);
}

$('form#order_form').submit(function(e) {
    e.preventDefault();
    let service_pack_name = $('#order_form').find("input[name=service_pack]:checked").attr('data-name');
    $('#order_submit').attr('disabled', true);
    let data = new FormData($('#order_form')[0]);
    data.append('amount', total_amount);
    data.append('total_lines', total_lines);
    data.append('service_pack_name', service_pack_name);
    data.append('type', type);
    data.append('vip', vip);
    $.ajax({
        method: 'POST',
        url: $(this).attr('action'),
        dataType: 'json',
        data: data,
        contentType: false,
        processData: false,
        success: function(result) {
            if (result.success == true) {
                $('#order_submit').attr('disabled', false);
                toastr.options = {
                    "progressBar": true,
                    "timeOut": "2000",
                    }
                toastr.success(result.msg);
                setTimeout(redirect, 2000);
            } else {
                toastr.error(result.msg);
                $('#order_submit').attr('disabled', false);
            }
        },
    });
});
function redirect(){
    window.location="/user-order-history";
}
