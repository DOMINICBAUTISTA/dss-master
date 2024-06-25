<?php
include '../../../database/connection.php';
session_start();
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section_id = $_POST['section_id'];
    $new_section = $_POST['section_name'];

    $check_exist_stmt = $conn->prepare("SELECT COUNT(*) FROM `tbl_section` WHERE section_name = ? AND section_id != ?");
    $check_exist_stmt->execute([$new_section, $section_id]);
    $section_exists = $check_exist_stmt->fetchColumn();

    if ($section_exists) {
        $_SESSION['error_message'] = "Section already exists. Please choose a different name.";
        header("Location: ../../pages/manage_section/update_section.php?section_id=" . $section_id);
        exit();
    } else {
        $update_section_stmt = $conn->prepare("UPDATE `tbl_section` SET section_name = ? WHERE section_id = ?");
        $update_section_stmt->execute([$new_section, $section_id]);
        $_SESSION['success_message'] = "Well done! section updated successfully";
        header("Location: ../../pages/manage_section/update_section.php?section_id=" . $section_id);
        exit();
    }
}
