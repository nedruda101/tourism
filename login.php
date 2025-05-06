<style>
    #uni_modal .modal-content>.modal-footer,
    #uni_modal .modal-content>.modal-header {
        display: none;
    }

    .container-fluid {
        width: 1200px;
        max-width: 100%;
        margin: 0 auto;
        height: 500px;
        max-height: 100%;
    }

    .wrapper {
        position: relative;
        overflow: hidden;
        height: 450px;
        width: 500px;
        margin: 0 auto;
    }

    .login-section,
    .register-section {
        position: absolute;
        transition: all 0.5s ease;
        width: 100%;
        padding: 20px;
    }

    .login-section {
        left: 0;
    }

    .register-section {
        left: 100%;
    }

    .wrapper.register-active .login-section {
        left: -100%;
    }

    .wrapper.register-active .register-section {
        left: 0;
    }

    .auth-input {
        border: 1px solid #dddfe2;
        border-radius: 6px;
        padding: 12px 14px;
        font-size: 16px;
        margin-bottom: 10px;
        background-color: #f5f6f5;
        width: 100%;
        height: 50px;
    }

    .auth-input:focus {
        outline: none;
        border-color: #1877f2;
        background-color: #fff;
        box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
    }

    .auth-btn {
        background-color: #1877f2;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 600;
        width: 120px;
    }

    .auth-btn:hover {
        background-color: #166fe5;
    }

    .auth-btn.secondary {
        background-color: #e4e6eb;
        color: #1c1e21;
    }

    .auth-btn.secondary:hover {
        background-color: #d8dade;
    }

    .auth-link {
        color: #1877f2;
        font-size: 14px;
        text-decoration: none;
        padding: 0;
    }

    .auth-link:hover {
        text-decoration: underline;
        color: #166fe5;
    }

    h3.text-center {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #1c1e21;
    }

    hr {
        border-color: #dddfe2;
    }
</style>

<div class="container-fluid">
    <h3 class="float-left">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </h3>
    <div class="row wrapper">
        <div class="col-lg-5 border-right login-section">
            <hr>
            <form action="" id="login-form">
                <div class="form-group">
                    <input type="text" class="form-control auth-input" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control auth-input" name="password" placeholder="Password" required>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <button type="button" class="btn btn-link auth-link" onclick="shiftToRegister()">Create Account</button>
                    <button class="btn auth-btn">Log In</button>
                </div>
            </form>
        </div>
        <div class="col-lg-7 register-section">
            <h3 class="text-center">Create New Account</h3>
            <hr class='border-primary'>
            <form action="" id="registration">
                <div class="form-group">
                    <input type="text" class="form-control auth-input" name="firstname" placeholder="First name" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control auth-input" name="lastname" placeholder="Last name" required>
                </div>
                <div class="form-group">
                    <input type="text" class=" form-control auth-input" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control auth-input" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="preference">Select your preferences:</label>
                    <div class="btn-group" id="preference" role="group" aria-label="Preferences">
                        <input type="checkbox" class="btn-check" id="nature_trip" name="preference[]" value="nature_trip" autocomplete="off">
                        <label class="btn btn-outline-primary" for="nature_trip">Nature Trip</label>

                        <input type="checkbox" class="btn-check" id="food_trip" name="preference[]" value="food_trip" autocomplete="off">
                        <label class="btn btn-outline-primary" for="food_trip">Food Trip</label>

                        <input type="checkbox" class="btn-check" id="hiking" name="preference[]" value="hiking" autocomplete="off">
                        <label class="btn btn-outline-primary" for="hiking">Hiking</label>
                    </div>
                </div>

                <div class="form-group d-flex justify-content-between">
                    <button type="button" class="btn btn-link auth-link" onclick="shiftToLogin()">Back to Login</button>
                    <button class="btn auth-btn">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function shiftToRegister() {
        document.querySelector('.wrapper').classList.add('register-active');
    }

    function shiftToLogin() {
        document.querySelector('.wrapper').classList.remove('register-active');
    }

    $(function() {
        $('#registration').submit(function(e) {
            e.preventDefault();
            start_loader();
            if ($('.err-msg').length > 0) $('.err-msg').remove();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=register",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.log(err);
                    alert_toast("an error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        // Show success message but don't reload
                        alert_toast("Account successfully registered", 'success');
                        // Reset the form instead of reloading
                        $('#registration')[0].reset();
                        // Optionally switch back to login view
                        setTimeout(function() {
                            shiftToLogin();
                        }, 2000);
                        end_loader();
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var _err_el = $('<div>');
                        _err_el.addClass("alert alert-danger err-msg").text(resp.msg);
                        $('#registration').prepend(_err_el);
                        end_loader();
                    } else {
                        console.log(resp);
                        alert_toast("an error occurred", 'error');
                        end_loader();
                    }
                }
            });
        });

        $('#login-form').submit(function(e) {
            e.preventDefault();
            start_loader();
            if ($('.err-msg').length > 0) $('.err-msg').remove();
            $.ajax({
                url: _base_url_ + "classes/Login.php?f=login_user",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.log(err);
                    alert_toast("an error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        alert_toast("Login Successfully", 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else if (resp.status == 'incorrect') {
                        var _err_el = $('<div>');
                        _err_el.addClass("alert alert-danger err-msg").text("Incorrect Credentials.");
                        $('#login-form').prepend(_err_el);
                        end_loader();
                    } else {
                        console.log(resp);
                        alert_toast("an error occurred", 'error');
                        end_loader();
                    }
                }
            });
        });
    });
</script>