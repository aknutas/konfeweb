<?php

/**
 * This model class tracks program status.
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
class Status {
    private $statusarray;

    function Status($db) {
        $this->db = $db;
    }

    public function loadStatus() {
        $sql = "SELECT * FROM settings";

        $resultarray = array();

        foreach ($this->db->query($sql) as $row) {
            $resultarray[$row['setting']] = $row['value'];
        }

        $this->statusarray = $resultarray;
    }

    public function loadCustom($lid) {
        $this->statusarray['lecture'] = $lid;
    }

    public function loadCustomConfe($kid) {
        $this->statusarray['conference'] = $kid;
    }

    public function getStatus() {
        return $this->statusarray;
    }

    public function getDeviceType() {
        return $this->statusarray['device'];
    }

    public function getChannel() {
        return $this->statusarray['channel'];
    }

    public function setChannel($channel) {
        $this->db->queryExec("UPDATE settings SET value = '". $channel ."' WHERE setting = 'channel';");
    }

    public function getSsid() {
        return $this->statusarray['bssid'];
    }

    public function setSsid($ssid) {
        $this->db->queryExec("UPDATE settings SET value = '". $ssid ."' WHERE setting = 'ssid';");
    }

    public function getCurrentLectureId() {
        return $this->statusarray['lecture'];
    }

    public function setCurrentLectureId($lid) {
        $this->db->queryExec("UPDATE settings SET value = ". $lid ." WHERE setting = 'lecture';");
    }

    public function getCurrentConferenceId() {
        return $this->statusarray['conference'];
    }

    public function setCurrentConferenceId($confid) {
        $this->db->queryExec("UPDATE settings SET value = ". $confid ." WHERE setting = 'conference';");
    }
}

?>
