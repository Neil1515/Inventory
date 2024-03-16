<!-- getSubcategories.php -->
<?php
include 'ccsfunctions.php';

if (isset($_POST['category'])) {
    $selectedCategory = $_POST['category'];

    // Debugging: Log the selected category
    error_log("Selected Category: " . $selectedCategory);

    // Fetch subcategories from tblsubcategory based on the selected category
    $querySubcategories = "SELECT subcategoryname FROM tblsubcategory WHERE categoryname = '$selectedCategory' ORDER BY subcategoryname";
    $resultSubcategories = mysqli_query($con, $querySubcategories);

    // Check if there are subcategories
    if ($resultSubcategories) {
        if (mysqli_num_rows($resultSubcategories) > 0) {
            while ($subcategoryRow = mysqli_fetch_assoc($resultSubcategories)) {
                $subcategoryName = trim($subcategoryRow['subcategoryname']);
                echo "<option value='{$subcategoryName}'>{$subcategoryName}</option>";
            }
        } else {
            echo "<option value=''>No subcategories found</option>";
        }
    } else {
        // Debugging: Log database error
        error_log("Database Error: " . mysqli_error($con));

        echo "<option value=''>Database error</option>";
    }
} else {
    // Debugging: Log invalid request
    error_log("Invalid request");

    echo "<option value=''>Invalid request</option>";
}
?>

