<?php
include '../../../database/connection.php';
session_start();

function updateAcademic($conn, $academic_id, $new_academic_name) {
    // Check if academic name already exists
    $check_academic_name = $conn->prepare("SELECT COUNT(*) FROM `tbl_academic` WHERE academic_name = ? AND academic_id != ?");
    $check_academic_name->execute([$new_academic_name, $academic_id]);
    $academic_exists = $check_academic_name->fetchColumn();

    if ($academic_exists) {
        return [
            'error' => 'Academic already exists. Please choose a different name.'
        ];
    } else {
        // Update academic
        $update_academic_stmt = $conn->prepare("UPDATE `tbl_academic` SET academic_name = ? WHERE academic_id = ?");
        $update_academic_stmt->execute([$new_academic_name, $academic_id]);
        return [
            'success' => 'Well done! Academic updated successfully.'
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $academic_id = $_POST['academic_id'];
    $new_academic_name = $_POST['academic'];

    $result = updateAcademic($conn, $academic_id, $new_academic_name);

    if (isset($result['error'])) {
        $_SESSION['error_message'] = $result['error'];
    } else if (isset($result['success'])) {
        $_SESSION['success_message'] = $result['success'];
    }

    header("Location: ../../pages/manage_academic/update_academic.php?academic_id=" . $academic_id);
    exit();
}
?>
