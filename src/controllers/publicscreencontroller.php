<?php

/**
 * This class has public screen view control components.
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
include 'settings.ini';
include 'models/comment.php';
include 'models/lecture.php';
include 'models/status.php';
include 'models/user.php';
include 'helpers/authenticator.php';

class Publicscreen {

    public function setOld($cid) {
        $this->connect();
        $this->status = new Status($this->db);
        $this->comment = new Comment($this->db, null);

        $this->comment->setOld($cid);

        unset($this->db);
    }

        public function setHidden($cid) {
        $this->connect();
        $this->status = new Status($this->db);
        $this->comment = new Comment($this->db, null);

        $this->comment->setHidden($cid);

        unset($this->db);
    }

    public function getNewerEventually($cid) {
        $this->connect();
        $this->status = new Status($this->db);
        $this->status->loadStatus();
        $this->comment = new Comment($this->db, $this->status);

        $results = $this->comment->getNewerThan($cid);
        if($results != null)
            return $results;
        else {
            $loopy = 0;
            set_time_limit(0);
            while($loopy < 300) {
                $loopy++;
                usleep(50000);
                $results = $this->comment->getNewerThan($cid);
                if($results != null) {
                    return $results;
                }
            }
            return null;
        }
    }

    public function getCurrentLectureId() {
        return $this->status->getCurrentLectureId();
    }

    public function load() {
        $this->connect();

        $this->status = new Status($this->db);
        $this->lecture = new Lecture($this->db);
        $this->status->loadStatus();
        $this->lecture->loadStatus($this->status);
        $this->comment = new Comment($this->db, $this->status);

        $data['results'] = $this->comment->getAll();
        $data['lecture'] = $this->lecture->getCurrentLecture();

        $auth = new Authenticator(null);
        if($auth->isAuthedAdmin() || $auth->isLocalHost())
            $data['authed'] = true;
        else
            $data['authed'] = false;

        unset($this->db);
        return($data);
    }

    public function connect() {
        global $timezone;
        date_default_timezone_set($timezone);
        $this->db=new SQLiteDatabase("./models/database.sqlite");
    }
}

?>