<?php session_start(); ?>
<?php
/**
 * Renders the Guruplug-specific wireless configuration view.
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
$auth = new Authenticator(null);
if ($auth->isAuthedAdmin() != true) {
    header('Location: login.php');
    die("Please login");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Conference Admin</title>
        <link rel="stylesheet" type="text/css" href="css/feedback.css" />
    </head>
    <body>

        <p><a href="admin.php"> Back to admin </a></p>

        <hr align=left noshade size=10 width=25% />

        <h2>Change Wireless Settings</h2>

        <b>Change SSID</b>
        <form action="wirelessguruconfig.php" method="post">
            <input type="hidden" name="action" value="ssid" />
            <input type="text" name="ssid" />
            <input type="submit" value="Change" />
        </form>

        <br/>
        <br/>

        <b>Change wireless channel to</b>
        <form action="wirelessguruconfig.php" method="post">
            <input type="hidden" name="action" value="autochannel" />
            <input type="submit" value="auto" />
        </form>

        <br/>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="1" />
            <input type="submit" value="1" class="numberbuttons" />
        </form>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="2" />
            <input type="submit" value="2" class="numberbuttons" />
        </form>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="3" />
            <input type="submit" value="3" class="numberbuttons" />
        </form>
        <br/>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="4" />
            <input type="submit" value="4" class="numberbuttons" />
        </form>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="5" />
            <input type="submit" value="5" class="numberbuttons" />
        </form>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="6" />
            <input type="submit" value="6" class="numberbuttons" />
        </form>
        <br/>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="7" />
            <input type="submit" value="7" class="numberbuttons" />
        </form>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="8" />
            <input type="submit" value="8" class="numberbuttons" />
        </form>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="9" />
            <input type="submit" value="9" class="numberbuttons" />
        </form>
        <br/>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="10" />
            <input type="submit" value="10" class="numberbuttons" />
        </form>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="11" />
            <input type="submit" value="11" class="numberbuttons" />
        </form>
        <form action="wirelessguruconfig.php" method="post" class="floatybutton">
            <input type="hidden" name="action" value="changechannel" />
            <input type="hidden" name="channel" value="12" />
            <input type="submit" value="12" class="numberbuttons" />
        </form>
        <br/>

        <br/>

        <hr align=left noshade size=10 width=25% />

        <h2>Wireless Clients</h2>

        <p> 
<?php
exec('uaputl sta_list', $wclients, $exit_code);
echo implode("<br />\n", $wclients);
?>
        </p>

        <hr align=left noshade size=10 width=25% />

        <h2>Wireless Configuration</h2>

        <p>
<?php
exec('uaputl sys_config', $wconfig, $exit_code);
echo implode("<br />\n", $wconfig);
?>
        </p>

    </body>
</html>