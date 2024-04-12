<!-- subcategorycontainer.php -->
<?php
// Query to fetch categories
$querySubcategories = "SELECT * FROM tblsubcategory ORDER BY categoryname";
$resultSubcategories = mysqli_query($con, $querySubcategories);

// Query to fetch categories
$queryCategoriesDropdown = "SELECT * FROM tblitemcategory ORDER BY categoryname";
$resultCategoriesDropdown = mysqli_query($con, $queryCategoriesDropdown);



if (isset($_POST["addSubcategory"])) {
    $subcategoryName = $_POST['subcategoryName'];
    $selectedCategory = $_POST['selectedCategory'];

    // Check if subcategory with the same name and category already exists
    $queryCheckSubcategory = "SELECT subcategoryname FROM tblsubcategory WHERE subcategoryname = ? AND categoryname = ?";
    $stmtCheckSubcategory = mysqli_prepare($con, $queryCheckSubcategory);

    if ($stmtCheckSubcategory) {
        mysqli_stmt_bind_param($stmtCheckSubcategory, "ss", $subcategoryName, $selectedCategory);

        if (mysqli_stmt_execute($stmtCheckSubcategory)) {
            $resultCheckSubcategory = mysqli_stmt_get_result($stmtCheckSubcategory);

            if ($resultCheckSubcategory && mysqli_fetch_assoc($resultCheckSubcategory)) {
                // Subcategory with the same name and category already exists, display error message
                echo "<div class='alert alert-danger' role='alert'>Subcategory '{$subcategoryName}' already exists in '{$selectedCategory}'</div>";
            } else {
                // Proceed with adding a new subcategory
                $queryInsert = "INSERT INTO `tblsubcategory` (`categoryname`, `subcategoryname`) VALUES (?, ?)";
                $stmtInsert = mysqli_prepare($con, $queryInsert);

                if ($stmtInsert) {
                    mysqli_stmt_bind_param($stmtInsert, "ss", $selectedCategory, $subcategoryName);

                    if (mysqli_stmt_execute($stmtInsert)) {
    

                        // Handle file upload
                        $image = $_FILES['image'];
                        $imageName = preg_replace("/[^a-zA-Z0-9]/", " ", $_POST['subcategoryName']);

                        // Check if an image was uploaded
                        if (!empty($image['name'])) {
                            if ($image['error'] == UPLOAD_ERR_OK) {
                                $uploadDir = 'inventory/SubcategoryItemsimages/';

                                // Check if the directory exists, create it if not
                                if (!is_dir($uploadDir)) {
                                    mkdir($uploadDir, 0755, true);
                                }

                                $uploadPath = $uploadDir . $imageName . '.png';

                                // Move the uploaded file to the specified location
                                if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                                    echo "<script>window.location.href='ccstaffManageSubcategory.php?msg_success=New Item created successfully'</script>";
                                    exit();
                                } else {
                                    echo "Failed to move uploaded file.";
                                    exit();
                                }
                            } else {
                                echo "Failed to upload file. Error code: " . $image['error'];
                                exit();
                            }
                        } else {
                            // No file was uploaded, proceed without handling the image
                            echo "<script>window.location.href='ccstaffManageSubcategory.php?msg_success=New subcategory created successfully'</script>";
                            exit();
                        }
                    } else {
                        echo "Failed: " . mysqli_error($con);
                        exit();
                    }

                    mysqli_stmt_close($stmtInsert);
                } else {
                    echo "Failed to prepare statement: " . mysqli_error($con);
                    exit();
                }
            }
        } else {
            echo "Failed to execute subcategory check statement: " . mysqli_error($con);
            exit();
        }

        mysqli_stmt_close($stmtCheckSubcategory);
    } else {
        echo "Failed to prepare subcategory check statement: " . mysqli_error($con);
        exit();
    }
}

