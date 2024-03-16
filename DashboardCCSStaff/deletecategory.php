<?php
include "ccsfunctions.php";
// Delete category logic
if (isset($_GET["id"])) {
    $categoryId = $_GET["id"];

    $queryDelete = "DELETE FROM `tblitemcategory` WHERE id = ?";
    $stmtDelete = mysqli_prepare($con, $queryDelete);

    if ($stmtDelete) {
        mysqli_stmt_bind_param($stmtDelete, "i", $categoryId);

        if (mysqli_stmt_execute($stmtDelete)) {
            header("Location: ccstaffManageCategory.php?msg=Category deleted successfully");
            exit();
        } else {
            echo "Failed: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmtDelete);
    } else {
        echo "Failed to prepare statement: " . mysqli_error($con);
    }
}
?>
