$(document).ready(function () {
    function fetchUserData() {
        $.ajax({
            url: 'php/update.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var user = data.user;
                $('#name').val(user.name);
                $('#email').val(user.email);
                $('#phone').val(user.phone);
                $('#dob').val(user.dob);
                $('#address').val(user.address);

                if (data.is_updated) {
                    $('#updateMessage').html('<h1>Information updated successfully!</h1>');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    fetchUserData();

    $('#updateButton').click(function () {
        $.ajax({
            url: 'php/update.php',
            type: 'POST',
            data: $('#updateForm').serialize(),
            dataType: 'json',
            success: function () {
                fetchUserData();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
});