// Delete subcategory logic
if (isset($_GET["subcategoryid"])) {
    $subcategoryid = $_GET["subcategoryid"];

    // Fetch the category and subcategory names before deletion
    $querySelectData = "SELECT categoryname, subcategoryname FROM `tblsubcategory` WHERE id = ?";
    $stmtSelectData = mysqli_prepare($con, $querySelectData);

    if ($stmtSelectData) {
        mysqli_stmt_bind_param($stmtSelectData, "i", $subcategoryid);

        if (mysqli_stmt_execute($stmtSelectData)) {
            $resultSelectData = mysqli_stmt_get_result($stmtSelectData);

            if ($resultSelectData && $row = mysqli_fetch_assoc($resultSelectData)) {
                $selectedCategoryToDelete = $row['categoryname'];
                $subcategoryNameToDelete = $row['subcategoryname'];
            }
        }
        mysqli_stmt_close($stmtSelectData);
    }

    // Check if the subcategory has associated items
    $queryCheckItems = "SELECT COUNT(id) AS item_count FROM tblitembrand WHERE subcategoryname = ?";
    $stmtCheckItems = mysqli_prepare($con, $queryCheckItems);

    if ($stmtCheckItems) {
        mysqli_stmt_bind_param($stmtCheckItems, "s", $subcategoryNameToDelete);

        if (mysqli_stmt_execute($stmtCheckItems)) {
            $resultCheckItems = mysqli_stmt_get_result($stmtCheckItems);

            if ($resultCheckItems && $row = mysqli_fetch_assoc($resultCheckItems)) {
                $itemCount = $row['item_count'];

                if ($itemCount >= 1) {
                    // Items are associated with the subcategory, do not proceed with deletion
                    echo "<script>window.location.href='ccstaffManageSubcategory.php?msg_fail=Cannot delete Item with items associated.'</script>";
                } else {
                    // No items associated, proceed with subcategory deletion
                    $queryDeleteSubcategory = "DELETE FROM `tblsubcategory` WHERE id = ?";
                    $stmtDeleteSubcategory = mysqli_prepare($con, $queryDeleteSubcategory);

                    if ($stmtDeleteSubcategory) {
                        mysqli_stmt_bind_param($stmtDeleteSubcategory, "i", $subcategoryid);

                        if (mysqli_stmt_execute($stmtDeleteSubcategory)) {
                            // Deletion successful
                            // Delete the associated image file
                            $imagePathToDelete = 'inventory/SubcategoryItemsimages/' . $subcategoryNameToDelete . '.png';
                            if (file_exists($imagePathToDelete)) {
                                unlink($imagePathToDelete);
                            }

                            echo "<script>window.location.href='ccstaffManageSubcategory.php?msg_success=Item deleted successfully'</script>";
                            exit();
                        } else {
                            echo "Failed to delete subcategory: " . mysqli_error($con);
                            exit();
                        }

                        mysqli_stmt_close($stmtDeleteSubcategory);
                    } else {
                        echo "Failed to prepare deletion statement: " . mysqli_error($con);
                        exit();
                    }
                }
            } else {
                echo "Failed to fetch item count: " . mysqli_error($con);
                exit();
            }
        } else {
            echo "Failed to execute item count statement: " . mysqli_error($con);
            exit();
        }

        mysqli_stmt_close($stmtCheckItems);
    } else {
        echo "Failed to prepare item count statement: " . mysqli_error($con);
        exit();
    }
}


$search = isset($_GET["search"]) ? $_GET["search"] : '';
$sql = "SELECT * FROM `tblsubcategory` WHERE categoryname LIKE '%$search%' OR subcategoryname LIKE '%$search%'";
$result = mysqli_query($con, $sql);

// Fetch subcategories with the count of occurrences from tblitembrand
$querySubcategories = "
    SELECT 
        s.*,
        COUNT(b.id) AS sameSubcategoryCount
    FROM 
        tblsubcategory s
    LEFT JOIN 
        tblitembrand b ON s.subcategoryname = b.subcategoryname
    GROUP BY 
        s.id, s.categoryname, s.subcategoryname
    ORDER BY 
        s.categoryname, s.subcategoryname
