<?php

/**
 * This class has feedback view control components.
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
include 'models/comment.php';
include 'models/lecture.php';
include 'models/status.php';

class Feedback{

    function load() {
        $this->connect();

        $this->status = new Status($this->db);
        $this->lecture = new Lecture($this->db);
        $this->status->loadStatus();
        $this->lecture->loadStatus($this->status);
        $this->comment = new Comment($this->db, $this->status);

        $data['results'] = $this->comment->getTenRecent();
        $data['lecture'] = $this->lecture->getCurrentLecture();

        return $data;
    }

        function loadAll() {
        $this->connect();

        $this->status = new Status($this->db);
        $this->lecture = new Lecture($this->db);
        $this->status->loadStatus();
        $this->lecture->loadStatus($this->status);
        $this->comment = new Comment($this->db, $this->status);

        $data['results'] = $this->comment->getAll();
        $data['lecture'] = $this->lecture->getCurrentLecture();

        return $data;
    }

    function post($comment) {
        $this->connect();

        $this->status = new Status($this->db);
        $this->lecture = new Lecture($this->db);
        $this->status->loadStatus();
        $this->lecture->loadStatus($this->status);
        $this->comment = new Comment($this->db, $this->status);

        $this->comment->addComment($comment);
    }

    public function connect() {
        date_default_timezone_set('Europe/Helsinki');
        $this->db=new SQLiteDatabase("./models/database.sqlite");
    }
}
