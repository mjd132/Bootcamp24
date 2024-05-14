<?php
class Output
{
    public static function Iecho($oMessage)
    {
        echo $oMessage;
        flush();
        ob_flush();
    }

} ?>