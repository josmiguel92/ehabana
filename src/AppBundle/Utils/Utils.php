<?php
/*
 * This file is part of the Carola project.
 *
 * (c) Josue Aguilar <josmiguel92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Utils;


class Utils
{

    /**
    *   Recorta una cadena respetando las palabras completas.
    */
    static function cutText($text, $length){
        if(strlen($text) > $length)
        {
            $lastspc = strpos($text, " ",$length);
            $text = substr($text,0,$lastspc)."...";
        }
        return $text;
    }

    /** DAda una cadena como '1 week' retorna el valor del tiempo en el pasado con la referencia actual */
    static function getTimeFromNow($string){
        $a = new \DateTime("$string ago");
        return $a->getTimestamp();
    }

    static function explodeByComas($string){
        $string = preg_replace("/[,;]( )?/",";",$string);
        //$string =  ereg_replace("[,;][\ ]?", ";", $string);

        return explode(";", $string);
    }

    static function breakLinesByBars($string){
        $string = str_replace("|", "\n", $string);
        return $string;
    }

    static function isImage($type)
    {
        switch ($type) {
            case "image/jpeg":
                return true;
            case "image/png":
                return true;
            default:
                return false;
        }
    }

    static function getDaysInterval(\DateTime $date){
        $today = new \DateTime('today');
        $interval = $today->diff($date);

        $days = $interval->invert ? $interval->days*(-1) : $interval->days;
        return $days;
    }
    //dada una fecha, retorna la referencia respecto a 'hoy' P.E: hace 7 dias
    static function getDateReference(\DateTime $date){
        $today = new \DateTime('today');
        $interval = $today->diff($date);
        $message = '';

        if ($interval->invert == 1) {//past
            if ($interval->days == 1) {
                $message = "Ayer";
            }
            else
                if ($interval->days == 2) {
                    $message = "Anteayer";
                }
                else
                    $message = "Hace ".$interval->days." dias";
        }
        else//future
        {
            if ($interval->days == 1) {
                $message = "Mañana";
            }
            else
                if ($interval->days == 2) {
                    $message = "Pasado mañana";
                }
                else
                    $message = "Dentro de ".$interval->days." dias";
        }
        if ($interval->days == 0) {
            $message = "Hoy";
        }
        return $message;
    }
}