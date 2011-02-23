<?php session_start(); ?>
<?php
/**
 * This page is responsible for loading up the basic admin view.
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
$data = $adc->load();
$auth = new Authenticator(null);
if ($auth->isAuthedAdmin() != true) {
    header('Location: login.php');
    die("Please login");
}

$conference = $data['conference'];
$lecture = $data['lecture'];
$lectures = $data['alllectures'];
$devtype = $data['devtype'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Conference Admin</title>
        <link rel="stylesheet" type="text/css" href="css/feedback.css" />
    </head>
    <body>
        <p> Current conference: <?php echo $conference['name'] ?> <br/>
            Current lecture: <?php echo $lecture['name'] ?> <br />
            Current lecturer: <?php echo $lecture['lecturer'] ?> </p>

        <p><a href="manageconfe.php"> Manage all conferences and lectures </a></p>
<?php
if ($devtype == "guruplug")
    echo '<p><a href="wirelessguruadmin.php"> Wireless Configuration </a></p>';
?>
        <p><a href="usermanag.php"> Manage users </a></p>
        <p><a href="adminindex.php"> Back to index </a></p>

        <hr align=left noshade size=10 width=25% />

        <h2>Start New Lecture</h2>
        <form action="submitlecture.php" method="post">
            <label for="lecture">Lecture name:</label> <br />
            <input type="text" name="lecture" /> <br />
            <label for="lecturer">Lecturer name:</label> <br />
            <input type="text" name="lecturer" /> <br />
            <label for="email">Lecturer email:</label> <br />
            <input type="text" name="email" />
            <br />
            <input type="submit" value="Submit" />
        </form>
        <br />

        <hr align=left noshade size=10 width=25% />

        <h2>Start New Conference</h2>
        <form action="submitconfe.php" method="post">
            <label for="lecture">Conference name:</label> <br />
            <input type="text" name="conference" /> <br />
            <label for="lecturer">Organization name:</label> <br />
            <input type="text" name="organization" /> <br />
            <br />
            <input type="submit" value="Submit" />
        </form>
        <br />

        <hr align=left noshade size=10 width=25% />

        <h2>Download feedback as PDF</h2>
<?php
foreach ($lectures as $onelecture) {
    if (isset($onelecture['lecturer']))
        $name = "by " . $onelecture['lecturer'];
    echo "<p>Lecure ID ", $onelecture['lid'], ". ", "<a href=\"genpdf.php?lid=", $onelecture['lid'], "\">", $onelecture['name'], " ", $name, "</a></p>";
}
?>
    </body>
</html>