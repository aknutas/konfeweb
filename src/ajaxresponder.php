<?php

/**
 * This page handles the ajax queries that the javascript components generate.
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
include('controllers/publicscreencontroller.php');
header("cache-Control: no-cache, must-revalidate");
header('Content-type: application/json');

$psc = new Publicscreen();

$action = $_GET["action"];

if ($action == "gne") {
    $cid = $_GET["cid"];
    $results = $psc->getNewerEventually(filter_var($cid, FILTER_VALIDATE_INT));
    if ($results == null) {
        $lecture = $psc->getCurrentLectureId();
        echo(json_encode(array('lid' => $lecture, 'datatype' => 'lid')));
    }
    else
        echo(json_encode($results));
} else if ($action == "setold") {
    session_start();
    $auth = new Authenticator(null);
    if ($auth->isAuthedAdmin() || $auth->isLocalHost()) {
        $cid = $_GET["cid"];
        $psc->setOld(filter_var($cid, FILTER_VALIDATE_INT));
        echo(json_encode(true));
    } else {
        $reply = array('datatype' => 'error', 'error' => 'login');
        $json = json_encode($reply);
        die($json);
    }
} else if ($action == "sethidden") {
    session_start();
    $auth = new Authenticator(null);
    if ($auth->isAuthedAdmin() || $auth->isLocalHost()) {
        $cid = $_GET["cid"];
        $psc->setHidden(filter_var($cid, FILTER_VALIDATE_INT));
        echo(json_encode(true));
    } else {
        $reply = array('datatype' => 'error', 'error' => 'login');
        $json = json_encode($reply);
        die($json);
    }
}
?>
