<?php
include '../../../database/connection.php';

$response = array();

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $update_student_stmt = $conn->prepare("UPDATE `tbl_student` SET marks = 'Not active', soft_delete = 1 WHERE student_id = ?");
    $update_student_stmt->execute([$student_id]);

    $response['status'] = 'success';
    $response['message'] = 'Well done! student marked as deleted successfully';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request parameters';
}

header('Content-Type: application/json');
echo trim(json_encode($response));
