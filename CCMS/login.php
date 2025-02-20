<?php

    require "conn.php";

    $userIn = $_POST["userIn"];
    $passIn = $_POST["passIn"];

    $stmt = $conn->prepare("SELECT * FROM users where username = ?");
    $stmt->bind_param("s", $userIn);
    
    if($stmt->execute()){
        $result = $stmt->get_result();

        if($result->num_rows>0){
            $row = $result->fetch_assoc();

            if($passIn == $row["password"]){
                session_start();
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];


                if($row['role'] == "admin"){
                    header('Location: ./admin/dashboard.php');
                    exit();
                }

                if($row['role'] == "member"){
                    header('Location: ./member/home.php');
                    exit();

                }

                if($row['role'] == "VIP"){
                    header('Location: ./member/home.php');
                    exit();

                }
            }
            
        }
        else{
            header('Location: index.html');
            exit();
        }
    }else{
        header('Location: index.html');
        exit();
    }

?>