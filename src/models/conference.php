<?php

/**
 * This class models individual conferences.
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
class Conference {

    private $conference;
    private $status;

    function Conference($db) {
        $this->db = $db;
    }

    public function loadStatus($status) {
        $this->status = $status;

        $sql = "SELECT * FROM conference WHERE kid = " . $this->status->getCurrentConferenceId() . ";";

        $resultarray = array();

        foreach ($this->db->query($sql) as $row) {
            $resultarray['kid'] = $row['kid'];
            $resultarray['name'] = $row['name'];
            $resultarray['organization'] = $row['organization'];
        }

        $this->conference = $resultarray;
    }

    public function getAllConferences() {

        $sql = "SELECT * FROM conference;";

        $resultarray = array();

        foreach ($this->db->query($sql) as $row) {
            $result['kid'] = $row['kid'];
            $result['name'] = $row['name'];
            $result['organization'] = $row['organization'];

            $resultarray[] = $result;
        }

        return $resultarray;
    }

    public function getCurrentConference() {
        return $this->conference;
    }

    public function addAndSet($name, $organization, $status) {
        $this->db->queryExec("INSERT INTO conference(name, organization) VALUES ('"
                . $name . "', '" . $organization . "');");

        $status->setCurrentConferenceId($this->db->lastInsertRowid());
    }

    public function addFuture($name, $organization, $status) {
        $this->db->queryExec("INSERT INTO conference(name, organization) VALUES ('"
                . $name . "', '" . $organization . "');");
    }

    public function deleteConferenceById($kid) {
        $this->db->queryExec("DELETE FROM conference WHERE kid = " . $kid . ";");
    }

}
?>
