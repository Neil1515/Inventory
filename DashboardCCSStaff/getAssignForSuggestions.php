<!-- getAssignForSuggestions.php -->
<?php
// Include your database connection file (e.g., $con and mysqli_query)

if (isset($_POST["term"])) {
    $term = $_POST["term"];

    // Fetch assignfor values based on the entered term
    $query = "SELECT DISTINCT assignfor FROM tblitembrand WHERE assignfor LIKE '%$term%' LIMIT 10";
    $result = mysqli_query($con, $query);

    if ($result) {
        $suggestions = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $suggestions[] = $row["assignfor"];
        }

        echo json_encode($suggestions);
    } else {
        // Log the SQL error
        error_log("SQL Error: " . mysqli_error($con));
        echo json_encode(array("error" => "Failed to fetch suggestions"));
    }
}
?>

