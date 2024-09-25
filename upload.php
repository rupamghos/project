<?php
// Include the database connection file
include('db.php');

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload'])) {
    $number = $_POST['upload_number'];
    $details = $_POST['upload_details'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["upload_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["upload_image"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["upload_image"]["size"] > 500000) { // Limit to 500 KB
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["upload_image"]["tmp_name"], $target_file)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO uploads (numbers, details, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $number, $details, $target_file);
            $stmt->execute();
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Upload Image and Text</h1>
        <form method="post" action="upload.php" enctype="multipart/form-data">
            <input type="text" name="upload_number" placeholder="Enter number" required>
            <textarea name="upload_details" placeholder="Enter details" required style="height: 200px; width:460px"></textarea>
            <input type="file" name="upload_image" required>
            <button type="submit" name="upload">Upload</button>
        </form>
    </div>
</body>
</html>

