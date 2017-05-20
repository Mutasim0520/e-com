$(document).ready(function () {
    $.validator.setDefaults({
        errorClass: 'help-block',
        highlight:function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight:function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });
    $("#catagory_form").validate({
        rules: {
            catagory_name:{
                required:true,
                remote:{
                    url: '/checkSize'
                }
            }
        },
        messages:{
            catagory_name:{
                remote:"size already exist."
            }
        }
    });

});