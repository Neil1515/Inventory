<?php
//getImageForSubcategory.php
include 'ccsfunctions.php';

header('Content-Type: application/json'); // Set the content type to JSON

if (isset($_POST['subcategoryName'])) {
    $subcategoryName = $_POST['subcategoryName'];

    // Construct the image URL for the selected subcategory
    $imagePath = 'inventory/SubcategoryItemsimages/' . strtolower($subcategoryName) . '.png';

    // Check if the image file exists
    if (file_exists($imagePath)) {
        $imageUrl = $imagePath;
    } else {
        // Use a default image if no image is uploaded for the subcategory
        $imageUrl = 'inventory/SubcategoryItemsimages/defaultimageitem.png';
    }

    // Send a valid JSON response and exit
    echo json_encode(['imageUrl' => $imageUrl, 'subcategoryName' => $subcategoryName]);
    exit();
} else {
    // Send a proper HTTP response code for invalid request and exit
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit();
}
?>
