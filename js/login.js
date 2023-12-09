$(document).ready(function () {
    $('#loginForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'php/login.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else if (data.is_invalid) {
                    $('#loginMessage').html('<em>Invalid login</em>');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
});