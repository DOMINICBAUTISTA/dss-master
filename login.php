<?php
include 'database/connection.php';

session_start();
// for admin to return to dashboard
if (isset($_SESSION['admin_id'])) {
    header('location: admin/pages/dashboard.php');
}
// end session


// for student to return to dashboard
if (isset($_SESSION['student_id'])) {
    header('location: students/pages/dashboard.php');
}
// end session

?>


<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="home-assets/images/divine-logo.png" />
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- end of bootstrap -->
    <!--page level css -->
    <link type="text/css" href="vendors/themify/css/themify-icons.css" rel="stylesheet" />
    <link href="vendors/iCheck/css/all.css" rel="stylesheet">
    <link href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet" />
    <link href="assets/css/login.css?v=2" rel="stylesheet">
    <link href="assets/css/app/evsu-theme.css?v=1" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <!-- Sweetalert Css -->
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <!--end page level css-->
</head>

<body id="sign-in">

    <div class="preloader">
        <div class="loader_img"><img src="home-assets/images/divine-logo.png" alt="loading..." height="64" width="64"></div>
    </div>

    <div class="flex-container">
        <div class="container">
            <div class="row row-inner-container">
                <div class="col-md-12">
                    <div class="row my-form-row">
                        <div class="col-md-6 my-col">
                            <div class="logo-container">
                                <img class="img-logo" style="border-radius: 5px;" src="home-assets/images/divine-logo.jpg" alt="Divine Logo">
                                <h3 style="color: white;">&nbsp;DIVINE SHEPHERED</h3>
                            </div>

                        </div>
                        <div class="col-md-6 my-col">
                            <div class="my-form-container">

                                <div class="my-form-inner-container">
                                    <div class="panel-header">
                                        <h2 class="text-center">
                                            DIVINE SHEPHERED PORTAL
                                        </h2>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="col-xs-12">
                                                <h3 style="font-weight: bold;margin-bottom: 20px;">Sign In</h3>
                                                <form action="functions-auth/login.php" id="loginForm" class="loginForm" method="post" class="">
                                                    <div class="form-group">
                                                        <label for="email" class="sr-only"> Email</label>
                                                        <input type="text" class="form-control  form-control-lg input-lg" id="student_id" name="email" placeholder="Email">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password" class="sr-only">Password</label>
                                                        <input type="password" class="form-control form-control-lg input-lg" id="password" name="password" placeholder="Password">
                                                    </div>

                                                    <div class="form-group">
                                                        <button class="btn btn-primary btn-block btn-lg" type="submit">Login</button>
                                                    </div>
                                                    <a href="#" data-toggle="modal" data-target="#forgot-modal">Forgot your password?</a>
                                                    <div class="clearfix"></div>
                                                </form>
                                                <!-- MODAL -->
                                                <div id="forgot-modal" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Forgot Password</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="functions-auth/forgot_password.php" id="forgotPasswordForm" method="POST" class="forgotPasswordForm">
                                                                    <div class="form-group">
                                                                        <label for="forgot_email">Email Address</label>
                                                                        <input type="email" class="form-control" id="forgot_email" name="forgot_email" placeholder="Enter your email">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p style="margin: 10px 0px"><a href="home.php" style="color: black !important; font-weight: 900;"><small>&larr; Back to Homepage</small></a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- global js -->
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="ajax-auth/login.js"></script>
    <!-- end of global js -->
    <!-- page level js -->
    <script type="text/javascript" src="vendors/iCheck/js/icheck.js"></script>
    <script src="vendors/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/js/custom_js/login.js?v=3"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-182226591-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-182226591-1');
    </script>
</body>

</html>