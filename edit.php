<?php
// Database connection settings
$host = "localhost";
$username = 'root';
$password = '';
$dbname = "databaza";
$table = "projekt2";

// Check if an ID is provided in the URL (for editing the specific record)
if (isset($_GET['ID']) && !empty($_GET['ID'])) {
    // Get the ID from the URL
    $id = $_GET['ID'];

    try {
        // Create PDO connection
        $dsn = "mysql:host=$host;dbname=$dbname";
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the record to be edited
        $sql = "SELECT * FROM $table WHERE ID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $rez = $stmt->fetch();

        if (!$rez) {
            echo "Error: Record not found for the given ID.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }

    // If the form is submitted (POST request)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if all fields are available in the form submission
        if (isset($_POST['invoicenumber'], $_POST['companyname'], $_POST['address'], $_POST['phone'], $_POST['email'], $_POST['product'], $_POST['quantity'], $_POST['price'])) {
            // Get the form data
            $invoicenumber = $_POST['invoicenumber'];
            $companyname = $_POST['companyname'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $product = $_POST['product'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];

            try {
                // Update the record in the database
                $sql = "UPDATE $table SET
                        Invoice = :invoicenumber,
                        Company = :companyname,
                        Address = :address,
                        Phone = :phone,
                        Email = :email,
                        Product = :product,
                        Quantity = :quantity,
                        Totalprice = :price
                        WHERE ID = :id";

                // Prepare and execute the update statement
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':invoicenumber' => $invoicenumber,
                    ':companyname' => $companyname,
                    ':address' => $address,
                    ':phone' => $phone,
                    ':email' => $email,
                    ':product' => $product,
                    ':quantity' => $quantity,
                    ':price' => $price,
                    ':id' => $id
                ]);

                // Check if rows were updated
                if ($stmt->rowCount() > 0) {
                    echo "<h3 id='message'>Record updated successfully!</h3>";
                } else {
                    echo "No changes made. The data might be the same as the existing record.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Error: Missing form data.";
        }
    }
} else {
    echo "Error: No ID provided for the record.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Invoice</title>
    <style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
}

div {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

/* Heading */
h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #444;
}

/* Form styling */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
input[type="email"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    width: 100%;
    box-sizing: border-box;
}

input[type="submit"] {
    background: #28a745;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

input[type="submit"]:hover {
    background: #218838;
}

/* Message styling */
#message {
    text-align: center;
    color: #28a745;
    font-weight: bold;
    margin-top: 20px;
}

/* Responsive design */
@media (max-width: 768px) {
    div {
        padding: 15px;
    }

    h1 {
        font-size: 24px;
    }

    input[type="text"],
    input[type="number"],
    input[type="email"] {
        font-size: 14px;
    }

    input[type="submit"] {
        font-size: 14px;
    }
}

@media (max-width: 375px) {
    h1 {
        font-size: 20px;
    }

    input[type="text"],
    input[type="number"],
    input[type="email"] {
        font-size: 12px;
    }

    input[type="submit"] {
        font-size: 12px;
    }
}

    </style>
</head>
<body>
    <div>
        <h1>Edit Invoice</h1>
        <form action="edit.php?ID=<?php echo $rez['Id']; ?>" method="post">
            <label for="invoicenumber">Invoice Number</label>
            <input type="number" name="invoicenumber" id="invoicenumber" value="<?php echo htmlspecialchars($rez['Invoice']); ?>" required>

            <label for="companyname">Company Name</label>
            <input type="text" name="companyname" id="companyname" value="<?php echo htmlspecialchars($rez['Company']); ?>" required>

            <label for="address">Company Address</label>
            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($rez['Address']); ?>" required>

            <label for="phone">Phone Number</label>
            <input type="number" name="phone" id="phone" value="<?php echo htmlspecialchars($rez['Phone']); ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($rez['Email']); ?>" required>

            <label for="product">Product Name</label>
            <input type="text" name="product" id="product" value="<?php echo htmlspecialchars($rez['Product']); ?>" required>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($rez['Quantity']); ?>" required>

            <label for="price">Total Price</label>
            <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($rez['Totalprice']); ?>" required>

            <input type="submit" value="Update Invoice">
        </form>
    </div>
</body>
</html>

