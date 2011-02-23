<?php
/**
 * Handles GET submission for switching the current conference.
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
 */include('controllers/admincontroller.php');

session_start();
$auth = new Authenticator(null);
if(!$auth->isAuthedAdmin()) {
    header( 'Location: login.php' );
    die("Please login");
}

$adm = new Admin();
$kid = $_GET["kid"];
$adm->switchConfe(filter_var($kid, FILTER_VALIDATE_INT));

header( 'Location: manageconfe.php' ) ;
?>