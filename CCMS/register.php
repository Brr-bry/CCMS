<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<?php

require "conn.php";
    
    session_start();
    
    function userExists( $username){
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username= ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        return $count > 0;
    }

    
    function checkPass( $passIn, $passIn2){
        if($passIn == $passIn2){
            return true;
        }else{
            return false;
        }
    }

    

    if(isset($_POST["register"])){
        $userIn = $_POST["userIn"];
        $passIn = $_POST["passIn"];
        $passIn2 = $_POST["passIn2"];
        
        
        if(userExists($userIn)){
            $_SESSION["Error"] = "Username already exists.";
            header('Location: register.php');
            exit();
        }

        if(!checkPass($passIn, $passIn2)){
            $_SESSION["Error"] = "Incorrect Password.";
            header('Location: register.php');
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO users(username,password,role) VALUES(?,?,?)");
        $role = "member";
        $stmt->bind_param("sss",$userIn,$passIn,$role);

        if($stmt->execute()){
            $_SESSION["Success"] = "Registration Successful!";
            header('Location: index.html');
        }else{
            $_SESSION["Error"] = "Error during registration";
            header('Location: register.php');
        }
        exit();
    }

    
        if (isset($_SESSION["Error"])) {
            echo "<p style='color:red;'>".$_SESSION["Error"]."</p>";
            unset($_SESSION["Error"]); // Clear the session error message
        }

        if (isset($_SESSION["Success"])) {
            echo "<p style='color:green;'>".$_SESSION["Success"]."</p>";
            unset($_SESSION["Success"]); // Clear the success message
        }

?>
    <form method="post">
        <input type="text" name="userIn" placeholder="Username"><br><br>
        <input type="password" name="passIn" placeholder="Password"><br>
        <input type="password" name="passIn2" placeholder="Retype Password"><br><br>
        <input type="submit" value="REGISTER" name="register">
    </form>

    <?php
         
    ?>
</body>



</html>