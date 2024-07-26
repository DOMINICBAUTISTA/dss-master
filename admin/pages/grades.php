<?php
include '../../database/connection.php';

session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location: ../../login.php');
    exit;
}

// GETTING THE DETAILS OF THE SESSION
$sql_admin_details = "SELECT email, fullname FROM tbl_admin WHERE admin_id = ?";
$stmt_admin_details = $conn->prepare($sql_admin_details);
$stmt_admin_details->execute([$admin_id]);
$admin_details = $stmt_admin_details->fetch(PDO::FETCH_ASSOC);

$admin_email = $admin_details['email'];
$admin_fullname = $admin_details['fullname'];

// Get the list of courses
$sql_courses = "SELECT course_id, course FROM tbl_course";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->execute();
$courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);

// Get the list of years
$sql_years = "SELECT year_id, year FROM tbl_year";
$stmt_years = $conn->prepare($sql_years);
$stmt_years->execute();
$years = $stmt_years->fetchAll(PDO::FETCH_ASSOC);

// Handle selected course filter
$selected_course = isset($_GET['course_id']) ? $_GET['course_id'] : '';
$selected_year = isset($_GET['year_id']) ? $_GET['year_id'] : '';

// Get the grades with optional course and year filters
$getGrades = "SELECT 
    g.grade_id,
    g.teacher_assign,
    g.grade_value, 
    g.grade_status, 
    s.student_id,
    s.student_fullname, 
    sb.subject_name
FROM tbl_grades g
LEFT JOIN tbl_student s ON g.student_id = s.student_id
LEFT JOIN tbl_subject sb ON g.subject_id = sb.subject_id
LEFT JOIN tbl_course c ON s.course_id = c.course_id
LEFT JOIN tbl_year y ON s.year_id = y.year_id
WHERE g.grade_status IN ('Passed', 'Failed') " . 
($selected_course ? "AND s.course_id = ? " : "") . 
($selected_year ? "AND s.year_id = ? " : "") . 
"ORDER BY s.student_fullname, sb.subject_name";

$stmt = $conn->prepare($getGrades);
if ($selected_course && $selected_year) {
    $stmt->execute([$selected_course, $selected_year]);
} elseif ($selected_course) {
    $stmt->execute([$selected_course]);
} elseif ($selected_year) {
    $stmt->execute([$selected_year]);
} else {
    $stmt->execute();
}
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group results by student fullname
$grouped_results = [];
foreach ($results as $row) {
    $student_name = $row['student_fullname'];
    if (!isset($grouped_results[$student_name])) {
        $grouped_results[$student_name] = [];
    }
    $grouped_results[$student_name][] = $row;
}

