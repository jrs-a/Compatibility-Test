<?php

class Person
{
    private $fName;
    private $lName;
    private $birthday;
    public $zodiac;

    function __construct($fName, $lName, $bday)
    {
        $this->fName = $fName;
        $this->lName = $lName;
        $this->birthday = $bday;
        $this->zodiac = new Zodiac($bday);
    }

    function GetFullName()
    {
        $fullName = $this->lName . ', ' . $this->fName;
        return $fullName;
    }
}
class Zodiac
{
    public $zodiacSign;
    private $zodiacSymbol;
    private $startDate;
    private $endDate;

    function __construct($birthday)
    {
        $zodiacInfo = $this->getZodiacInfo($birthday);

        if ($zodiacInfo != null) {
            $this->zodiacSign = $zodiacInfo['sign'];
            $this->zodiacSymbol = $zodiacInfo['symbol'];
            $this->startDate =  $zodiacInfo['start_date'];
            $this->endDate = $zodiacInfo['end_date'];
        } else {
            echo "Invalid date.";
        }
    }
    function ComputeZodiacCompatibility($zodiac1, $zodiac2)
    {
        // G = great match
        // F - favorable match
        // N = not favorable
        $zodiacCompatChart = array(
            'aries' => array(
                'aries' => 'G',
                'leo' => 'G',
                'sagittarius' => 'G',
                'taurus' => 'N',
                'virgo' => 'N',
                'capricornus' => 'N',
                'gemini' => 'G',
                'libra' => 'G',
                'aquarius' => 'G',
                'cancer' => 'N',
                'scorpio' => 'N',
                'pisces' => 'F'
            ),
            'leo' => array(
                'aries' => 'G',
                'leo' => 'G',
                'sagittarius' => 'G',
                'taurus' => 'N',
                'virgo' => 'N',
                'capricornus' => 'N',
                'gemini' => 'G',
                'libra' => 'G',
                'aquarius' => 'G',
                'cancer' => 'F',
                'scorpio' => 'F',
                'pisces' => 'F'
            ),
            'sagittarius' => array(
                'aries' => 'G',
                'leo' => 'G',
                'sagittarius' => 'G',
                'taurus' => 'N',
                'virgo' => 'N',
                'capricornus' => 'N',
                'gemini' => 'G',
                'libra' => 'G',
                'aquarius' => 'G',
                'cancer' => 'F',
                'scorpio' => 'F',
                'pisces' => 'F'
            ),
            'taurus' => array(
                'aries' => 'N',
                'leo' => 'F',
                'sagittarius' => 'N',
                'taurus' => 'G',
                'virgo' => 'G',
                'capricornus' => 'G',
                'gemini' => 'N',
                'libra' => 'F',
                'aquarius' => 'N',
                'cancer' => 'G',
                'scorpio' => 'G',
                'pisces' => 'G'
            ),
            'virgo' => array(
                'aries' => 'N',
                'leo' => 'F',
                'sagittarius' => 'N',
                'taurus' => 'G',
                'virgo' => 'G',
                'capricornus' => 'G',
                'gemini' => 'N',
                'libra' => 'N',
                'aquarius' => 'F',
                'cancer' => 'G',
                'scorpio' => 'G',
                'pisces' => 'F'
            ),
            'capricornus' => array(
                'aries' => 'N',
                'leo' => 'F',
                'sagittarius' => 'N',
                'taurus' => 'G',
                'virgo' => 'G',
                'capricornus' => 'G',
                'gemini' => 'N',
                'libra' => 'F',
                'aquarius' => 'N',
                'cancer' => 'G',
                'scorpio' => 'G',
                'pisces' => 'G'
            ),
            'gemini' => array(
                'aries' => 'G',
                'leo' => 'G',
                'sagittarius' => 'F',
                'taurus' => 'N',
                'virgo' => 'F',
                'capricornus' => 'F',
                'gemini' => 'G',
                'libra' => 'G',
                'aquarius' => 'G',
                'cancer' => 'N',
                'scorpio' => 'N',
                'pisces' => 'N'
            ),
            'libra' => array(
                'aries' => 'F',
                'leo' => 'G',
                'sagittarius' => 'G',
                'taurus' => 'F',
                'virgo' => 'N',
                'capricornus' => 'N',
                'gemini' => 'G',
                'libra' => 'G',
                'aquarius' => 'G',
                'cancer' => 'N',
                'scorpio' => 'N',
                'pisces' => 'F'
            ),
            'aquarius' => array(
                'aries' => 'G',
                'leo' => 'G',
                'sagittarius' => 'G',
                'taurus' => 'N',
                'virgo' => 'N',
                'capricornus' => 'N',
                'gemini' => 'G',
                'libra' => 'G',
                'aquarius' => 'G',
                'cancer' => 'N',
                'scorpio' => 'F',
                'pisces' => 'F'
            ),
            'cancer' => array(
                'aries' => 'N',
                'leo' => 'F',
                'sagittarius' => 'F',
                'taurus' => 'G',
                'virgo' => 'G',
                'capricornus' => 'G',
                'gemini' => 'N',
                'libra' => 'N',
                'aquarius' => 'N',
                'cancer' => 'G',
                'scorpio' => 'G',
                'pisces' => 'G'
            ),
            'scorpio' => array(
                'aries' => 'F',
                'leo' => 'F',
                'sagittarius' => 'N',
                'taurus' => 'G',
                'virgo' => 'G',
                'capricornus' => 'G',
                'gemini' => 'N',
                'libra' => 'N',
                'aquarius' => 'N',
                'cancer' => 'G',
                'scorpio' => 'G',
                'pisces' => 'G'
            ),
            'pisces' => array(
                'aries' => 'F',
                'leo' => 'F',
                'sagittarius' => 'F',
                'taurus' => 'G',
                'virgo' => 'F',
                'capricornus' => 'G',
                'gemini' => 'N',
                'libra' => 'N',
                'aquarius' => 'N',
                'cancer' => 'G',
                'scorpio' => 'G',
                'pisces' => 'G'
            )
        );

        $flamesValue = array(
            'N' => "Not Favorable",
            'F' => "Favorable Match",
            'G' => "Great Match"
        );

        $zodiac1 = strtolower($zodiac1);
        $zodiac2 = strtolower($zodiac2);

        return $flamesValue[$zodiacCompatChart[$zodiac1][$zodiac2]];
    }
    private function stringToMonth($date)
    {
        $parts = explode(" ", $date);
        $day = $parts[1];
        $month = $parts[0];

        $months = array(
            "january" => 1,
            "february" => 2,
            "march" => 3,
            "april" => 4,
            "may" => 5,
            "june" => 6,
            "july" => 7,
            "august" => 8,
            "september" => 9,
            "october" => 10,
            "november" => 11,
            "december" => 12
        );

        $month = strtolower($month);
        $wow = $months[$month];
        // $newDate =  $wow . "-" . $day;
        $newDate =  $wow . $day;

        return isset($months[$month]) ? $newDate : 0;
    }
    private function getZodiacInfo($date)
    {
        $file = fopen("scripts/Zodiac.txt", "r");
        $expDate = explode("-", $date);
        $expM = intval($expDate[1]);
        // $expM = str_pad($expM, 2, '0', STR_PAD_LEFT);

        $expD = intval($expDate[2]);
        $expD = str_pad($expD, 2, '0', STR_PAD_LEFT);

        // $numDate = $expM . "-" . $expD;
        $numDate = $expM . $expD;
        
        if($numDate < 120 || $numDate >= 1222) {
            return array("sign" => "Capricornus", "symbol" => "Goat", "start_date" => "December 22", "end_date" => "January 19");
            
        } else {
            while (!feof($file)) {
                $line = fgets($file);
                $info = explode(";", $line);
                $sign = $info[0];
                $symbol = $info[1];
                $start_date = $info[2];
                $end_date = $info[3];

                // convert dates to their numerical versions
                $numSDate = $this->stringToMonth($start_date);
                $numEDate = $this->stringToMonth($end_date);

                if ($numDate >= $numSDate && $numDate <= $numEDate) {
                    fclose($file);
                    return array("sign" => $sign, "symbol" => $symbol, "start_date" => $numSDate, "end_date" => $numEDate);
                }
            }
        }
        fclose($file);
        return null;
    }
}
if (isset($_POST['btnCrushie'])) {
    $fName = $_REQUEST['fname'];
    $lName = $_REQUEST['lname'];
    $bday = $_REQUEST['bday'];
    $crushie = new Person($fName, $lName, $bday);
    $crushieZodiac = $crushie->zodiac->zodiacSign;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['reset'])) {
        $shown = false;
    }
  }

