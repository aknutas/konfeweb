<?php

/**
 * This class models has helper functions that try to sanitize user input.
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
class Sanitizer {

    public function sanitizeText($text) {
        $text = filter_var(trim($text), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $text = filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        if (strlen($text) > 80) {
            $rtext = wordwrap($text, 60, " ", true);
            return $rtext;
        } else
            return $text;
    }

    public function sanitizeComment($text) {
        $text = filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
        if (strlen($text) > 60) {
            $rtext = wordwrap($text, 60, " ", true);
            return $rtext;
        } else
            return $text;
    }

    public function sanitizeEmail($text) {
        $text = filter_var($text, FILTER_SANITIZE_EMAIL);
        if (strlen($text) > 80) {
            $text = substr($text, 0, 80);
        }
        return $text;
    }

    public function sanitizeLogin($text) {
        $text = filter_var(trim($text), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $text = filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        if (strlen($text) > 80) {
            $text = substr($text, 0, 80);
        }
        return $text;
    }

    public function sanitizeShell($text) {
        escapeshellarg($text);
        return $text;
    }
}
?>
