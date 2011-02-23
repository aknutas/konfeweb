<?php
/**
 * Handles POST submissions for new administrative users.
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
include('helpers/sanitizer.php');
session_start();

$adc = new Admin();
$sani = new Sanitizer();
$auth = new Authenticator(null);

session_start();
$auth = new Authenticator(null);
if (!$auth->isAuthedAdmin()) {
    header('Location: login.php');
    die("Please login");
}

$user = $_POST["user"];
$pass = $_POST["pass"];

if (isset($_POST["user"]) && isset($_POST["pass"])) {
    $user = $sani->sanitizeLogin($user);
    $pass = $sani->sanitizeLogin($pass);
    if ($user != "" && $pass != "")
        $adc->addAdmin($user, $pass);
}
header('Location: usermanag.php');
?>