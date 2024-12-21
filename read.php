<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice List</title>
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
    max-width: 1000px;
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

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    font-size: 16px;
}

th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #007bff;
    color: #fff;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Action links */
a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
    margin-right: 10px;
    transition: color 0.3s;
}

a:hover {
    color: #0056b3;
}

a.delete {
    color: #ff4d4d;
}

a.delete:hover {
    color: #d32f2f;
}

/* Message */
#message {
    display: none;
    background-color: #28a745;
    color: white;
    text-align: center;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
}

/* Responsive design */
@media (max-width: 768px) {
    div {
        padding: 15px;
    }

    h1 {
        font-size: 24px;
    }

    table {
        font-size: 14px;
    }

    th, td {
        padding: 8px;
    }
}

@media (max-width: 375px) {
    h1 {
        font-size: 20px;
    }

    table {
        font-size: 12px;
    }

    th, td {
        padding: 6px;
    }

    a {
        font-size: 12px;
    }
}

    </style>
</head>
<body>

    <div>
        <h1>Invoice List</h1>

        <?php
        $host = "localhost";
        $username = 'root';
        $password = '';
        $dbname = "databaza";
        $table = "projekt2";

        try {
            $dsn = "mysql:host=$host; dbname=$dbname";
            $conn = new PDO($dsn, $username, $password);
            $sql = "SELECT * FROM $table";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $rezultati = $stmt->fetchAll();

            echo "<table>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>";

            foreach ($rezultati as $x) {
                echo "<tr>
                        <td>{$x['Invoice']}</td>
                        <td>{$x['Company']}</td>
                        <td>{$x['Address']}</td>
                        <td>{$x['Phone']}</td>
                        <td>{$x['Email']}</td>
                        <td>{$x['Product']}</td>
                        <td>{$x['Quantity']}</td>
                        <td>{$x['Totalprice']}</td>
                        <td>
                            <!-- Link to edit.php passing ID as URL parameter -->
                            <a href='edit.php?ID={$x['Id']}'>Update</a>
                            <a href='delete.php?ID={$x['Id']}' class='delete'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } catch (PDOException $a) {
            echo "<p style='color: red; text-align: center;'>Error: " . $a->getMessage() . "</p>";
        }
        ?>

        <div id="message">Record deleted successfully.</div>

        <?php
        if (isset($_GET['delete'])) {
            echo "<script>
                    document.getElementById('message').style.display = 'block';
                    setTimeout(function() {
                        document.getElementById('message').style.display = 'none';
                    }, 5000);
                  </script>";
        }
        ?>
    </div>

</body>
</html>