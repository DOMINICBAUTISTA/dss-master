<?php
include '../../../database/connection.php';

session_start();

function addAcademic($conn, $academic_name) {
    // Check if academic name already exists
    $check_academic_name = $conn->prepare("SELECT COUNT(*) FROM `tbl_academic` WHERE academic_name = ?");
    $check_academic_name->execute([$academic_name]);
    $academic_name_exist = $check_academic_name->fetchColumn();

    if ($academic_name_exist) {
        return [
            'error' => 'Academic with the given name already exists. Please choose a different name.'
        ];
    } else {
        // Insert new academic
        $academic_stmt = $conn->prepare("INSERT INTO `tbl_academic` (academic_name) VALUES (?)");
        $academic_stmt->execute([$academic_name]);
        return [
            'success' => 'Well done! Academic added successfully.'
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $academic_name = $_POST['academic_name'];
    $result = addAcademic($conn, $academic_name);

    if (isset($result['error'])) {
        $_SESSION['error_message'] = $result['error'];
    } else if (isset($result['success'])) {
        $_SESSION['success_message'] = $result['success'];
    }

    header("Location: ../../pages/manage_academic/add_academic.php");
    exit();
}
?>
