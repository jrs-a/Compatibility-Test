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

//deleting record
if(isset($_GET['id'])){
    $delId = $_GET['id'];
    $delsql = "DELETE FROM prospects WHERE id = $delId";
    mysqli_query($mysqli, $delsql);
    header("location: prospects.php");
    exit();
}

//viewing records
$readsql = "SELECT * FROM `prospects`";
if($result = mysqli_query($mysqli, $readsql)){
    $crushie_arr = array();
    while($row = mysqli_fetch_assoc($result)) {
        $crushie_arr[] = $row;
    }
    mysqli_free_result($result);
}


if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($zodiac)){
        $zodiac = '';
    }

    //get inputs
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
    $bday = $_POST['bday'];

    //calculate zodiac
    $_REQUEST['fname'] = $fname;
    $_REQUEST['lname'] = $lname;
    $_REQUEST['bday'] = $bday;
    include("scripts/calc_logic.php");
    $zodiac = $crushieZodiac;

    //query
    if(empty($fname_err) && empty($lname_err)) {
        $sql = "INSERT INTO prospects (first_name, last_name, birthday, zodiac) VALUES (?, ?, ?, ?)";
        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssss", $param_fname, $param_lname, $param_bday, $param_zodiac);

            $param_fname = $fname;
            $param_lname = $lname;
            $param_bday = $bday;
            $param_zodiac = $zodiac;

            if($stmt->execute()){
                echo "<script>
                        alert('Crushie added successfully <3'); 
                        window.location.href='prospects.php';
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compatibility Test</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body>
    <div class="navcont">
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
        <div class="main-prospect">
            <div class="heading">
                <div class="title">Prospects</div>
                <div class="subtitle">Save your crushies' data here <3</div>
                <br>
                <button id="new-prospect" onclick="toggle()">Add new crushie + </button>
            </div>
            <form method="post">
                <div class="formCont" id="formCrushie">
                    <div class="oneRowForm">
                        <div>
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" required>
                            <div class="error_txt">
                                <?php 
                                    if(isset($fname_err)){echo $fname_err;}
                                ?>
                            </div>
                        </div>
                        <div>
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" required>
                            <div class="error_txt">
                                <?php 
                                    if(isset($lname_err)){echo $lname_err;}
                                ?>
                            </div>
                        </div>
                        <div>
                            <label for="bday">Birthday:</label>
                            <input type="date" id="bday" name="bday" required>
                        </div>          
                    </div>
                    <div class="submitCrushie">
                        <input type="submit" name="btnCrushie" id="submit">
                    </div>
                </div>
            </form>
            <div class="crushiesCont">
                <?php
                foreach ($crushie_arr as $item) {
                    echo 
                    '<div class="person">
                        <span>
                            <span class="dsp_name">
                                <span class="dsp_fname">' . $item['first_name'] . '</span>
                                <span class="dsp_lname">' .$item['last_name'] . '</span>
                            </span>
                            <span class="dsp_bday">'. $item['birthday'] . '</span>
                            <span class="dsp_zodiac">' . $item['zodiac'] . '</span>
                        </span>
                        <span>
                            <span id="edit" class="material-symbols-outlined"><a href="edit.php?id='. $item['id'].'">edit</a></span>
                            <span id="delete" class="material-symbols-outlined"><a href="prospects.php?id='. $item['id'].'">delete</a></span>
                        </span>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        function toggle() {
            var x = document.getElementById("formCrushie");
            if (x.style.display === "none") {
                x.style.display = "flex";
            } else {
                x.style.display = "none";
            }
        }
    </script>
</body>