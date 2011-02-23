<?php

/**
 * Handles POST submissions for new feedback.
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
include('controllers/feedbackcontroller.php');
include('helpers/sanitizer.php');

$fbc = new Feedback();
$sani = new Sanitizer();
$comment = $_POST["feedback"];

if ($comment != "" && $comment != null) {
    if (isset($_POST["ref"]) && $_POST["ref"] != "") {
        $ref = $sani->sanitizeComment($_POST["ref"]);
        $comment = $sani->sanitizeComment($comment) . "<span class=\"ref\">" . " { reference. " . $ref . " }</span>";
        $fbc->post($comment);
    } else {
        $fbc->post($sani->sanitizeComment($comment));
    }
}
header('Location: feedback.php');
?>