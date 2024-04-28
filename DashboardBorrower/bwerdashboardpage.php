<!-- bwerdashboardpage.php -->
<?php
// Include necessary files
include('bwerfunctions.php');

$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $borrowerId);

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

// Query to fetch items grouped by subcategory and count the available items
$queryitems = "SELECT *, COUNT(*) AS available_count FROM tblitembrand WHERE borrowable = 'Yes' AND status = 'Available' GROUP BY subcategoryname, itembrand";
$resultitems = mysqli_query($con, $queryitems);

// Initialize an empty array to store added item subcategory names and their counts
$addedItemsArray = array();

// Function to decrement count
function decrementCount($subcategoryname) {
    // Implementation for decrementing count
}

?>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }

    .ccs-main-container {
        display: flex;
        justify-content: center;
    }

    .category-row {
        cursor: pointer;
        color: black;
    }
</style>


<main class="ccs-main-container">
    <div class="container mt-1">
        <div class="row">
            <div class="col-md-9">
                <div class="d-flex justify-content-between mb-1">
                    <h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>List of Available Items</h3>
                    <div class="text-end">
                        <input type="text" class="form-control search-input mb-1" placeholder="Search" name="search" id="searchInput">
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-4 g-1">
                    <?php
                    if (mysqli_num_rows($resultitems) > 0) {
                        // If there are borrowable items, display the list
                        while ($row = mysqli_fetch_assoc($resultitems)) {
                            // Check if an image exists
                            $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $row['subcategoryname'] . '.png';
                            if (!file_exists($imagePath)) {
                                // Use a default image if no image is uploaded
                                $imagePath = '/inventory/SubcategoryItemsimages/defaultimageitem.png';
                            }

                            echo '<div class="col">
                                    <div class="card">
                                        <div class="text-center mt-2">
                                            <img src="' . $imagePath . '" class="card-img-top" alt="Item Image" style="max-width: 100px; max-height: 100px;">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">' . $row['subcategoryname'] . '</h5>
                                            <p class="card-text">Item Description <br>' . $row['itembrand'] . '</p>
                                            <p class="card-text">Available Stock: ' . $row['available_count'] . '</p>
                                            <div class="btn-group " role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-secondary" onclick="decrementCount(\'' . $row['subcategoryname'] . '\', \'' . $row['itembrand'] . '\')">-</button>
                                                <button type="button" class="btn btn-light count-btn" id="count_' . $row['subcategoryname'] . '_' . $row['itembrand'] . '">0</button>
                                                <button type="button" class="btn btn-secondary" onclick="incrementCount(\'' . $row['subcategoryname'] . '\', \'' . $row['itembrand'] . '\', ' . $row['available_count'] . ')">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                    } else {
                        // If there are no borrowable items, display a message
                        echo '<div class="text-center">
                                <h3>No borrowable items available at the moment.</h3>
                              </div>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <!-- Right-side card for items added -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chosen Items</h5>
                        <div id="addedItems"></div>
                        <div class="text-end">
                            <button type="button" class="btn btn-danger btn-sm clear-btn" onclick="clearitem()" <?php echo empty($addedItemsArray) ? 'disabled' : ''; ?>>Clear All</button>
                            <button type="button" id="reserve-btn" class="btn btn-primary btn-sm reserve-btn" <?php echo empty($addedItemsArray) ? 'disabled' : ''; ?>>Reserve</button>
                            <button type="button" id="borrow-btn" class="btn btn-success btn-sm borrow-btn" <?php echo empty($addedItemsArray) ? 'disabled' : ''; ?>>Borrow</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>

</style>
<!-- Add this script to include jQuery before your custom script -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Your custom script -->
<script>
function decrementCount(subcategoryname, itembrand) {
    var countElement = document.getElementById('count_' + subcategoryname + '_' + itembrand);
    var currentCount = parseInt(countElement.textContent);
    if (currentCount > 0) {
        currentCount--; // Decrement the current count
        countElement.textContent = currentCount; // Update the displayed count
        // Check if the item is already added to the right-side card
        var addedItems = document.getElementById('addedItems');
        var existingItem = addedItems.querySelector('p[data-subcategory="' + subcategoryname + '"][data-itembrand="' + itembrand + '"]');
        if (existingItem) {
            // If the item already exists, update its count
            updateItemText(existingItem, subcategoryname, itembrand, currentCount);
            // If the count becomes zero, remove the item from the right-side card
            if (currentCount === 0) {
                existingItem.remove();
            }
            // Enable/disable buttons based on added items
            updateButtonStatus();
        }
    }
}

function incrementCount(subcategoryname, itembrand, availableCount) {
    var countElement = document.getElementById('count_' + subcategoryname + '_' + itembrand);
    var currentCount = parseInt(countElement.textContent);
    if (currentCount < availableCount) {
        currentCount++; // Increment the current count
        countElement.textContent = currentCount; // Update the displayed count
        // Check if the item is already added to the right-side card
        var addedItems = document.getElementById('addedItems');
        var existingItem = addedItems.querySelector('p[data-subcategory="' + subcategoryname + '"][data-itembrand="' + itembrand + '"]');
        if (existingItem) {
            // If the item already exists, update its count
            updateItemText(existingItem, subcategoryname, itembrand, currentCount);
        } else {
            // If the item is not added, create a new element
            var newItem = document.createElement("p");
            updateItemText(newItem, subcategoryname, itembrand, currentCount);
            newItem.setAttribute('data-subcategory', subcategoryname); // Set data attribute for subcategory
            newItem.setAttribute('data-itembrand', itembrand); // Set data attribute for itembrand
            addedItems.appendChild(newItem);
        }
        // Enable/disable buttons based on added items
        updateButtonStatus();
    }
}

function updateItemText(element, subcategoryname, itembrand, count) {
    // Clear the existing content of the element
    element.innerHTML = '';
    // Create text nodes for subcategory name and item brand
    var subcategoryNode = document.createTextNode(subcategoryname + ' (Quantity: ' + count+')');
    var itembrandNode = document.createTextNode( itembrand);
    // Append the text nodes to the element
    element.appendChild(subcategoryNode);
    element.appendChild(document.createElement('br')); // Add line break
    element.appendChild(itembrandNode);
}

function updateButtonStatus() {
    var addedItems = document.getElementById('addedItems');
    var clearBtn = document.querySelector('.clear-btn');
    var reserveBtn = document.querySelector('.reserve-btn');
    var borrowBtn = document.querySelector('.borrow-btn');

    // Enable buttons if there are items in the addedItems div, otherwise disable them
    if (addedItems.children.length > 0) {
        clearBtn.removeAttribute('disabled');
        reserveBtn.removeAttribute('disabled');
        borrowBtn.removeAttribute('disabled');
    } else {
        clearBtn.setAttribute('disabled', 'disabled');
        reserveBtn.setAttribute('disabled', 'disabled');
        borrowBtn.setAttribute('disabled', 'disabled');
    }
}


function clearitem() {
    var confirmationMessage = 'Are you sure you want to clear all items?';
    var isConfirmed = confirm(confirmationMessage);

    if (isConfirmed) {
        // Redirect to updateUserStatus.php with appropriate parameters
        window.location.href = 'borrowerDashboardPage.php';
    }
}

document.getElementById('borrow-btn').addEventListener('click', function() {
    // Get the added items
    var addedItems = document.getElementById('addedItems').querySelectorAll('p');
    var itemsArray = [];

    // Iterate through added items and extract subcategory name, count, and item brand
    addedItems.forEach(function(item) {
        var subcategoryname = item.getAttribute('data-subcategory'); // Extract subcategory name
        var count = parseInt(item.textContent.match(/\d+/)[0]); // Extract count
        var itembrand = item.getAttribute('data-itembrand'); // Extract item brand

        itemsArray.push({subcategoryname: subcategoryname, count: count, itembrand: itembrand}); // Include item brand in the array
    });

    // Convert the itemsArray to JSON
    var itemsJSON = JSON.stringify(itemsArray);

    // Encode the JSON data
    var encodedItemsJSON = encodeURIComponent(itemsJSON);

    // Construct the URL with the encoded itemsJSON
    var url = 'borrowerConfirmBorrowRequest.php?items=' + encodedItemsJSON;

    // Redirect to the constructed URL
    window.location.href = url;
});

document.getElementById('reserve-btn').addEventListener('click', function() {
    // Get the added items
    var addedItems = document.getElementById('addedItems').querySelectorAll('p');
    var itemsArray = [];

    // Iterate through added items and extract subcategory name, count, and item brand
    addedItems.forEach(function(item) {
        var subcategoryname = item.getAttribute('data-subcategory'); // Extract subcategory name
        var count = parseInt(item.textContent.match(/\d+/)[0]); // Extract count
        var itembrand = item.getAttribute('data-itembrand'); // Extract item brand

        itemsArray.push({subcategoryname: subcategoryname, count: count, itembrand: itembrand}); // Include item brand in the array
    });

    // Convert the itemsArray to JSON
    var itemsJSON = JSON.stringify(itemsArray);

    // Encode the JSON data
    var encodedItemsJSON = encodeURIComponent(itemsJSON);

    // Construct the URL with the encoded itemsJSON
    var url = 'borrowerConfirmReserveRequest.php?items=' + encodedItemsJSON;

    // Redirect to the constructed URL
    window.location.href = url;
});

$(document).ready(function() {
    // Function to filter items based on search input
    $('#searchInput').on('input', function() {
        var searchText = $(this).val().toLowerCase(); // Get the value of the search input and convert it to lowercase

        $('.card').each(function() {
            var card = $(this);
            var cardText = card.text().toLowerCase(); // Get the text content of the card and convert it to lowercase
            // Check if the card text contains the search text
            if (cardText.includes(searchText) || card.find('#addedItems').length > 0) {
                card.show(); // Show the card if it matches the search criteria or if it contains the #addedItems div
            } else {
                card.hide(); // Hide the card if it does not match the search criteria and does not contain the #addedItems div
            }
        });

        // Check if all cards are hidden
        if ($('.card:visible').length === 0) {
            // If all cards are hidden, hide the right-side card
            $('.col-md-3').hide();
        } else {
            // Otherwise, show the right-side card
            $('.col-md-3').show();
        }
    });
});

</script>
