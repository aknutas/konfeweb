<?php

/**
 * This class models individual users.
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
class User {

    private $user;
    private $db;

    function User($db) {
        $this->db = $db;
    }

    public function getAllUsers() {

        $sql = "SELECT * FROM user;";

        $resultarray = array();

        foreach ($this->db->query($sql) as $row) {
            $result['uid'] = $row['uid'];
            $result['user'] = $row['user'];
            $result['pass'] = $row['pass'];
            $result['admin'] = $row['admin'];

            $resultarray[] = $result;
        }

        return $resultarray;
    }

    public function getUserByName($user) {

        $sql = "SELECT * FROM user WHERE user = '" . $user . "';";

        $result = array();

        foreach ($this->db->query($sql) as $row) {
            $result['uid'] = $row['uid'];
            $result['user'] = $row['user'];
            $result['pass'] = $row['pass'];
            $result['admin'] = $row['admin'];
        }

        $this->user = $result;
        return $result;
    }

    public function getCurrentUser() {
        return $this->user;
    }

    public function addAdmin($user, $pass) {
        $hash = sha1($pass);
        $hashpass = base64_encode($hash);

        $this->db->queryExec("INSERT INTO user(user, pass, admin) VALUES ('"
                . $user . "', '" . $hashpass . "', 1);");
    }

}

?>
