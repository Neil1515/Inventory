<!-- categorycontainer.php -->
<?php
// Include necessary files
include 'ccsfunctions.php';


// Query to fetch categories with subcategory count
$queryCategories = "SELECT c.id, c.categoryname, COUNT(s.subcategoryname) AS subcategory_count
                    FROM tblitemcategory c
                    LEFT JOIN tblsubcategory s ON c.categoryname = s.categoryname
                    GROUP BY c.id, c.categoryname
                    ORDER BY c.categoryname";

$resultCategories = mysqli_query($con, $queryCategories);

// Process form submission for adding a new category
if (isset($_POST["addCategory"])) {
    $categoryName = $_POST['categoryName'];

    // Check if category with the same name already exists
    $queryCheckCategory = "SELECT categoryname FROM tblitemcategory WHERE categoryname = ?";
    $stmtCheckCategory = mysqli_prepare($con, $queryCheckCategory);

    if ($stmtCheckCategory) {
        mysqli_stmt_bind_param($stmtCheckCategory, "s", $categoryName);

        if (mysqli_stmt_execute($stmtCheckCategory)) {
            $resultCheckCategory = mysqli_stmt_get_result($stmtCheckCategory);

            if ($resultCheckCategory && $row = mysqli_fetch_assoc($resultCheckCategory)) {
                // Category with the same name already exists, display error message
                echo "<script>window.location.href='ccstaffManageCategory.php?msg_fail=Category \"$categoryName\" already exists';</script>";
                exit();
            }
        } else {
            echo "Failed to execute category check statement: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmtCheckCategory);
    } else {
        echo "Failed to prepare category check statement: " . mysqli_error($con);
    }

    // Proceed with adding a new category
    $queryInsert = "INSERT INTO `tblitemcategory` (`categoryname`) VALUES (?)";
    $stmtInsert = mysqli_prepare($con, $queryInsert);

    if ($stmtInsert) {
        mysqli_stmt_bind_param($stmtInsert, "s", $categoryName);

        if (mysqli_stmt_execute($stmtInsert)) {
            echo "<script>window.location.href='ccstaffManageCategory.php?msg_success=New category created successfully';</script>";
            exit();
        } else {
            echo "Failed: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmtInsert);
    } else {
        echo "Failed to prepare statement: " . mysqli_error($con);
    }
}

// Process form submission for deleting a category
if (isset($_GET["categoryname"])) {
    $categoryName = $_GET["categoryname"];

    // Check if the category has associated subcategories
    $queryCheckSubcategories = "SELECT COUNT(*) AS subcategory_count FROM tblsubcategory WHERE categoryname = ?";
    $stmtCheckSubcategories = mysqli_prepare($con, $queryCheckSubcategories);

    if ($stmtCheckSubcategories) {
        mysqli_stmt_bind_param($stmtCheckSubcategories, "s", $categoryName);

        if (mysqli_stmt_execute($stmtCheckSubcategories)) {
            $resultCheckSubcategories = mysqli_stmt_get_result($stmtCheckSubcategories);

            if ($resultCheckSubcategories && $row = mysqli_fetch_assoc($resultCheckSubcategories)) {
                $subcategoryCount = $row["subcategory_count"];

                if ($subcategoryCount > 0) {
                    // Category has associated subcategories, display error message
                    echo "<script>window.location.href='ccstaffManageCategory.php?msg_fail=Cannot delete category \"$categoryName\". It has associated subcategories';</script>";
                    exit();
                }
            }
        } else {
            echo "Failed to execute subcategory check statement: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmtCheckSubcategories);
    } else {
        echo "Failed to prepare subcategory check statement: " . mysqli_error($con);
    }

    // Proceed with deleting the category
    $queryDelete = "DELETE FROM tblitemcategory WHERE categoryname = ?";
    $stmtDelete = mysqli_prepare($con, $queryDelete);

    if ($stmtDelete) {
        mysqli_stmt_bind_param($stmtDelete, "s", $categoryName);

        if (mysqli_stmt_execute($stmtDelete)) {
            echo "<script>window.location.href='ccstaffManageCategory.php?msg_success=Category deleted successfully';</script>";
            exit();
        } else {
            echo "Failed to execute delete statement: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmtDelete);
    } else {
        echo "Failed to prepare delete statement: " . mysqli_error($con);
    }
}
?>

<script>
    function confirmDeleteCategory(categoryname) {
        var confirmDelete = confirm("Are you sure you want to delete the category " + categoryname + "?");

        if (confirmDelete) {
            window.location.href = "ccstaffManageCategory.php?categoryname=" + categoryname;
        }
    }
</script>
<div class="container mt-3">
    <div class="row">
        <!-- Left side: Add Category form -->
        <div class="col-md-3">
            <h4 class="mb-3"><i class="fas fa-plus-circle me-2"></i>Add Category</h4>
            <!-- Form to add a new category -->
            <form action="ccstaffManageCategory.php" method="post">
                <div class="mb-2">
                    <label for="categoryName" class="form-label">Category Name:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                </div>
                <button type="submit" class="btn btn-success"  name="addCategory">Submit</button>
                <div class="mb-3">
                </div>
            </form>
        </div>
        <!-- Right side: Categories table -->
        <div class="col-md-9">
            <h2>List of Categories</h2>
            <!-- Table to display existing categories -->
            <table id="example" class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($resultCategories)) {
                        echo "<tr>";
                        echo "<td>{$row['categoryname']}</td>";
                        echo "<td >{$row['subcategory_count']}</td>";
                        echo "<td> <a href=\"#\" onclick=\"confirmDeleteCategory('{$row['categoryname']}')\" class=\"btn btn-outline-danger btn-sm\"><i class='fa-solid fa-trash fs-7'></i>Delete</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<!-- jQuery and Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>