<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
/**
 * This page lists all feedback in the conference session to a mobile client.
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
include 'controllers/feedbackcontroller.php';
$fbc = new Feedback();
$data = $fbc->loadAll();

$lecture = $data['lecture'];
$results = $data['results'];
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Conference Feedback</title>
        <link rel="stylesheet" type="text/css" href="css/feedback.css" />
    </head>
    <body>
        <p> Current lecture: <?php echo $lecture['name'] ?> <br />
            Current lecturer: <?php echo $lecture['lecturer'] ?> </p>

        <h2>Enter New Feedback</h2>

        <form action="submitfeedback.php" method="post">
            <label for="Feedback">Comments or Questions:</label> <br />
            <textarea name="feedback" cols=40 rows=8></textarea>
            <br />
            <label for="ref">Reference (eg. page or slide number)</label> <br />
            <textarea name="ref" cols=20 rows=1></textarea>
            <br />
            <input type="submit" value="Submit" />
        </form>
        <br />

        <h2>Previous feedback</h2>
        <a href="feedback.php">Minimize</a>
        <table border="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Time</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <?php
            foreach ($results as $entry) {
                $exploded = explode(" ", $entry['datetime']);
                if ($entry['old'] == 0)
                    echo ("<tr>");
                else
                    echo ("<tr class=\"old\">");
                echo "<td> ", $entry['cid'], " </td>", "<td> ", $exploded[1], " </td>", "<td> ", $entry['comment'], " </td>";
                echo ("</tr>");
            }
            ?>
        </table>
    </body>
</html>