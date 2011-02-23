<?php session_start(); ?>
<?php
/**
 * This page allows an administrator to manage conferences.
 *
 * LICENSE:
 * This file is part of konfeweb.
 * Konfeweb is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Konfeweb is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Konfeweb.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright  2010 Lappeenranta University of Technology
 * @author  Antti Knutas <firstname.lastname@lut.fi>
 * @license  http://www.gnu.org/licenses/gpl.txt GNU GPLv3
 */
include 'controllers/admincontroller.php';
$adc = new Admin();
$auth = new Authenticator(null);
if (!$auth->isAuthedAdmin()) {
    header('Location: login.php');
    die("Please login");
}

if (isset($_GET["exkid"])) {
    if ($_GET["exkid"] != null || $_GET["exkid"] != "") {
        $kid = $_GET["exkid"];
        $kid = filter_var($kid, FILTER_VALIDATE_INT);
        $_SESSION['exkid'] = $kid;
        $data = $adc->loadSpecificConfe($kid);
    }
} else {
    if (isset($_SESSION['exkid'])) {
        $kid = $_SESSION['exkid'];
        $data = $adc->loadSpecificConfe($kid);
    } else {
        $kid = null;
        $data = $adc->loadSpecificConfe($kid);
    }
}

$conference = $data['nowconference'];
$lecture = $data['nowlecture'];
$nowlectures = $data['nowlectures'];
$lectures = $data['alllectures'];
$conferences = $data['allconferences'];
$expandcurrent = $data['currentconference'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Conference Admin</title>
        <link rel="stylesheet" type="text/css" href="css/manageconfe.css" />
    </head>
    <body>

        <p><a href="admin.php"> Back </a></p>

        <p> Current conference: <?php echo $conference['name'] ?> <br/>
            Current lecture: <?php echo $lecture['name'] ?> <br />
            Current lecturer: <?php echo $lecture['lecturer'] ?> </p>

        <hr align=left noshade size=10 width=25% />

        <div>
            <h2>Manage Conferences and Lectures</h2>
            <ul class=\"menu\">
<?php
echo "<hr/>";
foreach ($conferences as $oneconference) {
    if ($kid == $oneconference['kid']) {
        $expandbutton = "<form name=\"expand\" action=\"manageconfe.php\" method=\"get\"  class=\"floatybutton\">
                                    <input type=\"hidden\" name=\"exkid\" value=\"" . $oneconference['kid'] . "\" />
                                    <input type=\"submit\" value=\"Expanded\" />
                                    </form>";
    } else {
        $expandbutton = "<form name=\"expand\" action=\"manageconfe.php\" method=\"get\"  class=\"floatybutton\">
                                    <input type=\"hidden\" name=\"exkid\" value=\"" . $oneconference['kid'] . "\" />
                                    <input type=\"submit\" value=\"Expand\" />
                                    </form>";
    }
    $switchbutton = "<form name=\"switch\" action=\"switchconfe.php\" method=\"get\" class=\"floatybutton\">
                                    <input type=\"hidden\" name=\"kid\" value=\"" . $oneconference['kid'] . "\" />
                                    <input type=\"submit\" value=\"Switch\" />
                                    </form>";
    $deletebutton = "<form name=\"delete\" action=\"deleteconfe.php\" method=\"get\" class=\"floatybutton\">
                                    <input type=\"hidden\" name=\"kid\" value=\"" . $oneconference['kid'] . "\" />
                                    <input type=\"submit\" value=\"Delete\" />
                                    </form>";
    if ($conference['kid'] == $oneconference['kid'])
        echo "<b>";
    echo "<li>Conference ", $oneconference['kid'], ". ", $oneconference['name'], " by ", $oneconference['organization'], "</li>", $expandbutton, $switchbutton, $deletebutton;
    if ($conference['kid'] == $oneconference['kid'])
        echo "</b>";
    echo "<ul class=\"menu\">";
    if ($oneconference['kid'] == $expandcurrent || $oneconference['kid'] == $kid) {
        if ($oneconference['kid'] == $expandcurrent)
            $itelectures = $nowlectures;
        else if ($oneconference['kid'] == $kid)
            $itelectures = $lectures;
        else
            $itelectures = null;
        foreach ($itelectures as $onelecture) {
            $name = $onelecture['name'];
            $switchbutton = "<form name=\"switch\" action=\"switchlecture.php\" method=\"get\" class=\"floatybutton\">
                                        <input type=\"hidden\" name=\"lid\" value=\"" . $onelecture['lid'] . "\" />
                                        <input type=\"submit\" value=\"Switch\" />
                                        </form>";
            $feedbackbutton = "<form name=\"genpdf\" action=\"genpdf.php\" method=\"get\" class=\"floatybutton\">
                                        <input type=\"hidden\" name=\"lid\" value=\"" . $onelecture['lid'] . "\" />
                                        <input type=\"submit\" value=\"Generate PDF\" />
                                        </form>";
            if (isset($onelecture['lecturer']))
                $name = $name . " by " . $onelecture['lecturer'];
            if ($lecture['lid'] == $onelecture['lid'])
                echo "<b>";
            echo "<li>Lecure ", $onelecture['lid'], ". ", $name, "</li>", $switchbutton, $feedbackbutton;
            if ($lecture['lid'] == $onelecture['lid'])
                echo "</b>";
        }
    }
    echo "</ul>";
    echo "<hr/>";
}
?>
            </ul>
        </div>

        <hr align=left noshade size=10 width=25% />

        <h2>Add a New Conference</h2>
        <form action="submitconfe.php" method="post">
            <label for="conference">Conference name:</label> <br />
            <input type="text" name="conference" /> <br />
            <label for="organization">Organization name:</label> <br />
            <input type="text" name="organization" /> <br />
            <input type="hidden" name="future" value="yes" />
            <br />
            <input type="submit" value="Submit" />
        </form>
        <br />

        <hr align=left noshade size=10 width=25% />

        <h2>Add Upcoming Lectures</h2>
        <form action="submitlecture.php" method="post">
            <label for="lecture">Lecture name:</label> <br />
            <input type="text" name="lecture" /> <br />
            <label for="lecturer">Lecturer name:</label> <br />
            <input type="text" name="lecturer" /> <br />
            <label for="email">Lecturer email:</label> <br />
            <input type="text" name="email" />
            <input type="hidden" name="future" value="yes" />
            <br />
            <input type="submit" value="Submit" />
        </form>
        <br />

    </body>
</html>