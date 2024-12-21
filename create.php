<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
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
    background: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

input[type="submit"]:hover {
    background: #0056b3;
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
        <h1>Create Invoice</h1>
        <form action="create.php" method="post">
            <label for="invoicenumber">Invoice Number</label>
            <input type="number" name="invoicenumber" id="invoicenumber" placeholder="Enter the invoice number" required>

            <label for="companyname">Company Name</label>
            <input type="text" name="companyname" id="companyname" placeholder="Enter company name" required>

            <label for="address">Company Address</label>
            <input type="text" name="address" id="address" placeholder="Enter your address of the company" required>

            <label for="phone">Phone Number</label>
            <input type="number" name="phone" id="phone" placeholder="Enter your phone number" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>

            <label for="product">Product Name</label>
            <input type="text" name="product" id="product" placeholder="Enter the name of purchased product" required>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" placeholder="Enter the number of quantity" required>

            <label for="price">Total Price</label>
            <input type="text" name="price" id="price" placeholder="Enter the total price" required>

            <input type="submit" name="create" value="Create Invoice">
        </form>
    </div>

    <?php
    $host = "localhost";
    $username = 'root';
    $password = '';
    $dbname = "databaza";
    $table = "projekt2";

    if (isset($_POST['create'])) {
        $invoicenumber = $_POST['invoicenumber'];
        $companyname = $_POST['companyname'];
        $address = $_POST['address'];
        $phonenumber = $_POST['phone'];
        $email = $_POST['email'];
        $product = $_POST['product'];  
        $quantity = $_POST['quantity'];
        $totalprice = $_POST['price'];

        if (empty($invoicenumber) || empty($companyname) || empty($address) || empty($phonenumber) || empty($email) || empty($product) || empty($quantity) || empty($totalprice)) {
            die("Please fill all fields");
        }

        try {
            $dsn = "mysql:host=$host; dbname=$dbname";
            $conn = new PDO($dsn, $username, $password);
            $sql = "INSERT INTO $table(Invoice, Company, Address, Phone, Email, Product, Quantity, Totalprice) 
                    VALUES (:invoicenr, :companyname, :address, :phone, :email, :product, :quantity, :totalprice)";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':invoicenr' => $invoicenumber, 
                ':companyname' => $companyname, 
                ':address' => $address, 
                ':phone' => $phonenumber, 
                ':email' => $email, 
                ':product' => $product,  
                ':quantity' => $quantity, 
                ':totalprice' => $totalprice 
            ]);

            echo "<p style='color: green; text-align: center;'>Data inserted successfully</p>";
        } catch (PDOException $e) {
            echo "<p style='color: red; text-align: center;'>Error: " . $e->getMessage() . "</p>";
        }
    }
    ?>

</body>
</html>