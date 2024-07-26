<?php
require_once('../../tcpdf/tcpdf.php'); // Adjust path to your TCPDF library
include '../../database/connection.php';

session_start();
$student_id = $_SESSION['student_id'];
if (!isset($student_id)) {
    header('location: ../../login.php');
}

// Fetch student and grades data
$getGrades = "SELECT 
    g.grade_id,
    g.teacher_assign,
    g.grade_value, 
    g.grade_status, 
    s.student_fullname, 
    s.student_no,
    s.student_profile,
    sn.section_name,
    sb.subject_name, 
    sb.subject_code,
    sb.subject_unit,
    ay.academic_year, 
    sem.semester_name,
    yr.year,
    cr.course
FROM tbl_grades g
LEFT JOIN tbl_student s ON g.student_id = s.student_id
LEFT JOIN tbl_subject sb ON g.subject_id = sb.subject_id
LEFT JOIN tbl_academic_year ay ON g.academic_year_id = ay.academic_year_id
LEFT JOIN tbl_semester sem ON g.semester_id = sem.semester_id
LEFT JOIN tbl_year yr ON s.year_id = yr.year_id
LEFT JOIN tbl_course cr ON s.course_id = cr.course_id
LEFT JOIN tbl_section sn ON s.section_id = sn.section_id
WHERE g.student_id = ?";

$stmt = $conn->prepare($getGrades);
$stmt->execute([$student_id]);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your School');
$pdf->SetTitle('Student Grades Report');
$pdf->SetSubject('Grades Report');

// Set default header data
$pdf->SetHeaderData('', 0, 'Student Grades Report', 'Generated on: ' . date('Y-m-d'));

// Set header and footer fonts
$pdf->setHeaderFont(Array('helvetica', '', 10));
$pdf->setFooterFont(Array('helvetica', '', 8));

// Set margins
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Student Information
if (!empty($grades)) {
    $student = $grades[0]; // Assuming all grades belong to the same student
    $pdf->Cell(0, 10, 'Student Name: ' . $student['student_fullname'], 0, 1);
    $pdf->Cell(0, 10, 'Student No: ' . $student['student_no'], 0, 1);
    $pdf->Cell(0, 10, 'Year: ' . $student['year'], 0, 1);
    $pdf->Cell(0, 10, 'Section: ' . $student['section_name'], 0, 1);
    $pdf->Cell(0, 10, 'Course: ' . $student['course'], 0, 1);
    $pdf->Cell(0, 10, 'Academic Year: ' . $student['academic_year'], 0, 1);
    $pdf->Cell(0, 10, 'Semester: ' . $student['semester_name'], 0, 1);
    $pdf->Ln(10);

    // Table header
    $html = '<table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Unit</th>
                <th>Teacher Assigned</th>
                <th>Final Grade</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($grades as $grade) {
        $html .= '<tr>
            <td>' . htmlspecialchars($grade['subject_code']) . '</td>
            <td>' . htmlspecialchars($grade['subject_name']) . '</td>
            <td>' . htmlspecialchars($grade['subject_unit']) . '</td>
            <td>' . htmlspecialchars($grade['teacher_assign']) . '</td>
            <td>' . number_format($grade['grade_value'], 2) . '</td>
            <td style="color: ' . ($grade['grade_status'] === 'Passed' ? 'green' : 'red') . ';">' . htmlspecialchars($grade['grade_status']) . '</td>
        </tr>';
    }

    $html .= '</tbody></table>';

    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Calculate General Weighted Average (GWA)
    $total_grades = array_sum(array_column($grades, 'grade_value'));
    $total_subjects = count($grades);
    $gwa = ($total_subjects > 0) ? $total_grades / $total_subjects : 0;

    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'General Weighted Average (GWA): ' . number_format($gwa, 2), 0, 1);
}

// End output buffering and discard any content
ob_end_clean();

// Close and output PDF document
$pdf->Output('student_grades.pdf', 'I');
?>
