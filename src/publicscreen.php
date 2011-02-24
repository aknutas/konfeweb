<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
/**
 * This renders the public screen view.
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
include 'controllers/publicscreencontroller.php';

$psc = new Publicscreen();
$data = $psc->load();

$lecture = $data['lecture'];
$results = $data['results'];
$authed = $data['authed'];
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="pragma" content="no-cache" />
        <title><?php echo($lecture['name']) ?> Feedback</title>
        <link rel="stylesheet" type="text/css" href="css/publicscreen.css" />
        <script type="text/javascript" src="js/jquery-1.4.2.js"></script>
        <script type="text/javascript" src="js/refresher.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                lid = <?php echo $lecture['lid']; ?>;
                authed = <?php
if ($authed) {
    echo "true";
} else {
    echo "false";
};
?>;
    });
        </script>
    </head>
    <body>
        <div id="header">
            <img src="logoimages/<?php echo $bannerfilename; ?>" class="floatylogo"/>
            <h1><?php echo $lecture['name'] ?>
                <?php
                if ($lecture['lecturer'] != null)
                    echo " by ", $lecture['lecturer'];
                echo "<br/> Send questions at ", $webaddress
                ?> </h1>
        </div>

        <div id="content">
            <div id="right">

                <h2>Presentation Feedback</h2>

                <table cellpadding="1" width="100%" id="fbTable">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="5%">Time</th>
                            <th width="90%">Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($results as $entry) {
                            $exploded = explode(" ", $entry['datetime']);
                            if ($entry['cid'] & 1)
                                $classes = "odd";
                            else
                                $classes = "even";

                            $classes = $classes . " hiliterow";

                            if ($entry['old'] == 1)
                                $classes = $classes . " old";
                            else if ($entry['old'] == 2)
                                $classes = $classes . " hidden";

                            echo "<tr id=\"", $entry['cid'], "\" class=\"", $classes, "\">";
                            if (strlen($entry['comment']) < 210) {
                                echo "<td class=\"centertext\">", $entry['cid'], "<div class=\"hidediv\"><p class=\"hidebutton2\">Del</p></div> </td>", "<td> ", $exploded[1], " </td>", "<td> ", $entry['comment'], " </td>";
                            } else {
                                $p1 = substr($entry['comment'], 0, 150);
                                $p2 = substr($entry['comment'], 150);
                                echo "<td class=\"centertext\">", $entry['cid'], "<div class=\"hidediv\"><p class=\"hidebutton2\">Del</p></div> </td>", "<td> ", $exploded[1], " </td>", "<td> ", $p1, "<span class=\"extraspan hidden\">", $p2, "</span>", "<div class=\"expdiv\"><p class=\"hidebutton2\">Expand</p></div>", " </td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div style="font-size: 0.6em;">
                <a href="http://www.it.lut.fi"><img src="logoimages/lutbanner.gif"/></a> <br/> Published under the GPL license.
            </div>
            <div id="hbdot" style="font-size: 0.5em;"></div>
        </div>
    </body>
</html>