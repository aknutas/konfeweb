<?php

/**
 * This class invokes FPDF with proper formatting.
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
require('util/fpdf.php');

class PDF extends FPDF {
    function FancyTable($header,$data,$lecture) {
        //Arial 12
        $this->SetFont('Arial','',12);
        //Background color
        $this->SetFillColor(230);
        //Title
        $this->Cell(0,6,$lecture['name'],0,1,'L',true);
        if(isset($lecture['lecturer']) && $lecture['lecturer'] != "" && $lecture['lecturer'] != null)
            $this->Cell(0,6,$lecture['lecturer'] . ", " . $lecture['contact'],0,1,'L',true);
        //Line break
        $this->Ln(4);

        //Colors, line width and bold font
        $this->SetFont('Arial','',14);
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        //Header
        $w=array(16,24,155);
        for($i=0;
        $i<count($header);
        $i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        //Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        //Data
        $fill=false;
        foreach($data as $row) {
            $comment = str_replace("<span class=\"ref\">", "", $row['comment']);
            $comment = str_replace("</span>", "", $comment);
            $comment = utf8_decode(html_entity_decode($comment, ENT_QUOTES, 'UTF-8'));
            $comment = wordwrap($comment, 55, "\n\r;", true);
            $rtext = explode("\n\r;", $comment);
            $time = explode(" ", $row['datetime']);
            $i=0;
            foreach($rtext as $rti) {
                if($i==0) {
                    $this->Cell($w[0],6,number_format($row['cid']),'LR',0,'L',$fill);
                    $this->Cell($w[1],6,$time[1],'LR',0,'L',$fill);
                    $this->Cell($w[2],6,$rti,'LR',0,'L',$fill);
                    $this->Ln();
                } else {
                    $this->Cell($w[0],6," ",'LR',0,'L',$fill);
                    $this->Cell($w[1],6," ",'LR',0,'L',$fill);
                    $this->Cell($w[2],6,$rti,'LR',0,'L',$fill);
                    $this->Ln();
                }
                $i++;
            }
            $fill=!$fill;
        }
        $this->Cell(array_sum($w),0,'','T');
    }

    function reportToPDF($data) {
        $header=array('#','Time','Comment');
        $this->AddPage();
        $this->FancyTable($header, $data['results'], $data['lecture']);
        $this->Output();
    }
}
?>
