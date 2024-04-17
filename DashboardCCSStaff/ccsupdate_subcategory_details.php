<!-- ccsupdate_subcategory_details.php -->

<?php
include 'ccsfunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if subcategoryId, new subcategory name, and old subcategory name are provided
    if (isset($_POST['subcategoryId'], $_POST['newSubcategoryName'], $_POST['oldSubcategoryName'])) {
        $subcategoryId = $_POST['subcategoryId'];
        $newSubcategoryName = $_POST['newSubcategoryName'];
        $oldSubcategoryName = $_POST['oldSubcategoryName'];

        // Check if the new subcategory name is different from the old one
        if ($newSubcategoryName != $oldSubcategoryName) {
            // Check if the new subcategory name already exists
            $checkQuery = "SELECT COUNT(*) AS count FROM tblsubcategory WHERE subcategoryname = ?";
            $stmtCheck = mysqli_prepare($con, $checkQuery);
            if ($stmtCheck) {
                mysqli_stmt_bind_param($stmtCheck, "s", $newSubcategoryName);
                mysqli_stmt_execute($stmtCheck);
                mysqli_stmt_bind_result($stmtCheck, $count);
                mysqli_stmt_fetch($stmtCheck);
                mysqli_stmt_close($stmtCheck);

                if ($count > 0) {
                    // Subcategory already exists, return error response
                    echo json_encode(array('success' => false, 'message' => 'Subcategory already exists.'));
                    exit();
                }
            } else {
                // Statement preparation failed
                echo json_encode(array('success' => false, 'message' => 'Failed to prepare statement'));
                exit();
            }
        }

        // Proceed with updating the subcategory name
        $updateQuery = "UPDATE tblsubcategory SET subcategoryname = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $newSubcategoryName, $subcategoryId);
            if (mysqli_stmt_execute($stmt)) {
                // Update successful
                $successMessage = "Subcategory name updated successfully";

                // Rename the subcategory image file
                $oldImagePath = 'inventory/SubcategoryItemsimages/' . $oldSubcategoryName . '.png';
                $newImagePath = 'inventory/SubcategoryItemsimages/' . $newSubcategoryName . '.png';
                if (file_exists($oldImagePath)) {
                    rename($oldImagePath, $newImagePath);
                }

                // Check if a new image file is uploaded
                if (!empty($_FILES['image']['name'])) {
                    $newImageName = preg_replace("/[^a-zA-Z0-9]/", " ", $newSubcategoryName);
                    $uploadDir = 'inventory/SubcategoryItemsimages/';
                    $uploadPath = $uploadDir . $newImageName . '.png';

                    // Move the uploaded file to the specified location
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        // Image uploaded successfully
                    } else {
                        echo json_encode(array('success' => false, 'message' => 'Failed to move uploaded file.'));
                        exit();
                    }
                }

                // Update tblitembrand with the new subcategory name
                $updateItemBrandQuery = "UPDATE tblitembrand SET subcategoryname = ? WHERE subcategoryname = ?";
                $stmtItemBrand = mysqli_prepare($con, $updateItemBrandQuery);
                if ($stmtItemBrand) {
                    mysqli_stmt_bind_param($stmtItemBrand, "ss", $newSubcategoryName, $oldSubcategoryName);
                    mysqli_stmt_execute($stmtItemBrand);
                    mysqli_stmt_close($stmtItemBrand);
                }

                // Return success response
                echo json_encode(array('success' => true, 'message' => $successMessage));
                exit();
            } else {
                // Update failed
                echo json_encode(array('success' => false, 'message' => 'Failed to update subcategory name'));
            }
            mysqli_stmt_close($stmt);
        } else {
            // Statement preparation failed
            echo json_encode(array('success' => false, 'message' => 'Failed to prepare statement'));
        }
    } else {
        // Missing parameters
        echo json_encode(array('success' => false, 'message' => 'Missing parameters'));
    }
} else {
    // Invalid request method
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
}
?>
