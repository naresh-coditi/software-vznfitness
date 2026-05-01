$(document).ready(function(){
    $("#createUserForm").validate({
        rules: {
            first_name: {
                required: true,
            },
            gender: {
                required: true,
            },
            phone: {
                required: true,
                numeric: true,
                minlength: 10,
                maxlength: 10,
            },
            branch: {
                required: true,
            },
            password: {
                required: true,
            },
            confirn_password: {
                required: true,
            },
            address: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: 'First Name field is required',
            },
            gender: {
                required: 'Select any one gender',
            },
            role: {
                required: 'Select any role',
            },
            phone: {
                required: 'Phone field is required',
                numeric: 'Phone field must be number',
                minlength: 'Maximum length is 10',
                maxlength: 'Minmum length is 10',
            },
            branch: {
                required: 'Select any one branch',
            },
            password: {
                required: 'Password field is required',
            },
            confirn_password: {
                required: 'Confirm password field is required',
            },
            address: {
                required: 'Address field is required',
            },
        },

        // errorPlacement: function(error, element) {
        //     switch (element.attr("name")) {
        //         case "shippingFullName":
        //             error.appendTo("#shippingFullName-error");
        //             break;
        //         case "phone_number":
        //             error.appendTo("#phone_number-error");
        //             break;
        //         case "city":
        //             error.appendTo("#city-error");
        //             break;
        //         case "country":
        //             error.appendTo("#country-error");
        //             break;
        //         case "shippingAddress2":
        //             error.appendTo("#shippingAddress2-error");
        //             break;
        //         case "zip":
        //             error.appendTo("#zip-error");
        //             break;
        //         default:
        //             error.insertAfter(element);
        //             break;
        //     }
        // },
    });
});
