<?php

/**
 * This class models individual comments.
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
class Comment {

    function Comment($db, $status) {
        $this->db = $db;
        $this->status = $status;
    }

    public function addComment($comment) {

        $newComment['lid'] = $this->status->getCurrentLectureId();
        $newComment['comment'] = $comment;
        $newComment['datetime'] = date("Y-m-d H:i:s");

        $this->db->queryExec("INSERT INTO feedback(lid, comment, datetime, old) VALUES (" .
                $newComment['lid'] . ", '" . $newComment['comment'] . "', '" . $newComment['datetime']
                . "', 0);");
    }

    public function setOld($cid) {
        $this->db->queryExec("UPDATE feedback SET old = 1 WHERE cid = " . $cid . " ;");
    }

    public function setHidden($cid) {
        $this->db->queryExec("UPDATE feedback SET old = 2 WHERE cid = " . $cid . " ;");
    }

    public function getTenRecent() {
        $sql = "SELECT * FROM feedback WHERE lid = " . $this->status->getCurrentLectureId() .
                " ORDER BY cid DESC LIMIT 10";

        $resultarray = array();

        foreach ($this->db->unbufferedQuery($sql) as $row) {
            $comment = array('cid' => $row['cid'], 'comment' => $row['comment'], 'datetime' => $row['datetime'], 'old' => $row['old']);
            $resultarray[] = $comment;
        }

        return $resultarray;
    }

    public function getNewerThan($cid) {
        $sql = "SELECT * FROM feedback WHERE lid = " . $this->status->getCurrentLectureId() .
                " AND cid > " . $cid . " ORDER BY cid ASC";

        $resultarray = array();

        foreach ($this->db->unbufferedQuery($sql) as $row) {
            $comment = array('cid' => $row['cid'], 'comment' => $row['comment'], 'datetime' => $row['datetime'], 'old' => $row['old'], 'lid' => $row['lid']);
            $resultarray[] = $comment;
        }

        if (isset($resultarray))
            return $resultarray;
        else
            return null;
    }

    public function getAll() {
        $sql = "SELECT * FROM feedback WHERE lid = " . $this->status->getCurrentLectureId() .
                " ORDER BY cid DESC";

        $resultarray = array();

        foreach ($this->db->unbufferedQuery($sql) as $row) {
            $comment = array('cid' => $row['cid'], 'comment' => $row['comment'], 'datetime' => $row['datetime'], 'old' => $row['old']);
            $resultarray[] = $comment;
        }

        return $resultarray;
    }

    public function getAllAsc() {
        $sql = "SELECT * FROM feedback WHERE lid = " . $this->status->getCurrentLectureId() .
                " ORDER BY cid ASC";

        $resultarray = array();

        foreach ($this->db->unbufferedQuery($sql) as $row) {
            $comment = array('cid' => $row['cid'], 'comment' => $row['comment'], 'datetime' => $row['datetime'], 'old' => $row['old']);
            $resultarray[] = $comment;
        }

        return $resultarray;
    }

}

?>