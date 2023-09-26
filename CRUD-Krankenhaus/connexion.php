<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
   
    try {
        $connexion = new PDO (
            "mysql:host=localhost;dbname=dbrdv", 'root', '130265ABCDe@'
        );
    } catch (PDOException $e) {
        echo 'you have an error in' . $e -> getMessage();
    }
    ?>
</body>
</html>