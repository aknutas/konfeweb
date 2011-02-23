#!/usr/bin/php
<?php
/**
 * This script can set wireless settings at device startup.
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
include 'models/dbconnector.php';
include 'models/status.php';
include 'helpers/devicecontrol.php';

$dbc = new DbConnector();
$db = $dbc->dbConnect();
$status = new Status($db);
$status->loadStatus();
$devcon = new Devicecontrol($status);

if ($status->getDeviceType() == "guruplug") {
    if ($status->getChannel() != "" && $status->getChannel() != null) {
        $devcon->changeChannel($status->getChannel());
        echo "Changed channel to ", $status->getChannel();
    }
    if ($status->getSsid() != "" && $status->getSsid() != null) {
        $devcon->changeSsid($status->getSsid());
        echo "Changed ssid to ", $status->getSsid();
    }
}
?>
