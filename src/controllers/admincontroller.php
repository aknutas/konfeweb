<?php

/**
 * This class has the administrative function control components.
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
include 'models/conference.php';
include 'models/lecture.php';
include 'models/status.php';
include 'models/comment.php';
include 'models/user.php';
include 'helpers/pdfoutputter.php';
include 'helpers/authenticator.php';
include 'helpers/devicecontrol.php';

class Admin {

    function load() {
        $this->connect();
        $this->status = new Status($this->db);
        $this->lecture = new Lecture($this->db);
        $this->conference = new Conference($this->db);

        $this->status->loadStatus();
        $this->lecture->loadStatus($this->status);
        $this->conference->loadStatus($this->status);

        $data['lecture'] = $this->lecture->getCurrentLecture();
        $data['conference'] = $this->conference->getCurrentConference();
        $data['alllectures'] = $this->lecture->getAllLecturesInConference();
        $data['devtype'] = $this->status->getDeviceType();

        unset($this->db);

        return $data;
    }

    function loadSpecificConfe($kid) {
        $this->connect();
        $this->status = new Status($this->db);
        $this->customstatus = new Status(null);
        $this->lecture = new Lecture($this->db);
        $this->conference = new Conference($this->db);

        $this->status->loadStatus();
        if ($kid != null) {
            $this->customstatus->loadCustomConfe($kid);
            $this->lecture->loadLite($this->customstatus);
            $this->conference->loadStatus($this->customstatus);
            $data['alllectures'] = $this->lecture->getAllLecturesInConference();
        } else {
            $data['alllectures'] = null;
        }

        $this->lecture->loadStatus($this->status);
        $this->conference->loadStatus($this->status);
        $data['currentconference'] = $this->status->getCurrentConferenceId();
        $data['allconferences'] = $this->conference->getAllConferences();
        $data['nowlecture'] = $this->lecture->getCurrentLecture();
        $data['nowlectures'] = $this->lecture->getAllLecturesInConference();
        $data['nowconference'] = $this->conference->getCurrentConference();

        unset($this->db);

        return $data;
    }

    function addAndSet($lecture, $lecturer, $email) {
        $this->connect();

        $this->status = new Status($this->db);
        $this->lecture = new Lecture($this->db);
        $this->status->loadStatus();
        $this->lecture->loadStatus($this->status);

        $this->lecture->addAndSet($lecture, $lecturer, $email, $this->status);
        unset($this->db);
    }

    function addFuture($lecture, $lecturer, $email) {
        $this->connect();

        $this->status = new Status($this->db);
        $this->lecture = new Lecture($this->db);
        $this->status->loadStatus();

        $this->lecture->addFuture($lecture, $lecturer, $email, $this->status);
        unset($this->db);
    }

    function setChannel($channel) {
        $this->connect();
        $this->status = new Status($this->db);
        $this->devcon = new Devicecontrol($this->status);

        $this->devcon->changeChannel($channel);
        $this->status->setChannel($channel);

        unset($this->db);
    }

    function setSsid($ssid) {
        $this->connect();
        $this->status = new Status($this->db);
        $this->devcon = new Devicecontrol($this->status);

        $this->devcon->changeSsid($ssid);
        $this->status->setSsid($ssid);

        unset($this->db);
    }

    function addAdmin($user, $pass) {
        $this->connect();
        $this->user = new User($this->db);

        $this->user->addAdmin($user, $pass);

        unset($this->db);
    }

    function listAdmins() {
        $this->connect();
        $this->user = new User($this->db);

        return($this->user->getAllUsers());

        unset($this->db);
    }

    function addAndSetConfe($name, $organization) {
        $this->connect();

        $this->status = new Status($this->db);
        $this->confe = new Conference($this->db);
        $this->status->loadStatus();
        $this->confe->loadStatus($this->status);

        $this->confe->addAndSet($name, $organization, $this->status);
        unset($this->db);
    }

    function addFutureConfe($name, $organization) {
        $this->connect();

        $this->status = new Status($this->db);
        $this->confe = new Conference($this->db);
        $this->status->loadStatus();

        $this->confe->addFuture($name, $organization, $this->status);
        unset($this->db);
    }

    public function getFeedBackPdf($lid) {
        $this->connect();
        $this->pdf = new PDF();
        $this->status = new Status(null);
        $this->lecture = new Lecture($this->db);
        $this->comment = new Comment($this->db, $this->status);

        $this->status->loadCustom($lid);
        $this->lecture->loadStatus($this->status);

        $data['results'] = $this->comment->getAllAsc();
        $data['lecture'] = $this->lecture->getCurrentLecture();

        unset($this->db);
        $this->pdf->reportToPdf($data);
    }

    public function switchLecture($lid) {
        $this->connect();
        $this->status = new Status($this->db);

        $this->status->setCurrentLectureId($lid);

        unset($this->db);
    }

    public function switchConfe($kid) {
        $this->connect();
        $this->status = new Status($this->db);

        $this->status->setCurrentConferenceId($kid);

        unset($this->db);
    }

    public function deleteConfe($kid) {
        $this->connect();
        $this->confe = new Conference($this->db);

        $this->confe->deleteConferenceById($kid);

        unset($this->db);
    }

    public function connect() {
        global $timezone;
        date_default_timezone_set($timezone);
        $this->db = new SQLiteDatabase("./models/database.sqlite");
    }

}