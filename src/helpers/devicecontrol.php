<?php

/**
 * This class has helper functions that control embedded devices.
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
class Devicecontrol {
    private $devtype;

    public function Devicecontrol($status) {
        $this->devtype=$status->getDeviceType();
    }
    
    public function changeChannel($channel) {
        if($this->devtype == 'guruplug') {
            if($channel == 'auto') {
                exec('uaputl bss_stop');
                exec('uaputl sys_cfg_channel 0 1');
                exec('uaputl bss_start');
            }
            else {
                exec('uaputl bss_stop');
                exec('uaputl sys_cfg_channel ' . $channel);
                exec('uaputl bss_start');
            }
        }
    }

    public function changeSsid($ssid) {
        if($this->devtype == 'guruplug') {
            exec('uaputl bss_stop');
            exec('uaputl sys_cfg_ssid ' . $ssid);
            exec('uaputl bss_start');
        }
    }
}

?>
