<?php
session_start();

if(isset($_SESSION["loggedIn"])) {
    $loggedIn = $_SESSION["loggedIn"];
    $username = $_SESSION["username"];
    $userid = $_SESSION["id"];
} else {
    $loggedIn = false;
}
if (!isset($shown)) {
    $shown = false;
}

require_once "scripts\config.php"; 
include("scripts/calc_logic.php");

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
    </div>
    <div class="main-calc">
        <div class="lvl1">
            <form method="POST">
                <div class="lvl2">
                    <div class="form">
                        <div>
                            <div class="subtitle">Your info</div>
                            <div class="nameCont">
                                <div>
                                    <label for="fname1">First Name</label>
                                    <input type="text" name="fname1" id="fname1">
                                </div>
                                <div>
                                    <label for="lname1">Last Name</label>
                                    <input type="text" name="lname1" id="lname1">
                                </div>
                            </div>
                            <div>
                                <label for="birthday1">Birthday</label>
                                <input type="date" name="birthday1" id="birthday1">
                            </div>
                            
                        </div>
                        <div>
                            <div class="subtitle">Crush's info</div>
                            <div class="nameCont">
                                <div>
                                    <label for="fname2">First Name</label>
                                    <input type="text" name="fname2" id="fname2">
                                </div>
                                <div>
                                    <label for="lname2">Last Name</label>
                                    <input type="text" name="lname2" id="lname2">
                                </div>
                            </div>
                            <div>
                                <label for="birthday2">Birthday</label>
                                <input type="date" name="birthday2" id="birthday2">
                            </div>
                            
                        </div>
                    </div>
                    <div class="btn">
                        <input type="submit" name="btnSubmit" id="submitcalc" value="See compatibility results">
                        <button type="submit" name="reset" id="resetcalc">Try again</button>
                    </div>
                    <div class="error_txt" style="text-align:center">
                        <?php 
                            if(isset($formerr)){
                                echo $formerr;
                            }
                        ?>
                    </div>
                </div>
            </form>
            <div id="profiles"<?php if ($shown===false){?>style="display:none"<?php } ?>>
                <div class="resultperson" id="left">
                    <div class="personName">
                        <?php
                        if(isset($dispName1)){
                            echo $dispName1;
                        }
                        ?>
                    </div>
                    <div class="personZodiac">
                        <?php
                        if(isset($zodiac1)){
                            echo $zodiac1;
                        }
                        ?>
                    </div>
                </div>
                <div class="compatResults">
                    <div class="resultsFlames">
                        <?php
                        if(isset($valFlames)){
                            echo $valFlames;
                        }
                        ?>
                    </div>
                    <div class="resultsZodiac">
                        <?php
                        if(isset($zodiacCompat)){
                            echo $zodiacCompat;
                        }
                        ?>
                    </div>
                </div>
                <div class="resultperson" id="right">
                    <div class="personName">
                        <?php
                        if(isset($dispName2)){
                            echo $dispName2;
                        }
                        ?>
                    </div>
                    <div class="personZodiac">
                        <?php
                        if(isset($zodiac2)){
                            echo $zodiac2;
                        }
                        ?>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</body>
</html>