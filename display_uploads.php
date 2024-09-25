<?php
// Include the database connection file
include('db.php');

// Fetch uploaded content
$uploads = '';
$result_uploads = $conn->query("SELECT * FROM uploads");
if ($result_uploads->num_rows > 0) {
    $uploads .= "<h2>Uploaded Content:</h2><table class='uploads-table'>
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Number</th>
                          <th>Details</th>
                          <th>Image</th>
                      </tr>
                  </thead>
                  <tbody>";
    while ($row = $result_uploads->fetch_assoc()) {
        $uploads .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['numbers']}</td>
                        <td>{$row['details']}</td>
                        <td><img src='{$row['image']}' alt='Uploaded Image' class='upload-image'/></td>
                    </tr>";
    }
    $uploads .= "</tbody></table>";
} else {
    $uploads .= "<p>No uploads found.</p>";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Uploads</title>
    <link rel="stylesheet" type="text/css" href="display_uploads.css">
</head>
<body>
    <div class="container">
        <?php echo $uploads; ?>
    </div>
</body>
</html>
