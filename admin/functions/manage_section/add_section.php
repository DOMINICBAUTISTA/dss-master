<?php
include '../../../database/connection.php';

session_start();
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $section_name = $_POST['section_name'];

    $check_section_name = $conn->prepare("SELECT COUNT(*) FROM `tbl_section` WHERE section_name = ?");
    $check_section_name->execute([$section_name]);
    $section_name_exist = $check_section_name->fetchColumn();

    if ($section_name_exist) {
        $_SESSION['error_message'] = 'Section with the given name already exists. Please choose a different name.';
        header("Location: ../../pages/manage_section/add_section.php");
        exit();
    } else {
        $section_stmt = $conn->prepare("INSERT INTO `tbl_section` (section_name) VALUES (?)");
        $section_stmt->execute([$section_name]);
        $_SESSION['success_message'] = "Well done! section added successfully";
        header("Location: ../../pages/manage_section/add_section.php");
        exit();
    }
}