if (isset($_POST['btnSubmit'])) {
    if (empty($_POST['lname1']) || empty($_POST['fname1']) || empty($_POST['birthday1']) || empty($_POST['lname2']) || empty($_POST['fname2']) || empty($_POST['birthday2'])) {
        $formerr = 'please fill all fields';
    } else {
        $shown = true;

        $lname1 = $_POST['lname1'];
        $fname1 = $_POST['fname1'];
        $bday1 = $_POST['birthday1'];
        $person1 = new Person($fname1, $lname1, $bday1);

        $lname2 = $_POST['lname2'];
        $fname2 = $_POST['fname2'];
        $bday2 = $_POST['birthday2'];
        $person2 = new Person($fname2, $lname2, $bday2);

        $name1 = $fname1 . $lname1;
        $name2 = $fname2 . $lname2;
        $valFlames = computeFLAMES($name1, $name2);
        $zodiac1 = $person1->zodiac->zodiacSign;
        $zodiac2 = $person2->zodiac->zodiacSign;

        $dispName1 = $person1->GetFullName();
        $dispName2 = $person2->GetFullName();

        $zodiacCompat = $person1->zodiac->ComputeZodiacCompatibility($zodiac1, $zodiac2);

        // echo $dispName1;
        // echo $zodiac1;
        // echo $dispName2;
        // echo $zodiac2;
        // echo $valFlames;
        // echo $zodiacCompat;
    }
}
function computeFLAMES($string1, $string2)
{
    $string1 = strtolower($string1);
    $string2 = strtolower($string2);

    $chars1 = str_split($string1);
    $chars2 = str_split($string2);

    $commonChars = array_intersect($chars1, $chars2); // Find the common characters between the two arrays
    $uniqueChars = array_unique($commonChars); // Remove any duplicate characters from the common characters array
    $search = implode('', $uniqueChars);

    $combinedString = $string1 . $string2;
    $counts = array();

    for ($i = 0; $i < strlen($search); $i++) {
        $char = $search[$i];
        $count = substr_count($combinedString, $char); // Count the number of times the character appears in the string
        $counts[$char] = $count;
    }
    $total = array_sum($counts);

    $flamesValue = array(
        0 => "Soulmates",
        1 => "Friends",
        2 => "Lovers",
        3 => "Anger",
        4 => "Married",
        5 => "Engaged"
    );

    return $flamesValue[$total % 6];
}
