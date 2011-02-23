<?php

/**
 * This class has helper functions that relate to user authentication.
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

class Authenticator {

    private $db;
    private $user;

    public function Authenticator($db) {
        $this->db = $db;
        if ($this->db != null)
            $this->user = new User($db);
    }

    public function isLocalHost() {
        $addr = $this->getRealIpAddr();
        if ($addr == "127.0.0.1" || $addr == "localhost" || $addr == "::ffff:127.0.0.1")
            return true;
        else
            return false;
    }

    function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function isAuthedAdmin() {
        if (isset($_SESSION['authedadmin'])) {
            if ($_SESSION['authedadmin'] == true) {
                $_SESSION['authedadmin'] = true;
                return true;
            } else {
                return false;
            }
        }
    }

    public function getCurrentUid() {
        if (isset($_SESSION['uid']))
            return $_SESSION['uid'];
        else
            return null;
    }

    public function logOut() {
        if (isset($_SESSION['uid']))
            unset($_SESSION['uid']);
        if (isset($_SESSION['authedadmin']))
            unset($_SESSION['authedadmin']);
        if (isset($_SESSION['user']))
            unset($_SESSION['user']);
    }

    public function authenticamateAdmin($user, $pass) {
        if ($this->db == null || !isset($this->db)) {
            $dbc = new DbConnector();
            $this->db = $dbc->dbConnect();
            $this->user = new User($this->db);
        }

        $hash = sha1($pass);
        $hashpass = base64_encode($hash);

        $results = $this->user->getUserByName($user);

        if ($results == null) {
            usleep(250000);
            return false;
        }

        if ($results['pass'] == $hashpass && $results['admin'] == 1) {
            $_SESSION['authedadmin'] = true;
            $_SESSION['uid'] = $results['uid'];
            $_SESSION['user'] = $results['user'];
            return true;
        } else {
            $_SESSION['authedadmin'] = false;
            usleep(500000);
            return false;
        }
    }

}

?>
