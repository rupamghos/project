<?php
// Include the database connection file
include('db.php');

// Handle search
$result = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $number = $_POST['number'];
    $stmt = $conn->prepare("SELECT * FROM user WHERE numbers = ?");
    $stmt->bind_param("s", $number);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $number, $details);
        $result = "<table>
                      <tr>
                          <th>ID</th>
                          <th>Number</th>
                          <th>Details</th>
                      </tr>";
        while ($stmt->fetch()) {
            $result .= "<tr>
                          <td>$id</td>
                          <td>$number</td>
                          <td>$details</td>
                        </tr>";
        }
        $result .= "</table>";
    } else {
        $result = "<p>Number not found.</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Number Search</title>
    <!-- Ensure correct linking of the CSS file -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Search for a Number</h1>
        <form method="post" action="search.php">
            <input type="text" name="number" placeholder="Enter number" required>
            <button type="submit" name="search">Search</button>
        </form>
        
        <div class="result-container">
            <h2>Result:</h2>
            <?php echo $result; ?>
        </div>
    </div>
</body>
</html>
