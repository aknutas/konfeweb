<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
/**
 * This page lists the possible navigations for an administrator.
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
include('controllers/admincontroller.php');
$auth = new Authenticator(null);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>KonfeWeb System</title>
        <style>
            .emphasis { font-weight:bold; }
        </style>
    </head>
    <body>
        <p class="emphasis"><a href="feedback.php">Give lecture feedback</a></p>
        <br/>
        <p>
            <a href="publicscreen.php">View the public screen</a><br/><br/>
<?php
if ($auth->isAuthedAdmin())
    echo "<a href=\"submitlogout.php\">Logout</a><br/>";

else
    echo "<a href=\"login.php\">Login</a><br/>";
?>
            <a href="admin.php">Administrate</a>
        </p>
    </body>
</html>
