<!-- Mia Vucinic -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="ICON" href="/assets/images/logo/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/scriptLogInRegister.js"></script>

    <title>Register</title>
</head>

<body style="background-color: #e9f1d0;">
<section class="vh-100" style="background-color: #e9f1d0;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;  background-color: #d3e58a;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign Up</p>

                                <form class="mx-1 mx-md-4" id="registrationform1"
                                      action="/register" method="post">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="text" id="usernameRegistration" name="usernameRegistration" class="form-control" required/>
                                            <label class="form-label" for="usernameRegistration">Username</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="email" id="email" name="email" class="form-control" required/>
                                            <label class="form-label" for="email">Email</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" id="passwordRegistration" name="passwordRegistration" class="form-control" required/>
                                            <label class="form-label" for="passwordRegistration">Password</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" id="repeatPassword" name="repeatPassword" class="form-control" required/>
                                            <label class="form-label" for="repeatPassword">Repeat your
                                                password</label>
                                        </div>
                                    </div>



                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <a href="">
                                            <button type="submit" class="btn btn-primary btn-lg"
                                                    style="background-color:#d6355b!important; border-radius: 25px;border-color:#d6355b!important;"
                                                    onclick="verifyFieldsRegister()" id="buttonContinue">
                                                Continue
                                            </button>
                                        </a>
                                    </div>

                                    <hr class="my-4">

                                    <div class="d-flex justify-content-center">
                                        Already have an account?&nbsp;<a href="/">Log In</a>
                                    </div>


                                    <hr class="my-4">

                                    <div class="d-flex justify-content-center">
                                        Want to be a trainer?&nbsp;<a href="#">Become a trainer</a>
                                    </div>


                                </form>

                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                <img src="/assets/images/logo/logo.png" class="img-fluid" alt="Sample image"
                                     style="margin:auto;width:70%">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--
<div class="modal" id="modalRegister">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #d3e58a;">
                <h5 class="modal-title">ERROR</h5>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>
            <div class="modal-body" style="background-color: #e9f1d0" id="modalBodyRegister">
            </div>
            <div class="modal-footer" style="background-color: #d3e58a;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        style="background-color:#d6355b!important; border-radius: 25px;border-color:#d6355b!important;">OK</button>
            </div>
        </div>
    </div>
</div>
-->

</body>

</html>