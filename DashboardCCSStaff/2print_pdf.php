<!--2print_pdf.php -->
<?php
session_start();
// Include necessary files
include('ccsfunctions.php');
// Check if the user is logged in
if (!isset($_SESSION['staff_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}

// Retrieve user information based on the logged-in user ID
$staffId = $_SESSION['staff_id'];

$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $staffId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Valid user, retrieve user information
            $row = mysqli_fetch_assoc($result);
        } else {
            // Handle the case when user information is not found
            // You might want to redirect or display an error message
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="staffstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

</head>
<body>
<?php
ob_start();
// Database connection
$servername = 'localhost';
$db_id = 'root';
$db_password = '';
$db_name = 'maininventorydb';

// Attempt to connect to the database
$con = mysqli_connect($servername, $db_id, $db_password, $db_name);

// Check for connection errors
if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Check if borrower_id is set in the URL parameters
if (isset($_GET['borrower_id'])) {
    // Sanitize and validate the input if necessary
    $borrowerId = $_GET['borrower_id'];
} else {
    // Handle the case when borrower_id is not provided in the URL
    // For example, redirect the user or display an error message
    header('Location: /error.php'); // Redirect to error page
    exit();
}

// Prepare and execute the query to retrieve the borrower's information
$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Valid user, retrieve borrower information
            $borrowerRow = mysqli_fetch_assoc($result); 
            $borrowerIdFromDB = $borrowerRow['id']; 
            $borrowerName = $borrowerRow['fname'] . ' ' . $borrowerRow['lname']; 
            // Determine salutation based on gender
            if ($borrowerRow['gender'] == 'Male') {
                $borrowerSalutation = 'Mr.';
            } else {
                $borrowerSalutation = 'Ms.';
            }
        } else {
            // Handle the case when borrower information is not found
            // You might want to redirect or display an error message
            header('Location: /error.php'); // Redirect to error page
            exit();
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}


// Add a global variable to hold the row count for Approved items
$totalRowsCountApproved = 0;
$totalRowsCountPendingBorrow = 0;
$totalRowsCountPendingReserve = 0;
$totalRowsCountApproveReserve = 0;
$totalRowsCountReturned = 0;
$totalRowsCountNoIssue = 0;
$totalRowsCountDamage = 0;
$totalRowsCountLost = 0;
// Function to generate table rows based on filtered data
function generateRows($con, $start_date, $end_date, $search_query, $borrowerIdFromDB) {

    global $totalRowsCount, $totalRowsCountApproved, $totalRowsCountPendingBorrow, $totalRowsCountPendingReserve, $totalRowsCountApproveReserve, $totalRowsCountReturned,
    $totalRowsCountNoIssue, $totalRowsCountDamage, $totalRowsCountLost;

    // Retrieve search query from GET parameter
    $search_query = isset($_GET['search']) ? $_GET['search'] : '';

    // Modify the SQL query to include search functionality
    $query = "SELECT br.itemreqstatus, br.itemid, br.returnitemcondition, ib.subcategoryname,
                br.borrowerid,
                u1.fname AS borrower_fname, u1.lname AS borrower_lname, 
                u2.fname AS approve_fname, u2.lname AS approve_lname, 
                br.id, br.datimeapproved, 
                u3.fname AS approvereturn_fname, u3.lname AS approvereturn_lname, 
                br.datetimereturn
            FROM tblborrowingreports AS br
            LEFT JOIN tblusers AS u1 ON br.borrowerid = u1.id
            LEFT JOIN tblusers AS u2 ON br.approvebyid = u2.id
            LEFT JOIN tblusers AS u3 ON br.approvereturnbyid = u3.id
            LEFT JOIN tblitembrand AS ib ON br.itemid = ib.id
            WHERE (br.itemreqstatus LIKE '%$search_query%' OR
                   br.returnitemcondition LIKE '%$search_query%' OR
                   ib.subcategoryname LIKE '%$search_query%' OR
                   CONCAT(u1.fname, ' ', u1.lname) LIKE '%$search_query%' OR
                   CONCAT(u2.fname, ' ', u2.lname) LIKE '%$search_query%' OR
                   CONCAT(u3.fname, ' ', u3.lname) LIKE '%$search_query%')
                   AND br.itemreqstatus NOT IN ('Rejected', 'Canceled', 'Expired Reservation')";

    // Add WHERE clause if borrower ID is provided
    if (!empty($borrowerIdFromDB)) {
        $query .= " AND br.borrowerid = ?";
    }

    // Add WHERE clause if both start date and end date are provided
    if (!empty($start_date) && !empty($end_date)) {
        // Add a WHERE clause to filter the data based on the date range
        $query .= " AND DATE(br.datimeapproved) BETWEEN ? AND ?";
    }

    // Add ORDER BY clause to order by datetimereqborrow in descending order
    $query .= " ORDER BY br.id DESC"; 

    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        // Bind parameters including the start date, end date, and borrower ID if provided
        $param_types = '';
        $params = array();

        if (!empty($borrowerIdFromDB)) {
            $param_types .= 's';
            $params[] = $borrowerIdFromDB;
        }

        if (!empty($start_date) && !empty($end_date)) {
            $param_types .= 'ss';
            $params[] = $start_date;
            $params[] = $end_date;
        }

        if ($param_types != '') {
            mysqli_stmt_bind_param($stmt, $param_types, ...$params);
        }

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $rows = '';
            while ($row = mysqli_fetch_assoc($result)) {
                $rows .= "<tr>";

                // Check if the value is NULL, if so, display ---
                $itemStatus = $row['itemreqstatus'] ?? '---';
                $rows .= "<td>{$itemStatus}</td>";
                // Increment the total rows count
                $totalRowsCount++;

                switch ($itemStatus) {
                    case "Approved":
                        $totalRowsCountApproved++;
                        break;
                    case "Pending Borrow":
                        $totalRowsCountPendingBorrow++;
                        break;
                    case "Pending Reserve":
                        $totalRowsCountPendingReserve++;
                        break;
                    case "Approve Reserve":
                        $totalRowsCountApproveReserve++;
                        break;
                    case "Returned":
                        $totalRowsCountReturned++;
                        break;
                    default:
                        // If status doesn't match any of the above, do nothing
                        break;
                }
                // Similarly, check other fields and display --- if NULL
                $itemName = $row['subcategoryname'] ?? 'Item Not Found';
                $rows .= "<td>{$itemName}</td>";

                // Concatenate first and last name if both are not NULL, otherwise display ---
                $approvedBy = ($row['approve_fname'] && $row['approve_lname']) ? "{$row['approve_fname']} {$row['approve_lname']}" : '---';
                $rows .= "<td class='text-center'>{$approvedBy}</td>";

                // Check if the value is NULL, if so, display ---
                $dateTimeApproved = $row['datimeapproved'] ? date("F d, Y g:i A", strtotime($row['datimeapproved'])) : '---';
                $rows .= "<td class='text-center'>{$dateTimeApproved}</td>";

                // Concatenate first and last name if both are not NULL, otherwise display ---
                $approveReturnBy = ($row['approvereturn_fname'] && $row['approvereturn_lname']) ? "{$row['approvereturn_fname']} {$row['approvereturn_lname']}" : '---';
                $rows .= "<td class='text-center'>{$approveReturnBy}</td>";

                // Check if the value is NULL, if so, display ---
                $dateTimeReturn = $row['datetimereturn'] ? date("F d, Y g:i A", strtotime($row['datetimereturn'])) : '---';
                $rows .= "<td class='text-center'>{$dateTimeReturn}</td>";

                switch ($row['returnitemcondition']) {
                    case 'No Issue':
                        $totalRowsCountNoIssue++;
                        break;
                    case 'Damage':
                        $totalRowsCountDamage++;
                        break;
                    case 'Lost':
                        $totalRowsCountLost++;
                        break;
                    default:
                        break;
                }
                $returncondition = $row['returnitemcondition'] ?? '---';
                $rows .= "<td class='text-center'>{$returncondition}</td>";
                $rows .= "</tr>";
            }
            return $rows;
        } else {
            echo 'Statement execution failed: ' . mysqli_stmt_error($stmt);
        }
    } else {
        echo 'Statement preparation failed: ' . mysqli_error($con);
    }
}

