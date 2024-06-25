<?php
include '../database/connection.php';
require '../vendor/autoload.php';

date_default_timezone_set('Asia/Manila');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["forgot_email"])) {
    $email = $_POST["forgot_email"];

    $admin_id = null;
    $student_id = null;

    $query_admin = "SELECT admin_id FROM tbl_admin WHERE email = :email";
    $stmt_admin = $conn->prepare($query_admin);
    $stmt_admin->bindParam(':email', $email);
    $stmt_admin->execute();
    $row_admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);
    if ($row_admin) {
        $admin_id = $row_admin['admin_id'];
    }

    $query_student = "SELECT student_id, soft_delete FROM tbl_student WHERE student_email = :email";
    $stmt_student = $conn->prepare($query_student);
    $stmt_student->bindParam(':email', $email);
    $stmt_student->execute();
    $row_student = $stmt_student->fetch(PDO::FETCH_ASSOC);
    if ($row_student) {
        $student_id = $row_student['student_id'];
        $soft_delete = $row_student['soft_delete'];
        if ($soft_delete == 1){
            echo "<script>alert('Your account is being disabled contact admin first'); window.location.href = 'http://localhost/dss-grading-system/login.php';</script>";
            exit();
        }
    }

    if ($admin_id || $student_id) {
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $query_insert = "INSERT INTO tbl_forgotpassword (token, token_expiry, admin_id, student_id) VALUES (:token, :expiry, :admin_id, :student_id)";
        $stmt_insert = $conn->prepare($query_insert);
        $stmt_insert->bindParam(':token', $token);
        $stmt_insert->bindParam(':expiry', $expiry);
        $stmt_insert->bindParam(':admin_id', $admin_id);
        $stmt_insert->bindParam(':student_id', $student_id);
        $stmt_insert->execute();

        $reset_link = "http://localhost/dss-grading-system/reset_password.php?token=$token";

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->Username = 'metrillojhn1@gmail.com';
            $mail->Password = 'zpfptqyqanolopiv';

            $mail->setFrom('from@example.com', 'Your Name');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $mail->Body = "Click the following link to reset your password: <a href='$reset_link'>$reset_link</a>";

            $mail->send();
            echo "<script>alert('Check your email to reset your password!'); window.location.href = 'http://localhost/dss-grading-system/login.php';</script>";
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Email not found'); window.location.href = 'http://localhost/dss-grading-system/login.php';</script>";
    }
}
