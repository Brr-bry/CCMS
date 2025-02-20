<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    if(!(isset($_SESSION["role"]) && $_SESSION["role"]=="admin")){
        header('Location: ../index.html');
        exit();
    }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>HI ADMIN</h1>
    <a href="../logout.php">logout</a>
</body>
</html>