<?php
session_start();

if(isset($_SESSION["loggedIn"])) {
    $loggedIn = $_SESSION["loggedIn"];
    $username = $_SESSION["username"];
    $userid = $_SESSION["id"];
} else {
    $loggedIn = false;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "scripts\config.php";
    
    $sql = "SELECT * FROM user WHERE email= ?";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("s", $param_email);
        $param_email = trim($_POST['email']);

        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows == 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if ($row['password'] == trim($_POST['password'])) {
                    $_SESSION["id"] = $row['id'];
                    $_SESSION["username"] = $row['username'];
                    $_SESSION["loggedIn"] = true;
                    $loggedIn = $_SESSION["loggedIn"];
                    $username = $_SESSION["username"];
                    $userid = $_SESSION["id"];
                } else {
                    echo "<script>
                        alert('Passwords do not match. Please try again.');
                        window.location.href='home.php';
                    </script>";
                    exit();
                }
            } else {
                echo "<script>
                    alert('Account does not exist');
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
    <div class="main"<?php if ($loggedIn===true){?>style="display:none"<?php } ?>>
        <div class="main-home">
            <div class="illust"><img src="https://64.media.tumblr.com/5268538135291395b71cccdd01c684ad/05ce22f10f1b09a4-0b/s400x600/c0b05e8804ac35b671ff1ac6e4cf7bc8dc5068c4.gifv"></div>
            <div class="title">Compatibility Test</div>
            <div class="subtitle">Log in to access your crushies' data and calculate your compatibility <3</div>
            <form method="post">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="btn-normal">
                    <input type="submit" value="Login">
                </div>
                <div class="btn-alt">
                    <a href="/register.php"><button type="button">Register</button></a>
                </div>
            </form>
        </div>
    </div>
    <div class="navcont" <?php if ($loggedIn===false){?>style="display:none"<?php } ?>>
        <div id="navbar">
            <div class="left">
                <div class="title">
                    Compatibility Test
                    <img src="https://64.media.tumblr.com/f5c1211e3ab41bdd2f6b2623be1b3080/7470441230a534d9-05/s75x75_c1/c13f0d2dff37d51f77d234c02e75b80750fb7d40.gifv" alt="">
                </div>
            </div>
            <div class="right">
                <div><a href="home.php">Home</a></div>
                <div><a href="prospects.php">Prospects</a></div>
                <div><a href="calculator.php">Calculator</a></div>
                <div><a href="scripts/logout.php" id="out">Logout</a></div>
            </div>
        </div>
        <div class="contentarea">
            <h1>Welcome <?php echo $username . ' !' ?></h1>
            <img src="https://64.media.tumblr.com/7d25fd3c0a6375958b8d7705d38f5506/d1b8bc3b8b7aac75-73/s250x400/8fa301ec17a7204838a89bd82149a1835f53100f.gifv" alt="gif">
        </div>
    </div>
</body>