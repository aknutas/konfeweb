<?php session_start(); ?>
<?php
/**
 * Renders the user management view.
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

$adminlist = $adc->listAdmins();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>User Management</title>
        <link rel="stylesheet" type="text/css" href="css/feedback.css" />
    </head>
    <body>
        <p><a href="admin.php"> Back to admin </a></p>

        <hr align=left noshade size=10 width=25% />

        <h2>Add Users</h2>
        <form action="submitadmin.php" method="post">
            <label for="user">Username</label> <br />
            <input type="text" name="user" /> <br />
            <label for="pass">Password</label> <br />
            <input type="password" name="pass" />
            <br />
            <input type="submit" value="Submit" />
        </form>

        <hr align=left noshade size=10 width=25% />

        <h2>User List</h2>
        <ul>
<?php
foreach ($adminlist as $admin) {
    echo "<li>Admin ID ", $admin['uid'], ". ", $admin['user'], "</li>";
}
?>
        </ul>
    </body>
</html>