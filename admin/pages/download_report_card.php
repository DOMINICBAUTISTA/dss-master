<?php
// Start output buffering
ob_start();

// Define the absolute path to the TCPDF directory
$tcpdfDir = dirname(__DIR__, 2) . '/tcpdf/';

// Check if the TCPDF library exists at the specified path
if (!file_exists($tcpdfDir . 'tcpdf.php')) {
    die('Error: TCPDF library not found. Please check the path.');
}

// Include the TCPDF library
require_once($tcpdfDir . 'tcpdf.php');

// Database connection parameters
$dsn = 'mysql:host=localhost;dbname=student-portal-bcas';
$username = 'new_user';
$password = 'new_password';
$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Get and validate the student ID from the request
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : null;

// Debug: Print the student ID
if ($student_id === null) {
    die('Error: Student ID is required. Please make sure to include the student_id in the query string.');
} else {
    echo 'Student ID received: ' . $student_id . '<br>';
}

// Prepare SQL query
$getGrades = "SELECT 
    g.grade_id,
    g.teacher_assign,
    g.grade_value, 
    g.grade_status, 
    s.student_fullname, 
    s.student_id,
    sb.subject_name,
    sb.subject_code,
    sb.subject_unit,
    c.course AS course_name,
    y.year AS year_name,
    z.section_name,
    sem.semester_name
FROM tbl_grades g
LEFT JOIN tbl_student s ON g.student_id = s.student_id
LEFT JOIN tbl_subject sb ON g.subject_id = sb.subject_id
LEFT JOIN tbl_course c ON s.course_id = c.course_id
LEFT JOIN tbl_year y ON s.year_id = y.year_id
LEFT JOIN tbl_section z ON s.section_id = z.section_id
LEFT JOIN tbl_semester sem ON g.semester_id = sem.semester_id
WHERE g.grade_status IN ('Passed', 'Failed') 
AND s.student_id = :student_id
ORDER BY sb.subject_name";

// Prepare and execute query
$stmt = $pdo->prepare($getGrades);
$stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debug: Print the results
echo '<pre>';
print_r($results);
echo '</pre>';

// Check if any results are found
if (empty($results)) {
    die('Error: No grades found for this student.');
}

// Continue with generating PDF
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
if (!empty($results)) {
    $student = $results[0]; // Assuming all grades belong to the same student
    $pdf->Cell(0, 10, 'Student Name: ' . $student['student_fullname'], 0, 1);
    $pdf->Cell(0, 10, 'Strand: ' . htmlspecialchars($student['course_name']), 0, 1);
    $pdf->Cell(0, 10, 'Grade Level: ' . htmlspecialchars($student['year_name']), 0, 1);
    $pdf->Cell(0, 10, 'Section: ' . htmlspecialchars($student['section_name']), 0, 1);
    $pdf->Cell(0, 10, 'Semester: ' . htmlspecialchars($student['semester_name']), 0, 1);
    $pdf->Ln(10);

    // HTML table
    $html = '<table border="1" cellpadding="5" style="border-collapse: collapse;">
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

    $total_grades = 0;
    foreach ($results as $grade) {
        $total_grades += $grade['grade_value'];
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
    $total_subjects = count($results);
    $gwa = ($total_subjects > 0) ? $total_grades / $total_subjects : 0;

    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'General Weighted Average (GWA): ' . number_format($gwa, 2), 0, 1);
}

// End output buffering and discard any content
ob_end_clean();

// Output PDF to browser with dynamic filename
$pdf->Output('student_grades.pdf', 'I');
?>