";
$resultSubcategories = mysqli_query($con, $querySubcategories);
?>
<!-- Bootstrap JavaScript (Ensure it's included after jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Modal HTML Structure -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                <input type="hidden" id="subcategoryId" name="subcategoryId">
                <input type="hidden" id="oldSubcategoryName" name="oldSubcategoryName">
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="" alt="Upload New Image" id="subcategoryImage" style="max-width: 150px;">
                </div>
                <div class="mb-3">
                    <label for="subcategoryName" class="form-label">Item Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="subcategoryName" name="subcategoryName" required>
                </div>
                <div class="mb-2">
                    <label for="image" class="form-label">Upload New Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>


<div class="container mt-3">
    <div class="row">
        <!-- Left side: Add Subcategory form -->
        <div class="col-md-4">
            <h4><i class="fas fa-plus-circle me-2"></i>Add Subcategory</h4>
            <!-- Form to add a new subcategory -->
            <form action="ccstaffManageSubcategory.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="selectedCategory" class="form-label">Select Category:<span class="text-danger">*</span></label>
                    <select class="form-select" id="selectedCategory" name="selectedCategory" required>
                        <!-- Add a blank option -->
                        <option value="" selected disabled>Select Category</option>
                        <?php
                        while ($categoryRow = mysqli_fetch_assoc($resultCategoriesDropdown)) {
                            echo "<option value='{$categoryRow['categoryname']}'>{$categoryRow['categoryname']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="subcategoryName" class="form-label">Item Name:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="subcategoryName" name="subcategoryName" required>
                </div>
                <div class="mb-2">
                    <label for="image" class="form-label">Upload Image:</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-success" name="addSubcategory">Confirm</button>
            </form>
        </div>

            <!-- Right side: Subcategories table -->
            <div class="col-md-8">
                <div class="row">
                <div class="col-md-8 ">
                    <h2>List of Items</h2>
                </div>
                <div class="col-md-4 text-end">
                <form action="" method="GET" class="input-group">
                    <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
                </form>
                </div>
            </div>
            <!-- Table to display existing Subcategories -->
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Item Name</th>                  
                        <th scope="col">Total item</th>
                        <th scope="col" class='text-center'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $currentCategory = null;
                    while ($row = mysqli_fetch_assoc($resultSubcategories)) {
                        // Check if the category has changed
                        if ($currentCategory != $row['categoryname']) {
                            // Display the category name row with a class for click event
                            echo "<tr class='category-row'>
                                    <td colspan='9' style='background-color: azure;'><strong>{$row['categoryname']}</strong></td>       
                                  </tr>";
                            $currentCategory = $row['categoryname'];
                        }
                        
                        echo "<tr>";      
                                         
                        // Check if an image exists, if not, use a default image
                        $imagePath = 'inventory/SubcategoryItemsimages/' . $row['subcategoryname'] . '.png';
                        if (file_exists($imagePath)) {
                            echo "<td class='text-center'><img src='{$imagePath}' alt='Subcategory Image' width='50'></td>";
                        } else {
                            // Use a default image if no image is uploaded
                            echo "<td class='text-center'><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                        }            
                        echo "<td>{$row['subcategoryname']}</td>";  
                        echo "<td>{$row['sameSubcategoryCount']}</td>";
                        echo "<td class='text-center'>
                                <a class=\"btn btn-outline-primary btn-sm\" onclick=\"editItem('{$row['id']}', '{$row['subcategoryname']}')\"><i class='fa-solid fa-pen-to-square fs-7 me-2'></i>Edit</a>
                                <a href=\"#\" onclick=\"confirmDeleteSubcategory('{$row['id']}')\" class=\"btn btn-outline-danger btn-sm\"><i class='fa-solid fa-trash fs-7'></i>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

      
     function confirmDeleteSubcategory(subcategoryId, sameSubcategoryCount) {
        if (sameSubcategoryCount >= 1) {
            alert("Cannot delete subcategory with items associated.");
            return;
        }

        var confirmDelete = confirm("Are you sure you want to delete this subcategory?");

        if (confirmDelete) {
            window.location.href = "ccstaffManageSubcategory.php?subcategoryid=" + subcategoryId;
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('.table tbody tr');

            searchInput.addEventListener('input', function () {
                const searchValue = this.value.toLowerCase();

                tableRows.forEach(function (row) {
                    const rowData = row.textContent.toLowerCase();
                    row.style.display = rowData.includes(searchValue) ? '' : 'none';
                });
            });
    });

      // Function to handle file input change
      $("#image").change(function () {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#subcategoryImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
        
    function editItem(subcategoryId, subcategoryName) {
    // Populate the modal with the subcategory ID and name
    $('#editModal').modal('show');
    $('#subcategoryName').val(subcategoryName);

    // Store the subcategoryId and current subcategory name in hidden inputs for later use
    $('#subcategoryId').val(subcategoryId);
    $('#oldSubcategoryName').val(subcategoryName);

    // Get the URL of the subcategory image
    var imagePath = 'inventory/SubcategoryItemsimages/' + subcategoryName + '.png';

    // Set the src attribute of the img tag
    $('#subcategoryImage').attr('src', imagePath);
    }


    $('#saveChangesBtn').click(function() {
    // Get the subcategory ID, current subcategory name, new subcategory name, and the new image file
    var subcategoryId = $('#subcategoryId').val();
    var oldSubcategoryName = $('#oldSubcategoryName').val();
    var newSubcategoryName = $('#subcategoryName').val();
    var newImageFile = $('#image')[0].files[0]; // Get the file object

    // Create a FormData object to send file data
    var formData = new FormData();
    // Append the subcategory ID, current subcategory name, and new subcategory name to FormData
    formData.append('subcategoryId', subcategoryId);
    formData.append('oldSubcategoryName', oldSubcategoryName);
    formData.append('newSubcategoryName', newSubcategoryName);

    // Client-side validation to check if the new subcategory name is empty
    if (newSubcategoryName.trim() === '') {
        alert("Subcategory name cannot be empty.");
        return;
    }

    // Check if a new image file is selected and append it to FormData
    if (newImageFile) {
        formData.append('image', newImageFile);
    }
    // Send an AJAX request to update the subcategory details
    $.ajax({
        url: 'ccsupdate_subcategory_details.php',
        method: 'POST',
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting contentType
        success: function(response) {
            // Redirect back to ccstaffManageSubcategory.php with success message
            window.location.href = 'ccstaffManageSubcategory.php?msg_success=Item updated successfully';
            // Close the modal or perform any other necessary actions
            $('#editModal').modal('hide');
        },
        error: function(xhr, status, error) {
            // Handle errors if needed
            console.error(xhr.responseText);
        }
    });
});
</script>