require_once('tcpdf/tcpdf.php');
// Fetch Dean's name and gender where status is Active
$queryDean = "SELECT CONCAT(fname, ' ', lname) AS dean_name, gender FROM tblusers WHERE usertype = 'Dean' AND status = 'Active'";
$resultDean = mysqli_query($con, $queryDean);
$deanSalutation = '';
$deanName = '';
if ($rowDean = mysqli_fetch_assoc($resultDean)) {
    $deanName = $rowDean['dean_name'];
    $usertypeDean = 'Dean';
    // Determine salutation based on gender
    if ($rowDean['gender'] == 'Male') {
        $deanSalutation = 'Mr.';
    } else {
        $deanSalutation = 'Mrs.';
    }
}

// Retrieve the name of the staff based on the staff ID
$queryStaff = "SELECT CONCAT(fname, ' ', lname) AS staff_name, gender, usertype FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $queryStaff);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $staffId);
    if (mysqli_stmt_execute($stmt)) {
        $resultStaff = mysqli_stmt_get_result($stmt);
        if ($rowStaff = mysqli_fetch_assoc($resultStaff)) {
            $staffName = $rowStaff['staff_name'];
            $userType = $rowStaff['usertype'];
        }
        // Determine salutation based on gender
        if ($rowStaff['gender'] == 'Male') {
            $staffSalutation = 'Mr.';
        } else {
            $staffSalutation = 'Ms.';
        }
    }
    mysqli_stmt_close($stmt);
}
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle("Reports of $borrowerName");
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('times');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(PDF_MARGIN_LEFT, '3', PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('times', '', 10);

$pdf->AddPage();
// Set the default timezone to Philippines
date_default_timezone_set('Asia/Manila');
// Get the current date and format it
$current_date = date('F d, Y g:i A');
// Construct the PDF content
$content = '';
$content .= '
    <h2 style="margin-top: 20px; text-align: center;">CCS-IMS Inventory Management System</h2>
    <p style="margin: 0; text-align: center;">University Of Cebu Lapu-lapu & Mandaue</p>
    <p style="margin: 0; text-align: center;">As of ' . $current_date . '</p>
    <p style="margin-bottom: 1px; text-align: right;">Date Filter: ' . ($_GET['start_date'] ?? '') . ' - ' . ($_GET['end_date'] ?? '') .' | Search: ' . ($_GET['search'] ?? 'none') . '</p>
    <h3 style="margin-top: 0px; ">Reports of <u>'.$borrowerSalutation.' '.$borrowerName.' ('. $borrowerRow['usertype'].')</u></h3>
    <table border="1" cellspacing="0" cellpadding="3">
        <tr align="center">
            <th>Status</th>
            <th>Item</th>
            <th>Released By</th>
            <th>Date Time Released</th>
            <th>Received By</th>
            <th>Date Time Return</th>
            <th>Return Condition</th>
        </tr>
';

$content .= generateRows($con, $_GET['start_date'] ?? '', $_GET['end_date'] ?? '', $_GET['search'] ?? '', $borrowerIdFromDB);
$content .= '</table>';
$content .= '<p>Total Rows: '.$totalRowsCount.'<br>';
$content .= 'Status: • Approved '.$totalRowsCountApproved.' • Returned '.$totalRowsCountReturned.' • Pending Borrow '.$totalRowsCountPendingBorrow.' • Pending Reserve '.$totalRowsCountPendingReserve.' •  Approve Reserve '.$totalRowsCountApproveReserve.'<br>';
$content .= 'Return Condition: • No Issue '.$totalRowsCountNoIssue.' • Damage '.$totalRowsCountDamage.' • Lost '.$totalRowsCountLost.'';
$content .= '<h3>Prepared by:<br></h3>';
$content .= '<br><br><h3 style="margin-top: 20px;"><u>' . strtoupper($staffSalutation) . ' ' . strtoupper($staffName) . '</u><br>'. $userType .'</h3>';
$content .= '<h3><br></h3>';
$content .= '<h3>Noted by:<br></h3>';
$content .= '<h3 style="margin-top: 20px;"><u>DR. ' . strtoupper($deanName) . '</u><br>CCS '. $usertypeDean .'</h3>';

// Write the HTML content to the PDF and output it
$pdf->writeHTML($content);
$pdf->Output('borrowerdata.pdf', 'I');
ob_end_flush();
?>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <!-- Bootstrap and Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
