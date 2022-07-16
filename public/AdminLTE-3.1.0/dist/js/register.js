$(document).ready(function() {
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            if (regexp.constructor != RegExp)
                regexp = new RegExp(regexp);
            else if (regexp.global)
                regexp.lastIndex = 0;
            return this.optional(element) || regexp.test(value);
        },
    );
    $('form#register_form').validate({
        rules: {
            "name": {
                required: true,
                maxlength: 190
            },
            "email": {
                required: true,
                email: true,
                maxlength: 190
            },
            "username": {
                required: true,
                maxlength: 190,
                minlength: 6,
                regex: /^\S*$/
            },
            "password": {
                required: true,
                maxlength: 190

            },
            "confirm_password": {
                required: true,
                equalTo: "#password",
                maxlength: 190

            }
        },
        messages: {
            "name": {
                required: 'Vui lòng không để trống',
                maxlength: 'Giới hạn 190 ký tự'
            },
            "email": {
                required: 'Vui lòng không để trống',
                email: 'Không đúng định dạng email',
                maxlength: 'Giới hạn 190 ký tự'
            },
            "username": {
                required: 'Vui lòng không để trống',
                maxlength: 'Giới hạn 190 ký tự',
                minlength: 'Ít nhất 6 ký tự',
                regex: 'Vui lòng không nhập khoảng trắng'
            },
            "password": {
                required: 'Vui lòng không để trống',
                maxlength: 'Giới hạn 190 ký tự'
            },
            "confirm_password": {
                required: 'Vui lòng không để trống',
                equalTo: 'Xác nhận không chính xác',
                maxlength: 'Giới hạn 190 ký tự'
            }
        }
    });

    $(document).on('change', '#username', function() {
        $('#username-error').html('')
    })

    $(document).on('click', '.register', function() {
        if ($('form#register_form').valid() == true) {
            $('.register').attr('disabled', true)
            var url = $('form#register_form').attr('action');
            var data = $('form#register_form').serialize();
            $.ajax({
                method: 'POST',
                url: url,
                dataType: 'json',
                data: data,
                success: function(result) {
                    toastr.success('Đăng ký thành công');
                    if (result.success == true) {
                        if(result.data == 0){
                            window.location = window.location.origin +'/info';
                        }
                    }
                },
                error: function(err) {
                    $('.register').attr('disabled', false)
                    var data = err.responseJSON;
                    if (err.status == 422) {
                        if ($.isEmptyObject(data.errors) == false) {
                            $.each(data.errors, function(key, value) {
                                $('#'+key+'-error').text('');
                                $(document).find('#username').after($('<span id="'+key+'-error" class="error">' + value + '</span>'));
                            });
                        }
                    }
                }
            });
        }
    })
})
