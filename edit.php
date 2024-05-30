<?php
session_start();

if(isset($_SESSION["loggedIn"])) {
    $loggedIn = $_SESSION["loggedIn"];
    $username = $_SESSION["username"];
    $userid = $_SESSION["id"];
} else {
    $loggedIn = false;
}

//display info
require_once "scripts\config.php"; 
$delId = $_GET['id'];
$editsql = "SELECT * FROM prospects WHERE id = '$delId'";

if($result = mysqli_query($mysqli, $editsql)){
    $row = mysqli_fetch_assoc($result);
    $fName = $row['first_name'];
    $lName = $row['last_name'];
    $dispbday = $row['birthday'];
} else {
    echo "<script>
        alert('Record not found. Please try again.');
        window.location.href='prospects.php';
    </script>";
    exit();
}

//update info
if($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if(empty($fname_err) && empty($lname_err)) {
        $sqlupdate = "UPDATE prospects SET first_name=?,last_name=?,birthday=?,zodiac=? WHERE id=?";
        if($stmt = $mysqli->prepare($sqlupdate)) {
            $stmt->bind_param("ssssi", $param_fname, $param_lname, $param_bday, $param_zodiac, $param_id);

            $param_fname = $fname;
            $param_lname = $lname;
            $param_bday = $bday;
            $param_zodiac = $zodiac;
            $param_id = $delId;

            if($stmt->execute()){
                echo "<script>
                        alert('Crushie info update successfully <3'); 
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
    <div class="main_edit">
        <form method="post">
            <div class="cont_edit">
                <div class="txt_heading">Edit crushie info</div>
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" value="<?php echo $fName; ?>">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $lName; ?>">
                <label for="birthday">Birthday:</label>
                <?php echo '<input type="date" name="bday" value="' . $dispbday . '" />';?>
                <input type="submit" name="btnCrushie"  value="Update" id="update">
                <a id="back" href="prospects.php">Go back</a>
            </div>    
        </form>
    </div>
</body>

</html>