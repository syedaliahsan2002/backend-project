<?php
include('connection.php');

// Work 3 - Insert Product Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitProduct'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    // Handle image upload
    $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
    $p_image = 'uploaded_img/' . $_FILES['p_image']['name'];
    move_uploaded_file($p_image_tmp_name, $p_image);

    $sql = "INSERT INTO product (name, p_category, image, price) VALUES ('$name', '$category', '$p_image', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Work 4 - Display Product Data
$searchColumn = isset($_GET['searchColumn']) ? $_GET['searchColumn'] : 'name';
$searchValue = isset($_GET['searchValue']) ? $_GET['searchValue'] : '';

if (!empty($searchValue)) {
    $searchValue = $conn->real_escape_string($searchValue); // Protect against SQL injection
    $result = $conn->query("SELECT * FROM product WHERE $searchColumn LIKE '%$searchValue%'");
} else {
    $result = $conn->query("SELECT * FROM product");
}

// Check if the query was successful
if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    // ... (your existing code for displaying product data)
}

// Work 6 - Delete Operation
if (isset($_GET['deleteProductId'])) {
    $deleteProductId = $_GET['deleteProductId'];
    $sql = "DELETE FROM product WHERE product_id = $deleteProductId";

    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully";
        // Redirect back to the product page after deleting
        header("Location: product.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Work 5 - Update Form Display and Handle Product Update
if (isset($_GET['updateProductId'])) {
    $updateProductId = $_GET['updateProductId'];
    $updateProductResult = $conn->query("SELECT * FROM product WHERE product_id = $updateProductId");
    $updateProductData = $updateProductResult->fetch_assoc();

    if ($updateProductData) {
        // Update form is displayed only when a valid product is found
        echo "Update Product ID: $updateProductId"; // Debugging statement
    } else {
        echo "No product found for Update Product ID: $updateProductId"; // Debugging statement
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitUpdateProduct'])) {
    // Process the update form submission
    $updateProductId = $_POST['updateProductId'];
    $updateName = $_POST['updateName'];
    $updateCategory = $_POST['updateCategory'];

    // Handle image update
    if ($_FILES['updateImage']['size'] > 0) {
        $updateImageTmpName = $_FILES['updateImage']['tmp_name'];
        $updateImage = 'uploaded_img/' . $_FILES['updateImage']['name'];
        move_uploaded_file($updateImageTmpName, $updateImage);
    } else {
        // If no new image is uploaded, keep the existing image path
        $updateImage = $updateProductData['image'];
    }

    $updatePrice = $_POST['updatePrice'];

    $sql = "UPDATE product SET name = '$updateName', p_category = '$updateCategory', image = '$updateImage', price = '$updatePrice' WHERE product_id = $updateProductId";

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully";
        // Redirect back to the product page after updating
        header("Location: product.php");
        exit();
        
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
    <title>Product Management</title>
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
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="file"],
        input[type="number"],
        input[type="submit"] {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
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

        img {
            max-width: 100%;
            height: auto;
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

        #updateForm {
            display: <?php echo isset($updateProductId) ? 'block' : 'none'; ?>;
            margin-top: 20px;
            background-color: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
    <h2>Product Data</h2>

    <!-- Product Form -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" required>

        <label for="category">Category:</label>
        <input type="text" name="category" required>

        <label for="p_image">Image:</label>
        <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>

        <label for="price">Price:</label>
        <input type="number" name="price" required>

        <input type="submit" name="submitProduct" value="Add Product">
    </form>

    <!-- Add search form -->
    <form action="" method="get">
        <label for="searchColumn">Search by:</label>
        <select name="searchColumn" id="searchColumn">
            <option value="name">Product Name</option>
            <option value="p_category">Category</option>
            <!-- Add more options as needed -->
        </select>
        <input type="text" name="searchValue" placeholder="Enter value">
        <input type="submit" value="Search">

        <!-- Show All button -->
        <a href="?showAll">Show All</a>
    </form>

    <!-- Product Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Image</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['product_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['p_category']}</td>
                    <td><img src='{$row['image']}' alt='Product Image'></td>
                    <td>{$row['price']}</td>
                    <td>
                        <button onclick='updateProduct({$row['product_id']})'>Update</button>
                        <button onclick='deleteProduct({$row['product_id']})'>Delete</button>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Work 5 - Update Form -->
    <div id="updateForm">
        <h3>Update Product</h3>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <input type="hidden" name="updateProductId" value="<?php echo $updateProductId; ?>">

            <label for="updateName">Product Name:</label>
            <input type="text" name="updateName" value="<?php echo $updateProductData['name']; ?>" required>

            <label for="updateCategory">Category:</label>
            <input type="text" name="updateCategory" value="<?php echo $updateProductData['p_category']; ?>" required>

            <label for="updateImage">Image:</label>
            <input type="file" name="updateImage" accept="image/png, image/jpg, image/jpeg" class="box">
            <img src="<?php echo $updateProductData['image']; ?>" alt="Current Image">

            <label for="updatePrice">Price:</label>
            <input type="number" name="updatePrice" value="<?php echo $updateProductData['price']; ?>" required>

            <input type="submit" name="submitUpdateProduct" value="Update Product">
        </form>
    </div>

    <!-- JavaScript for update and delete operations -->
    <script>
        function updateProduct(id) {
            window.location.href = "product.php?updateProductId=" + id;
        }

        function deleteProduct(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = "product.php?deleteProductId=" + id;
            }
        }
    </script>
    <a href="admin.php">Back to Main</a>
</body>

</html>
