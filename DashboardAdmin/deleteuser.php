<!-- deleteuser.php -->
<?php
include "adminfunctions.php";
$id = $_GET["id"];
$sql = "DELETE FROM `tblusers` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  header("Location: adminPage.php?msg=Data deleted successfully");
} else {
  echo "Failed: " . mysqli_error($conn);
}