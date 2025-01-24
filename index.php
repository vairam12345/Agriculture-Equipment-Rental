<?php
require 'config.php';

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    $equipmentId = intval($_POST['book_id']); // Sanitize input

    // Prepare statement to avoid SQL injection
    $stmt = $conn->prepare("UPDATE equipment SET availability = 0 WHERE id = ?");
    $stmt->bind_param("i", $equipmentId); // Bind the integer parameter to the query

    if ($stmt->execute()) {
        echo "<script>alert('Booking successful!');</script>";
    } else {
        echo "<script>alert('Error during booking.');</script>";
    }

    $stmt->close(); // Close the prepared statement
}

// Fetch available equipment
$sql = "SELECT * FROM equipment WHERE availability = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Equipment Rental</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Agriculture Equipment Rental</h1>
        <table>
            <thead>
                <tr>
                    <th>Equipment Name</th>
                    <th>Type</th>
                    <th>Price/Day</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['type']); ?></td>
                            <td>$<?php echo number_format($row['price_per_day'], 2); ?></td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="book-btn">Book</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No equipment available at the moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
