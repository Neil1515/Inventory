<?php
include "adminfunctions.php";

if (isset($_GET["id"])) {
    $userId = $_GET["id"];

    // Generate the new password
    $newPassword = "uclm-" . $userId;

    // Update the password in the database
    $updateSql = "UPDATE `tblusers` SET password = '" . $newPassword . "' WHERE id = " . $userId;
    $updateResult = mysqli_query($conn, $updateSql);

    if ($updateResult) {
        // Password reset successfully
        $message = "Password reset successfully for user with ID: " . $userId;
    } else {
        // Password reset failed
        $message = "Password reset failed. Please try again.";
    }
} else {
    // Invalid user ID
    $message = "Invalid user ID.";
}

header("Location: adminPage.php?msg=" . urlencode($message));
exit();
?>
