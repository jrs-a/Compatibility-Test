<?php
session_start();

if(isset($_SESSION["loggedIn"])) {
    $loggedIn = $_SESSION["loggedIn"];
    $username = $_SESSION["username"];
    $userid = $_SESSION["id"];
} else {
    $loggedIn = false;
}

require_once "scripts\config.php";

if(isset($_POST['btnRegister'])) {
    //password validation
    $pass = trim($_POST['password']);
    $pass2 = trim($_POST['passwordcheck']);
    
    //check if email already exists
    $sql = "SELECT * FROM user WHERE email= ?";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("s", $param_email);
        $param_email = trim($_POST['email']);
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                echo "<script>
                    alert('Email is already in use.');
                    window.location.href='home.php';
                </script>";
                exit();
            }
        } else {
            echo "<script>
                alert('Something went wrong please try again later...');
            </script>";
        }
    }
    $stmt->close();


    if($pass != $pass2){
        $error_txt = 'passwords does not match please try again';
    } else {
        // store the variables from post, no need to check for empty edge has built in function for that
        $inp_fname = trim($_POST['first_name']);
        if(!filter_var($inp_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
            $fname_err = "Enter a valid first name.";
        } else {
            $fname = $inp_fname;
        }
        $inp_lname = trim($_POST['last_name']);
        if(!filter_var($inp_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
            $lname_err = "Enter a valid last name.";
        } else {
            $lname = $inp_lname;
        }
        $city = trim($_POST['city']);
        $province = trim($_POST['province']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if(empty($error_txt) && empty($fname_err) && empty($lname_err)) {
            $sql = "INSERT INTO user (first_name, last_name, city, province, username, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("sssssss", $param_fname, $param_lname, $param_city, $param_province, $param_username, $param_email, $param_password);
                
                $param_fname = $fname;
                $param_lname = $lname;
                $param_city = $city;
                $param_province = $province;
                $param_username = $username;
                $param_email = $email;
                $param_password = $password;
                
                if($stmt->execute()){
                    echo "<script>
                            alert('Account created successfully'); 
                            window.location.href='home.php';
                        </script>";
                    exit();
                } else {
                    echo "<script>
                            alert('Something went wrong please try again later...');
                        </script>";
                }
            }
            $stmt->close();
        }        
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compatibility Test</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="main">
        <div class="main-home">
            <div class="illust"><img src="https://64.media.tumblr.com/5268538135291395b71cccdd01c684ad/05ce22f10f1b09a4-0b/s400x600/c0b05e8804ac35b671ff1ac6e4cf7bc8dc5068c4.gifv"></div>
            <div class="title">Compatibility Test</div>
            <div class="subtitle">Create an account to save your crushies' data!</div>
            <br>
            <form method="post">
                <div class="nameCont">
                    <div>
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" required>
                        <div class="error_txt">
                            <?php 
                                if(isset($fname_err)){
                                    echo $fname_err;
                                }
                            ?>
                        </div>
                    </div>
                    <div>
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" required>
                        <div class="error_txt">
                        <?php 
                            if(isset($lname_err)){
                                echo $lname_err;
                            }
                        ?>
                        </div>
                    </div>                    
                </div>
                <div class="nameCont">
                    <div>
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" required>
                    </div>
                    <div>
                        <label for="province">Province:</label>
                        <input type="text" id="province" name="province" required>
                    </div>
                </div>
                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="passwordcheck">Confirm Password:</label>
                    <input type="password" id="passwordcheck" name="passwordcheck" required>
                    <div class="error_txt">
                        <?php 
                            if(isset($error_txt)){
                                echo $error_txt;
                            }
                        ?>
                    </div>
                </div>
                <div class="btn-alt">
                    <input type="submit" value="Register" name="btnRegister">
                </div>
            </form>
        </div>
    </div>
</body>