// Delete grades functionality
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['grade_id'])) {
    $grade_id = $_GET['grade_id'];
    
    $deleteGrades = "DELETE FROM tbl_grades WHERE grade_id = ?";
    $stmt = $conn->prepare($deleteGrades);
    
    if ($stmt->execute([$grade_id])) {
        // Redirect to prevent form resubmission
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    } else {
        echo "Error deleting grade.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Student Grades List</title>
    <!-- Favicon-->
    <link rel="icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTy1TutOUSYZTi6jo2tcOjKDm8zcUU5zz7u-pUNB-CpJgJxrKgJBIVdgfTBIFFfMWqBh3E&usqp=CAU" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../assets/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../assets/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="../assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="../assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="../assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../assets/css/themes/all-themes.css" rel="stylesheet" />
    <style>
        /* additional css right sidebar */
        .tab-content ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .tab-content ul li {
            margin-top: 0 !important;
        }

        .tab-content ul li a {
            font-weight: 900;
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
            margin-top: 15px;
            margin-left: 10px;
            color: black;
            display: inline-block;
            transition: color 0.3s !important;

        }

        .tab-content ul li a:hover {
            color: #2364a3 !important;
        }

        .pagination li.active a {
            background: #2364a3 !important;
        }

        .breadcrumb-col-red li a {
            color: #154370 !important;
            font-weight: bold;
        }

        .theme-red .sidebar .menu .list li.active> :first-child i,
        .theme-red .sidebar .menu .list li.active> :first-child span {
            color: #154370 !important;
        }

        .dataTables_wrapper .dt-buttons a.dt-button {
            background: #2364a3 !important;
            color: #fff;
            padding: 7px 12px;
            margin-right: 5px;
            text-decoration: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            -ms-border-radius: 2px;
            border-radius: 2px;
            border: none;
            font-size: 13px;
            outline: none;
        }

        .bg-red {
            background: #2364a3 !important;
            color: #fff;
        }
    </style>
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-teal">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a id="app-title" style="display:flex;align-items:center" class="navbar-brand" href="">
                    <img id="bcas-logo" style="width:50px;display:inline;margin-right:10px;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTy1TutOUSYZTi6jo2tcOjKDm8zcUU5zz7u-pUNB-CpJgJxrKgJBIVdgfTBIFFfMWqBh3E&usqp=CAU" />DIVINE-GSYS
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">account_circle</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="../../home-assets/images/divine-logo.png" width="48" height="48" alt="User" />
                    <img src="https://tse2.mm.bing.net/th?id=OIP.fqSvfYQB0rQ-6EG_oqvonQHaHa&pid=Api&P=0&h=180" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $admin_fullname; ?></div>
                    <div class="email"><?php echo $admin_email; ?></div>
                    <div class="student_no">NO STUDENT NUMBER</div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">DIVINE SHEPERED PORTAL</li>
                    <li>
                        <a href="dashboard.php">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="students.php">
                            <i class="material-icons">groups</i>
                            <span>Students</span>
                        </a>
                    </li>

                    <li>
                        <a href="restore.php">
                            <i class="material-icons">groups</i>
                            <span>Restore</span>
                        </a>
                    </li>

                    <li>
                        <a href="course.php">
                            <i class="material-icons">book</i>
                            <span>Utils</span>
                        </a>
                    </li>

                    <li class="active">
                        <a href="grades.php">
                            <i class="material-icons">grade</i>
                            <span>Grades</span>
                        </a>
                    </li>

                    <li class="header">DIVINE SHEPERED HOMEPAGE</li>


                    <li class="">
                        <a href="../../home.php">
                            <i class="material-icons">web</i>
                            <span>Page</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">ACCOUNT</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="skins">
                    <ul style="list-style-type: none;">
                        <li>
                            <a href="manage_profile/update_profile.php" style="font-weight: 900; font-size: 15px; text-decoration: none; cursor: pointer; color: black"><i class="material-icons mr-2" style="font-size: 18px; vertical-align: middle;">lock</i> Update profile</a>
                        </li>
                    </ul>
                    <ul style="list-style-type: none;">
                        <li>
                            <a href="../functions/auth/admin_logout.php" style="font-weight: 900; font-size: 15px; text-decoration: none; cursor: pointer; color: black"><i class=" material-icons mr-2" style="font-size: 18px; vertical-align: middle;">exit_to_app</i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
    <div class="container-fluid">
        <!-- Course Filter Dropdown -->
        <form method="GET" action="">
            <div class="row clearfix">
                <div class="col-md-4">
                    <select name="course_id" class="form-control show-tick" data-live-search="true">
                        <option value="">-- Select Course --</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course['course_id']; ?>" <?php echo $selected_course == $course['course_id'] ? 'selected' : ''; ?>>
                                <?php echo $course['course']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="year_id" class="form-control show-tick" data-live-search="true">
                        <option value="">-- Select Year --</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?php echo $year['year_id']; ?>" <?php echo $selected_year == $year['year_id'] ? 'selected' : ''; ?>>
                                <?php echo $year['year']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        <br>
        <br>

        <!-- Other HTML content -->
        <div>
            <a href="manage_grades/add_grades.php" class="btn btn-tealbtn bg-red waves-effect btn-lg" style="margin-bottom: 15px;">+ Add grades</a>
        </div>

        <?php
// Assuming $grouped_results is populated from a database query
// Ensure that student_id is included in each grade record in $grouped_results

foreach ($grouped_results as $student_name => $grades) : 
    // Check if grades array is empty
    if (empty($grades)) {
        echo "<div class='alert alert-danger'>No grades found for $student_name.</div>";
        continue;
    }
    
    // Check if student_id exists in the first grade entry
    if (!isset($grades[0]['student_id']) || empty($grades[0]['student_id'])) {
        echo "<div class='alert alert-danger'>Student ID missing for $student_name.</div>";
        continue;
    }

    $student_id = urlencode($grades[0]['student_id']);
?>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2><?php echo htmlspecialchars($student_name); ?></h2>
                    <a href="download_report_card.php?student_id=<?php echo $student_id; ?>" class="btn bg-red">Download Report Card</a>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>Subject Name</th>
                                    <th>Grade</th>
                                    <th>Grade Status</th>
                                    <th>Teacher Assign</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $total_grade = 0;
                                    $total_subjects = count($grades);
                                    
                                    foreach ($grades as $grade) :
                                        // Check if student_id is present in each grade entry
                                        if (!isset($grade['student_id']) || empty($grade['student_id'])) {
                                            echo "<tr><td colspan='5' class='alert alert-danger'>Student ID missing for one of the grades.</td></tr>";
                                            continue;
                                        }

                                        $total_grade += $grade['grade_value'];
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($grade['subject_name']); ?></td>
                                        <td><?php echo number_format($grade['grade_value'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($grade['grade_status']); ?></td>
                                        <td><?php echo htmlspecialchars($grade['teacher_assign']); ?></td>
                                        <td>
                                            <a class="btn bg-red" href="manage_grades/update_grades.php?grade_id=<?php echo urlencode($grade['grade_id']); ?>">Update</a>
                                            <a class="btn bg-red" href="#" onclick="deleteGrade(<?php echo intval($grade['grade_id']); ?>)">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!-- Display GWA row -->
                                <tr>
                                    <td colspan="5" style="text-align: right; color:green;"><strong>Average Grade:</strong> <?php echo $total_subjects > 0 ? number_format($total_grade / $total_subjects, 2) : 'N/A'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<script>
    function printCard(studentName) {
        var studentCard = document.querySelector(`.student-card[data-student-name="${studentName}"]`);
        var printContents = studentCard.outerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
        location.reload(); // To reattach the events
    }
</script>



    <script>
        function deleteGrade(gradeId) {
            if (confirm("Are you sure you want to delete this grade?")) {
                window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&grade_id=" + gradeId;
            }
        }
    </script>

    <script>
        function deleteGrade(gradeId) {
            if (confirm("Are you sure you want to delete this grade?")) {
                window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&grade_id=" + gradeId;
            }
        }
    </script>
    <!-- Jquery Core Js -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="../ajax/manage_grades/delete_grades.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="../assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="../assets/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../assets/plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="../assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="../assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="../assets/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="../assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="../assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="../assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="../assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="../assets/js/admin.js"></script>
    <script src="../assets/js/pages/tables/jquery-datatable.js"></script>
    <script src="../assets/js/pages/forms/basic-form-elements.js"></script>
    <script src="../assets/js/pages/forms/form-validation.js"></script>
    <!-- Demo Js -->
    <script src="../assets/js/demo.js"></script>
</body>

</html>