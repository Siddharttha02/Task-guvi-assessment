$(document).ready(function () {
    function fetchUserData() {
        $.ajax({
            url: 'php/profile.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.isLoggedIn) {
                    const user = data.user;
                    const dob = new Date(user.dob);
                    const today = new Date();
                    const age = today.getFullYear() - dob.getFullYear();
                    const userData = `
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Hello, ${user.name}</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Email: ${user.email}</li>
                                    <li class="list-group-item">Phone Number: ${user.phone}</li>
                                    <li class="list-group-item">Date of Birth: ${user.dob}</li>
                                    <li class="list-group-item">Address: ${user.address}</li>
                                </ul>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-3">
                                    <a href="updateprofile.html" class="btn btn-primary me-md-2">Update</a>
                                    <a href="php/logout.php" class="btn btn-primary">Log out</a>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#userData').html(userData);
                } else {
                    const loginOptions = `
                        <div class="d-flex justify-content-center mt-3">
                            <a href="index.html" class="btn btn-primary me-2">Log in</a>
                            <p class="align-self-center"> or </p>
                            <a href="register.html" class="btn btn-secondary ms-2">Sign up</a>
                        </div>
                    `;
                    $('#userData').html(loginOptions);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    fetchUserData();
});