<?php
include '../../../database/connection.php';
session_start();

$error_message = '';
$success_message = '';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Ensure $_POST['subject_id'], $_POST['teacher_assign'], and $_POST['grade_value'] are arrays and not empty
        if (!isset($_POST['subject_id']) || !isset($_POST['teacher_assign']) || !isset($_POST['grade_value'])
            || !is_array($_POST['subject_id']) || !is_array($_POST['teacher_assign']) || !is_array($_POST['grade_value'])
            || empty($_POST['subject_id']) || empty($_POST['teacher_assign']) || empty($_POST['grade_value'])) {
            
            throw new Exception("Subject IDs, Teacher Assign, or Grade values are missing or not provided correctly.");
        }

        // Assuming you receive multiple subject IDs, teacher assigns, and grade values in arrays
        $academic_year_id = $_POST['academic_year_id'];
        $student_id = $_POST['student_id'];
        $semester_id = $_POST['semester_id'];
        $subjects = $_POST['subject_id']; // Array of subject IDs
        $teachers = $_POST['teacher_assign']; // Array of teacher names
        $grades = $_POST['grade_value']; // Array of grade values

        // Check if all arrays have the same length
        if (count($subjects) !== count($teachers) || count($subjects) !== count($grades)) {
            throw new Exception("Subject IDs count does not match Teacher Assign count or Grade values count.");
        }

        // Start transaction
        $conn->beginTransaction();

        // Prepare SQL statement
        $check_sql = "SELECT COUNT(*) FROM tbl_grades WHERE academic_year_id = :academic_year_id 
                      AND student_id = :student_id AND subject_id = :subject_id";
        $check_stmt = $conn->prepare($check_sql);

        $insert_sql = "INSERT INTO tbl_grades (academic_year_id, student_id, subject_id, semester_id, teacher_assign, grade_value, grade_status)
                       VALUES (:academic_year_id, :student_id, :subject_id, :semester_id, :teacher_assign, :grade_value, :grade_status)";
        $stmt = $conn->prepare($insert_sql);

        // Execute batch insertion
        for ($i = 0; $i < count($subjects); $i++) {
            $subject_id = $subjects[$i];
            $teacher_assign = $teachers[$i]; // Get each teacher name individually
            $grade_value = $grades[$i];

            // Check if a grade already exists for this subject and student
            $check_stmt->bindParam(':academic_year_id', $academic_year_id, PDO::PARAM_INT);
            $check_stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $check_stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
            $check_stmt->execute();
            $count = $check_stmt->fetchColumn();

            if ($count > 0) {
                throw new Exception("A grade already exists for subject ID $subject_id and student ID $student_id.");
            }

            // Determine grade status
            if ($grade_value < 75) {
                $grade_status = 'Failed';
            } elseif ($grade_value >= 75) {
                $grade_status = 'Passed';
            } else {
                $grade_status = 'INC';
            }

            // Bind parameters and execute the statement
            $stmt->bindParam(':academic_year_id', $academic_year_id, PDO::PARAM_INT);
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
            $stmt->bindParam(':semester_id', $semester_id, PDO::PARAM_INT);
            $stmt->bindParam(':teacher_assign', $teacher_assign, PDO::PARAM_STR);
            $stmt->bindParam(':grade_value', $grade_value, PDO::PARAM_STR);
            $stmt->bindParam(':grade_status', $grade_status, PDO::PARAM_STR);
            $stmt->execute();
        }

        // Commit transaction
        $conn->commit();

        $_SESSION['success_message'] = "Grades added successfully.";
        header("Location: ../../pages/manage_grades/add_grades.php");
        exit();
    }
} catch (Exception $e) {
    // Rollback transaction on error
    if ($conn) {
        $conn->rollBack();
    }
    $_SESSION['error_message'] = "Error adding grades: " . $e->getMessage();
    header("Location: ../../pages/manage_grades/add_grades.php");
    exit();
}
?>
