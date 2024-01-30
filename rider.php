<?php
include('connection.php');

// Work 3 - Insert Rider Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitRider'])) {
    $riderName = $_POST['rider_name'];
    $riderPhone = $_POST['rider_phone'];
    $isAvailable = isset($_POST['is_available']) ? 1 : 0;

    $sql = "INSERT INTO rider (rider_name, rider_phone, is_available) VALUES ('$riderName', '$riderPhone', $isAvailable)";

    if ($conn->query($sql) === TRUE) {
        echo "Rider added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Work 4 - Display Rider Data
if (isset($_GET['showAll'])) {
    $riderResult = $conn->query("SELECT * FROM rider");
} else {
    // Work 7 - Search Operation
    $searchColumn = isset($_GET['searchColumn']) ? $_GET['searchColumn'] : 'rider_name';
    $searchValue = isset($_GET['searchValue']) ? $_GET['searchValue'] : '';

    if (!empty($searchValue)) {
        $searchValue = $conn->real_escape_string($searchValue); // Protect against SQL injection
        $riderResult = $conn->query("SELECT * FROM rider WHERE $searchColumn = '$searchValue'");
    } else {
        $riderResult = $conn->query("SELECT * FROM rider");
    }
}

// Work 5 - Update Form Display and Handle Rider Update
if (isset($_GET['updateRiderId'])) {
    $updateRiderId = $_GET['updateRiderId'];
    $updateRiderResult = $conn->query("SELECT * FROM rider WHERE rider_id = $updateRiderId");
    $updateRiderData = $updateRiderResult->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitUpdateRider'])) {
    $updateRiderId = $_POST['updateRiderId'];
    $updateRiderName = $_POST['updateRiderName'];
    $updateRiderPhone = $_POST['updateRiderPhone'];
    $isAvailable = isset($_POST['updateIsAvailable']) ? 1 : 0;

    $sql = "UPDATE rider SET rider_name = '$updateRiderName', rider_phone = '$updateRiderPhone', is_available = $isAvailable WHERE rider_id = $updateRiderId";

    if ($conn->query($sql) === TRUE) {
        echo "Rider updated successfully";
        // Redirect back to the rider page after updating
        header("Location: rider.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Work 6 - Delete Operation
if (isset($_GET['deleteRiderId'])) {
    $deleteRiderId = $_GET['deleteRiderId'];
    $sql = "DELETE FROM rider WHERE rider_id = $deleteRiderId";

    if ($conn->query($sql) === TRUE) {
        echo "Rider deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 10px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        button {
            padding: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
        }

        button:hover {
            background-color: #0056b3;
        }

        #updateRiderForm {
            display: <?php echo isset($updateRiderId) ? 'block' : 'none'; ?>;
            margin-top: 20px;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Rider Data</h2>

    <!-- Rider Form -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="rider_name">Rider Name:</label>
        <input type="text" name="rider_name" required>

        <label for="rider_phone">Rider Phone:</label>
        <input type="text" name="rider_phone" required>

        <label for="is_available">Is Rider Available?</label>
        <input type="checkbox" name="is_available" value="1" checked> Yes
        <input type="submit" name="submitRider" value="Add Rider">
    </form>

    <!-- Add search form -->
    <form action="" method="get">
        <label for="searchColumn">Search by:</label>
        <select name="searchColumn" id="searchColumn">
            <option value="rider_name">Rider Name</option>
            <option value="rider_phone">Rider Phone</option>
            <option value="is_available">Is Rider Available</option>
        </select>
        <input type="text" name="searchValue" placeholder="Enter value">
        <input type="submit" value="Search">

        <!-- Show All button -->
        <a href="?showAll">Show All</a>
    </form>

    <!-- Rider Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Rider Name</th>
            <th>Rider Phone</th>
            <th>Rider Availability</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = $riderResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['rider_id']}</td>
                    <td>{$row['rider_name']}</td>
                    <td>{$row['rider_phone']}</td>
                    <td>{$row['is_available']}</td>
                    <td>
                        <button onclick='updateRider({$row['rider_id']})'>Update</button>
                        <button onclick='deleteRider({$row['rider_id']})'>Delete</button>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Work 5 - Update Form -->
    <div id="updateRiderForm">
        <h3>Update Rider</h3>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="updateRiderId" value="<?php echo $updateRiderId; ?>">

            <label for="updateRiderName">Rider Name:</label>
            <input type="text" name="updateRiderName" value="<?php echo $updateRiderData['rider_name']; ?>" required>

            <label for="updateRiderPhone">Rider Phone:</label>
            <input type="text" name="updateRiderPhone" value="<?php echo $updateRiderData['rider_phone']; ?>" required>

            <label for="updateIsAvailable">Is Rider Available?</label>
            <input type="checkbox" name="updateIsAvailable" value="1" <?php echo $updateRiderData['is_available'] ? 'checked' : ''; ?>> Yes
            <input type="submit" name="submitUpdateRider" value="Update Rider">
        </form>
    </div>

    <!-- JavaScript for update and delete operations -->
    <script>
        function updateRider(id) {
            window.location.href = "rider.php?updateRiderId=" + id;
        }

        function deleteRider(id) {
            if (confirm("Are you sure you want to delete this rider?")) {
                window.location.href = "rider.php?deleteRiderId=" + id;
            }
        }
    </script>
    <a href="admin.php">Back to Main</a>
</body>

</html>
