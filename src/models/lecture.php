<?php

/**
 * This class models individual lectures.
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
class Lecture {
    private $lecture;
    private $status;

    function Lecture($db) {
        $this->db = $db;
    }

    public function loadStatus($status) {
        $this->status = $status;

        $sql = "SELECT * FROM lecture WHERE lid = " . $this->status->getCurrentLectureId() . ";";

        $resultarray = array();

        foreach ($this->db->query($sql) as $row) {
            $resultarray['lid'] = $row['lid'];
            $resultarray['kid'] = $row['kid'];
            $resultarray['name'] = $row['name'];
            $resultarray['lecturer'] = $row['lecturer'];
            $resultarray['contact'] = $row['contact'];
        }

        $this->lecture = $resultarray;
    }

    public function loadLite($status) {
        $this->status = $status;
    }

    public function getCurrentLecture() {
        return $this->lecture;
    }

    public function getAllLecturesInConference() {
        $sql = "SELECT * FROM lecture WHERE kid = " . $this->status->getCurrentConferenceId() . ";";

        $resultarray = array();

        foreach ($this->db->query($sql) as $row) {
            $lecture = array('lid' => $row['lid'], 'kid' => $row['kid'], 'name' => $row['name'], 'lecturer' => $row['lecturer'], 'contact' => $row['contact']);
            $resultarray[] = $lecture;
        }

        return $resultarray;
    }

    public function addAndSet($lecture, $lecturer, $email, $status) {
        $this->db->queryExec("INSERT INTO lecture(kid, name, lecturer, contact) VALUES ("
                . $status->getCurrentConferenceId() ." , '". $lecture ."', '". $lecturer ."', '". $email ."');");

        $status->setCurrentLectureId($this->db->lastInsertRowid());
    }

    public function addFuture($lecture, $lecturer, $email, $status) {
        $this->db->queryExec("INSERT INTO lecture(kid, name, lecturer, contact) VALUES ("
                . $status->getCurrentConferenceId() ." , '". $lecture ."', '". $lecturer ."', '". $email ."');");
    }
}

?>
