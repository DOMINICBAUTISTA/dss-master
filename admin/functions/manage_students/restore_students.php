<?php
include '../../../database/connection.php';

$response = array();

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $update_student_stmt = $conn->prepare("UPDATE `tbl_student` SET marks = 'Enrolled', soft_delete = 0 WHERE student_id = ?");
    $update_student_stmt->execute([$student_id]);

    if ($update_student_stmt->rowCount() > 0) {
        $response['status'] = 'success';
        $response['message'] = 'Student restored successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to restore student';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request parameters';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
