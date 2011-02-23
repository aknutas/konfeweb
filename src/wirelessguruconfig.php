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
include('controllers/admincontroller.php');
include('helpers/sanitizer.php');

session_start();
$auth = new Authenticator(null);
if (!$auth->isAuthedAdmin()) {
    header('Location: login.php');
    die("Please login");
}

$sani = new Sanitizer();
$adc = new Admin();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'autochannel') {
        $adc->setChannel('auto');
    } else if ($_POST['action'] == 'changechannel' && $_POST['channel'] > 0 && $_POST['channel'] < 13) {
        $chan = filter_var($_POST['channel'], FILTER_VALIDATE_INT);
        $adc->setChannel($chan);
    } else if ($_POST['action'] == 'ssid' && isset($_POST['ssid']) && $_POST['ssid'] != "") {
        $ssid = $sani->sanitizeShell($_POST['ssid']);
        $adc->setSsid($ssid);
    }
}

header('Location: wirelessguruadmin.php');
?>