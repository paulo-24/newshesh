<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['image'])) {
    $imageData = $_POST['image'];
    
    // Remove data prefix
    $filteredData = substr($imageData, strpos($imageData, ',') + 1);

    // Decode the base64 data
    $decodedData = base64_decode($filteredData);

    // Generate a unique filename
    $imageName = uniqid() . '.png';

    // Path to save the image (in the "images" folder)
    $imagePath = 'employee_Photo/' . $imageName;

    // Save the image to the server
    file_put_contents($imagePath, $decodedData);

    // Save image information to the database
    include 'php/database.php'; // Include the database connection

    $sql = "INSERT INTO images (image_name, image_path) VALUES ('$imageName', '$imagePath')";
    
    if (mysqli_query($connection, $sql)) {
        // Return the image as a downloadable attachment
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $imageName . '"');
        readfile($imagePath);
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }

    mysqli_close($connection);
} else {
    echo "Invalid request";
}
?>
