<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Equipment Rental</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .booked {
            background-color: #f44336;
            color: white;
        }
        .available {
            background-color: #4CAF50;
            color: white;
        }
        .btn {
            padding: 8px 15px;
            text-decoration: none;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-book {
            background-color: #4CAF50;
        }
        .btn-cancel {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agriculture Equipment Rental</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price/Day</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "Test";
                $password = "Test@123";
                $dbname = "rental_management";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $id = $_POST['id'];
                    if ($_POST['action'] == 'book') {
                        $conn->query("UPDATE equipment SET availability = 0 WHERE id = $id");
                    } elseif ($_POST['action'] == 'cancel') {
                        $conn->query("UPDATE equipment SET availability = 1 WHERE id = $id");
                    }
                }

                $result = $conn->query("SELECT * FROM equipment");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['type']}</td>";
                    echo "<td>\${$row['price_per_day']}</td>";
                    echo "<td class='" . ($row['availability'] ? "available" : "booked") . "'>" . ($row['availability'] ? "Available" : "Booked") . "</td>";
                    echo "<td>";
                    if ($row['availability']) {
                        echo "<form method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='hidden' name='action' value='book'>
                                <button class='btn btn-book' type='submit'>Book</button>
                              </form>";
                    } else {
                        echo "<form method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='hidden' name='action' value='cancel'>
                                <button class='btn btn-cancel' type='submit'>Cancel</button>
                              </form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
