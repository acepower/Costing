<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 07-Jul-15
 * Time: 7:31 AM
 */
class material
{

    private $piecesPerSheet;
    private $width;
    private $length;
    private $quality;
    private $type;
    private $weight;
    private $cuttingSecondsPerSheet;
    private $printingSheetsPerHour;

    public function __construct($perSheet,$width,$length,$quality,$type,$weight,$secondsPerSheet,$printSheetsPerHour){
        $this->piecesPerSheet=$perSheet;
        $this->width=$width;
        $this->$length=$length;
        $this->quality=$quality;
        $this->$type=$type;
        $this->weight=$weight;
        $this->cuttingSecondsPerSheet=$secondsPerSheet;
        $this->printingSheetsPerHour=$printSheetsPerHour;
    }

}