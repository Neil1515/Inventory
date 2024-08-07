<!-- ccsstaffReports.php -->
<?php
session_start();
// Include necessary files
include('bwerfunctions.php');
// Check if the user is logged in
if (!isset($_SESSION['borrower_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}
// Retrieve user information based on the logged-in user ID
$borrowerId = $_SESSION['borrower_id'];

$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Valid user, retrieve user information
            $row = mysqli_fetch_assoc($result);
            $borrowerName = $row['fname'] . ' ' . $row['lname'];
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
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container-fluid">
        <!-- Header at the top -->
        
        <div class="row">      
                <?php include('bwerheader.php'); ?>
        </div>
        <!-- Sidebar on the left and Main container on the right -->
        <div class="row">
            <!-- Sidebar on the left -->
            <div class="col-md-2">
                <?php include('bwersidebar.php'); ?>
            </div>
            <!-- Main container on the right -->
            <div class="col-md-10">
                <div class="row mb-1">
                    <div class="col-md-5">
                        <div class="d-flex align-items-center">
                            <h3 class="me-2"><i class="fas fa-file-alt me-2"></i>Reports</h3>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <!-- Filter Section -->
                        <form method="GET" action="" class="d-flex justify-content-end align-items-center">
                            <div class="input-group">
                                <label for="startDate" class="me-2">Start Date:</label>
                                <input type="date" class="form-control" id="startDate" name="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                                <label for="endDate" class="ms-2 me-2">End Date:</label>
                                <input type="date" class="form-control" id="endDate" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                                <button type="submit" class="btn btn-primary me-1">Filter</button>
                                <label id="table-buttons-container" class="ms-2"></label>   
                                <button id="generatePdfBtn" class="btn btn-secondary">PDF</button>          
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Display table of items in the report -->
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered">
                        <thead class="text-center table-dark">
                            <tr>
                                <th>Transaction Number</th>
                                <th>Item Status</th>
                                <th>Item</th>
                                <th>Released By</th>
                                <th>Date Time Released</th>
                                <th>Recieve Return By</th>
                                <th>Date Time Return</th>
                                <th>Return Condition</th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                           // Retrieve the start date and end date from the form submission
                            $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
                            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

                            // Prepare the SQL query with placeholders for the date range
                            $query = "SELECT br.itemreqstatus, br.itemid, br.returnitemcondition, ib.subcategoryname,
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
                            WHERE br.borrowerid = ?"; // Assuming you want to filter by borrower ID initially

                            // Add WHERE clause if both start date and end date are provided
                            if (!empty($start_date) && !empty($end_date)) {
                            // Add a WHERE clause to filter the data based on the date range
                            $query .= " AND DATE(br.datimeapproved) BETWEEN ? AND ?";
                            }

                            $stmt = mysqli_prepare($con, $query);
                            if ($stmt) {
                                // Bind parameters including the start date and end date if provided
                                if (!empty($start_date) && !empty($end_date)) {
                                    mysqli_stmt_bind_param($stmt, "sss", $borrowerId, $start_date, $end_date);
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $borrowerId);
                                }
                                if (mysqli_stmt_execute($stmt)) {
                                    $result = mysqli_stmt_get_result($stmt);
                                    while ($row = mysqli_fetch_assoc($result)) {

                                echo "<tr>";
                                // Check if the value is NULL, if so, display ---
                                $itemID = $row['id'] ?? '---';
                                echo "<td class='text-center'>{$itemID}</td>";
                                //$datetimereqborrow = $row['datetimereqborrow'] ? date("m/d/Y H:i", strtotime($row['datetimereqborrow'])) : '---';
                                //echo "<td class='text-center'>{$datetimereqborrow}</td>";


                                // Check if the value is NULL, if so, display ---
                                $itemStatus = $row['itemreqstatus'] ?? '---';
                                echo "<td>{$itemStatus}</td>";
                                
                                // Similarly, check other fields and display --- if NULL
                                $itemName = $row['subcategoryname'] ?? 'Item Not Found';
                                echo "<td>{$itemName}</td>";
                                
                                // Concatenate first and last name if both are not NULL, otherwise display ---
                                //$borrower = ($row['borrower_fname'] && $row['borrower_lname']) ? "{$row['borrower_fname']} {$row['borrower_lname']}" : '---';
                                //echo "<td class='text-center'>{$borrower}</td>";
                                
                                // Concatenate first and last name if both are not NULL, otherwise display ---
                                $approvedBy = ($row['approve_fname'] && $row['approve_lname']) ? "{$row['approve_fname']} {$row['approve_lname']}" : '---';
                                echo "<td class='text-center'>{$approvedBy}</td>";
                                
                                // Check if the value is NULL, if so, display ---
                                $dateTimeApproved = $row['datimeapproved'] ? date("F d, Y g:i A", strtotime($row['datimeapproved'])) : '---';
                                echo "<td class='text-center'>{$dateTimeApproved}</td>";
                                
                                // Concatenate first and last name if both are not NULL, otherwise display ---
                                $approveReturnBy = ($row['approvereturn_fname'] && $row['approvereturn_lname']) ? "{$row['approvereturn_fname']} {$row['approvereturn_lname']}" : '---';
                                echo "<td class='text-center'>{$approveReturnBy}</td>";
                                
                                // Check if the value is NULL, if so, display ---
                                $dateTimeReturn = $row['datetimereturn'] ? date("F d, Y g:i A", strtotime($row['datetimereturn'])) : '---';
                                echo "<td class='text-center'>{$dateTimeReturn}</td>";

                                 // Similarly, check other fields and display --- if NULL
                                 $returncondition = $row['returnitemcondition'] ?? '---';
                                 echo "<td class='text-center'>{$returncondition}</td>";
                                echo "</tr>";
                                }
                                } else {
                                    echo 'Statement execution failed: ' . mysqli_stmt_error($stmt);
                                }
                                mysqli_stmt_close($stmt);
                            } else {
                                echo 'Statement preparation failed: ' . mysqli_error($con);
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script>
$(document).ready(function(){
    var table = $('#example').DataTable({
        buttons:['copy', 'csv', 'excel'],
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            {
                "targets": [0], // Index of the Date column
                "visible": false, // Hide the column
                "searchable": false // Exclude from search
            }
        ]
    });
    // Move the DataTable buttons container to a more appropriate location
    table.buttons().container().appendTo('#table-buttons-container');
    

    // Bind click event handler to the PDF generation button
    $('#generatePdfBtn').click(function() {
        // Retrieve the search input value
        var searchValue = $('#example_filter input[type="search"]').val();
        // Retrieve other parameters from the URL
        var startDate = '<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>';
        var endDate = '<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>';
        var borrowerId = '<?php echo $borrowerId; ?>';
        // Construct the PDF link with all parameters
        var pdfLink = '3print_pdf.php?start_date=' + startDate + '&end_date=' + endDate + '&borrower_id=' + borrowerId + '&search=' + encodeURIComponent(searchValue);
        // Open the PDF link in a new tab
        window.open(pdfLink);
    });
});
</script>



</body>
</html>
