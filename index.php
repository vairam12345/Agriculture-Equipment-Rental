<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Equipment Rental</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Agriculture Equipment Rental</h1>
        <input type="text" id="searchBar" placeholder="Search equipment..." onkeyup="filterTable()">
        <table id="equipmentTable">
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
                $conn = new mysqli("localhost", "root", "", "rental_management");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM equipment";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['type']}</td>
                            <td>\${$row['price_per_day']}</td>
                            <td>";
                        if ($row['availability']) {
                            echo "<button class='btn book-btn' onclick='bookItem({$row['id']})'>Book</button>";
                        } else {
                            echo "<button class='btn return-btn' onclick='returnItem({$row['id']})'>Return</button>";
                        }
                        echo " <button class='btn details-btn' onclick='viewDetails({$row['id']})'>Details</button>
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

    <script>
        function bookItem(id) {
            fetch(`book.php?id=${id}`)
                .then(response => response.text())
                .then(data => location.reload());
        }

        function returnItem(id) {
            fetch(`return.php?id=${id}`)
                .then(response => response.text())
                .then(data => location.reload());
        }

        function viewDetails(id) {
            alert(`Details for equipment ID: ${id}`);
        }

        function filterTable() {
            const search = document.getElementById("searchBar").value.toLowerCase();
            const rows = document.querySelectorAll("#equipmentTable tbody tr");

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                if (name.includes(search)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>
