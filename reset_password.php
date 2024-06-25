<?php
include 'database/connection.php';

session_start();
// for admin to return to dashboard
if (isset($_SESSION['admin_id'])) {
    header('location: admin/pages/dashboard.php');
    exit(); // exit after redirection
}

// for student to return to dashboard
if (isset($_SESSION['student_id'])) {
    header('location: students/pages/dashboard.php');
    exit();
}

if (!isset($_GET['token'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Password does not match')</script>";
    } else {
        $query_admin = "UPDATE tbl_admin SET password = :password WHERE admin_id IN (SELECT admin_id FROM tbl_forgotpassword WHERE token = :token)";
        $stmt_admin = $conn->prepare($query_admin);
        $stmt_admin->bindParam(':password', $new_password);
        $stmt_admin->bindParam(':token', $token);
        $stmt_admin->execute();

        $query_student = "UPDATE tbl_student SET student_password = :student_password WHERE student_id IN (SELECT student_id FROM tbl_forgotpassword WHERE token = :token)";
        $stmt_student = $conn->prepare($query_student);
        $stmt_student->bindParam(':student_password', $new_password);
        $stmt_student->bindParam(':token', $token);
        $stmt_student->execute();

        if ($stmt_admin->rowCount() > 0 || $stmt_student->rowCount() > 0) {
            $query_delete_token = "DELETE FROM tbl_forgotpassword WHERE token = :token";
            $stmt_delete_token = $conn->prepare($query_delete_token);
            $stmt_delete_token->bindParam(':token', $token);
            $stmt_delete_token->execute();

            echo "<script>alert('Password updated successfully.'); window.location.href = 'login.php';</script>";
            exit();
        } else {
            echo "Failed to update password.";
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Password Reset</title>
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
                                <h3 style="color: white;">&nbsp;DIVINE SHEPERED</h3>
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
                                                <h3 style="font-weight: bold;margin-bottom: 20px;">Password Reset</h3>
                                                <form action="" id="reset-password-form" class="reset-password-form" method="post">
                                                    <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>">
                                                    <div class="form-group">
                                                        <label for="new-password" class="sr-only">New-password</label>
                                                        <input type="password" class="form-control form-control-lg input-lg" id="new-password" name="new-password" placeholder="New-password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="confirm-password" class="sr-only">Confirm-password</label>
                                                        <input type="password" class="form-control form-control-lg input-lg" id="confirm-password" name="confirm-password" placeholder="Confirm-password">
                                                    </div>

                                                    <div class="form-group">
                                                        <button class="btn btn-primary btn-block btn-lg" type="submit">Reset Password</button>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </form>
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