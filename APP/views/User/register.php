<!-- Registration form -->
<form action="/user/register" method="post" class="login-form">
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <h5 class="mb-0">Create account</h5>
                <span class="d-block text-muted">All fields are required</span>
            </div>

            <div class="form-group text-center text-muted content-divider">
                <span class="px-2">Your credentials</span>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="text" class="form-control" placeholder="Username">
                <div class="form-control-feedback">
                    <i class="icon-user-check text-muted"></i>
                </div>
                <span class="form-text text-danger"><i class="icon-cancel-circle2 mr-2"></i> This username is already taken</span>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="password" class="form-control" placeholder="Password">
                <div class="form-control-feedback">
                    <i class="icon-user-lock text-muted"></i>
                </div>
            </div>

            <div class="form-group text-center text-muted content-divider">
                <span class="px-2">Your contacts</span>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="password" class="form-control" placeholder="Your email">
                <div class="form-control-feedback">
                    <i class="icon-mention text-muted"></i>
                </div>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="password" class="form-control" placeholder="Repeat email">
                <div class="form-control-feedback">
                    <i class="icon-mention text-muted"></i>
                </div>
            </div>

            <div class="form-group text-center text-muted content-divider">
                <span class="px-2">Additions</span>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" name="remember" class="form-input-styled" data-fouc>
                        Accept <a href="#">terms of service</a>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn bg-teal-400 btn-block">Register <i class="icon-circle-right2 ml-2"></i></button>
        </div>
    </div>
</form>
<!-- /registration form -->


<!--<div class="row">-->
<!--    <div class="col-lg-6 offset-lg-3">-->
<!--        <div class="card mb-0">-->
<!--            <div class="card-body">-->
<!--                <div class="text-center mb-3">-->
<!--                    <h5 class="mb-0">Регистрация</h5>-->
<!--                    <span class="d-block text-muted">CASHCALL - биржа операторов на телефоне</span>-->
<!--                </div>-->
<!---->
<!--                <div class="form-group text-center  mb-3 mb-md-2">-->
<!--                    <div class="custom-control custom-radio custom-control-inline">-->
<!--                        <input type="radio" class="custom-control-input" name="custom-inline-radio" id="custom_radio_inline_unchecked" checked="">-->
<!--                        <label class="custom-control-label" for="custom_radio_inline_unchecked">Я оператор</label>-->
<!--                    </div>-->
<!---->
<!--                    <div class="custom-control custom-radio custom-control-inline">-->
<!--                        <input type="radio" class="custom-control-input" name="custom-inline-radio" id="custom_radio_inline_checked">-->
<!--                        <label class="custom-control-label" for="custom_radio_inline_checked">Я рекламодатель</label>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!---->
<!--                <div class="row">-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group form-group-feedback form-group-feedback-right">-->
<!--                            <input type="text" class="form-control" placeholder="First name">-->
<!--                            <div class="form-control-feedback">-->
<!--                                <i class="icon-user-check text-muted"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!---->
<!--                <div class="row">-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group form-group-feedback form-group-feedback-right">-->
<!--                            <input type="password" class="form-control" placeholder="Create password">-->
<!--                            <div class="form-control-feedback">-->
<!--                                <i class="icon-user-lock text-muted"></i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!---->
<!---->
<!---->
<!--                <button type="submit" class="btn bg-teal-400 btn-labeled btn-labeled-right"><b><i class="icon-plus3"></i></b> Create account</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->




<?php if (isset($_SESSION['form_data']) ) unset($_SESSION['form_data'])?>





