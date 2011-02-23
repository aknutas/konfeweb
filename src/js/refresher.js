/**
 * This javascript component handles refreshing the public screen view.
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

var lineItemCount;
var timer;
var heartbeat;
var lid;
var authed;
var hbs;

$(document).ready(function(){
    lineItemCount = $('#fbTable tbody tr:first').attr('id');
    if(lineItemCount == undefined)
        lineItemCount = 0;
    heartbeat = setTimeout(heartbeater, 30000);
    timer = setTimeout(ajaxquery, 50);
    hbs = false;

    $('#fbTable tbody tr').live('click', function() {
        if(authed == true && hbs == false){
            $(this).addClass('old');
            $.getJSON("ajaxresponder.php?action=setold&cid=" + $(this).attr('id'), function(){
                //Nothing happens
                });
        }
    });

    $('.hidediv').live('mouseover mouseout', function(event) {
        if (event.type == 'mouseover') {
            hbs = true;
        } else {
            hbs = false;
        }
    });

    $('.hidediv').live('click', function() {
        $(this).parent().parent().hide();
        if(authed == true){
            $.getJSON("ajaxresponder.php?action=sethidden&cid=" + $(this).parent().parent().attr('id'), function(){
                //Nothing happens
                });
        }
    });

    $('.expdiv').live('mouseover mouseout', function(event) {
        if (event.type == 'mouseover') {
            hbs = true;
        } else {
            hbs = false;
        }
    });

    $('.expdiv').live('click', function() {
        $extraspan = $(this).parent().parent().find('.extraspan');
        if($extraspan.attr('class').indexOf("hidden") != -1) {
            $extraspan.removeClass('hidden');
            $(this).children('.hidebutton3').html('Minimize');
        }
        else {
            $extraspan.addClass('hidden');
            $(this).children('.hidebutton3').html('Expand');
        }
    });

});

function ajaxcallback(json) {
    if(json != null){
        if(json.datatype == 'lid') {
            if(json.lid != lid)
                window.location.reload();
        } else if(json.datatype == 'error') {
            if(json.error == 'login'){
                authed = false;
                alert('You have been logged out');
            }
        } else{
            $.each(json, function(index, value) {
                if(value.lid != lid)
                    window.location.reload();
                lineItemCount = value.cid;
                var aclass;
                if (value.cid%2 == 0)
                    aclass = "even";
                else
                    aclass = "odd";
                var explode = value.datetime.split(" ");
                if (value.old == 1)
                    aclass = aclass + " old";
                aclass = aclass + " hiliterow";
                if(value.comment.length < 210) {
                    $row = $("<tr id= \""+ value.cid + "\"  style=\"\" class = \"" + aclass + "\"><td>" + value.cid + "<div class=\"hidediv\"><p class=\"hidebutton2\">Del</p></div></td>" + "<td>" + explode[1] + "</td>" + "<td>" + value.comment + "</td></tr>");
                } else {
                    p1 = value.comment.substr(0, 150);
                    p2 = value.comment.substr(150);
                    $row = $("<tr id= \""+ value.cid + "\"  style=\"\" class = \"" + aclass + "\"><td>" + value.cid + "<div class=\"hidediv\"><p class=\"hidebutton2\">Del</p></div></td>" + "<td>" + explode[1] + "</td>" + "<td> " + p1 + "<span class=\"extraspan hidden\">" + p2 + "</span>" + "<div class=\"expdiv\"><p class=\"hidebutton3\">Expand</p></div>" + " </td></tr>");
                }
                $row.prependTo('#fbTable tbody:first');
            });
        }
        $('#hbdot').html("<p>.</p>");
        setTimeout(hbdot, 40);
    }
    clearTimeout(heartbeat);
    setTimeout(ajaxquery, 50);
    heartbeat = setTimeout(heartbeater, 30000);
}

function heartbeater()
{
    clearTimeout(ajaxquery);
    setTimeout(ajaxquery, 50);
}

function hbdot()
{
    //Necessary because of an obscure Epiphany browser bug
    $('#hbdot').html("<p></p>");
}

function ajaxquery() {
    $.getJSON("ajaxresponder.php?action=gne&cid=" + lineItemCount, function(json){
        ajaxcallback(json);
    });
}