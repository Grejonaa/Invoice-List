<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>
<body>


    <?php
    $host = "localhost";
    $username = 'root';
    $password = '';
    $dbname = "databaza";
    $table = "projekt2";

    if(isset($_GET['ID'])){
        $id = $_GET['ID'];

        try{
            $dsn = "mysql:host=$host; dbname=$dbname";
            $conn=new PDO ($dsn, $username , $password);

            $sql="DELETE FROM $table WHERE Id=:id";
            $stmt=$conn->prepare($sql);
            $stmt->execute([':id'=> $id]);
            header("Location: read.php?delete");
            exit;
        }
        catch(PDOException $a){
            echo "Error: " . $a->getMessage();
        }
    }

    ?>
</body>
</html>