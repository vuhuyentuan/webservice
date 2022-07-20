$(document).on('click', 'input[name="service_pack"]:checked', function(){
    let id = $(this).val();
    $.get('/service-pack/'+id, function(data){
        $('#type_content').html('');
        if(data.service_pack.feeling == 'show'){
            $('#type_content').html(data.type_html);
            $('#quantity_content').html(data.quantity_html);
        }else if(data.service_pack.comment == 'show'){
            $('#type_content').html(data.type_html);
            $('#quantity_content').html('');
        }else if (data.service_pack.eyes == 'show'){
            $('#type_content').html(data.type_html);
            $('#quantity_content').html(data.quantity_html);
        }
        if(data.service_pack.vip == 'show'){
            $('#vip_content').html(data.vip_html);
        }else{
            $('#vip_content').html('');
        }
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

function total(){
    let total = 0;
    let service_pack = $('#order_form').find("input[name=service_pack]:checked").attr('data-price');
    if($('#feeling').length > 0){
        total = service_pack
    }else if($('#comment').length > 0){
        let lineCount = 0;
        var lines = $('#comment').val().split("\n");
        for (var i = 0; i < lines.length; i++) {
            if (lines[i].length > 0) lineCount++;
        }
        total = service_pack * lineCount
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
        total = total * quantity
    }
    if($('#vip').length > 0){
        let day_number = $('#vip').val();
        total = total * day_number
    }
    $('#total').html(`${total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}đ`);
}

$('form#order_form').submit(function(e) {
    e.preventDefault();
    $('#order_submit').attr('disabled', true);
    let data = new FormData($('#order_form')[0]);
    $.ajax({
        method: 'POST',
        url: $(this).attr('action'),
        dataType: 'json',
        data: data,
        contentType: false,
        processData: false,
        success: function(result) {
            if (result.success == true) {
                $('.submit_add').attr('disabled', false);
                toastr.success(result.msg);
            } else {
                toastr.error(result.msg);
                $('.submit_add').attr('disabled', false);
            }
        },
        error: function(err) {
            if (err.status == 422) {
                $('#account-number-error').html('');
                $.each(err.responseJSON.errors, function(i, error) {
                    if(i == 'account_number'){
                        $(document).find('[name="' + i + '"]').after($('<label id="account-number-error" class="error">' + error + '</label>'));
                    }
                });
            }
            $('#order_submit').attr('disabled', false);
        }
    });
});
