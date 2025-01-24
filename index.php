<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Equipment Rental</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <img src="logo.png" alt="Logo" class="logo">
        <h1>Agriculture Equipment Rental</h1>
    </nav>

    <div class="container">
        <h2>Available Equipment</h2>
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
                <?php
                $conn = new mysqli("localhost", "root", "Test@123", "rental_management");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM equipment WHERE availability = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["name"] . "</td>
                                <td>" . $row["type"] . "</td>
                                <td>$" . number_format($row["price_per_day"], 2) . "</td>
                                <td>
                                    <button class='book-btn'>Book</button>
                                    <button class='details-btn'>Details</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No equipment available</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
