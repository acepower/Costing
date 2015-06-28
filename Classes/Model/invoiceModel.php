<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 03-Sep-14
 * Time: 4:14 PM
 */
class InvoiceModel
{

    private $orderDetails;
    private $orderMetaData;
    private $orderRepeat;
    private $orderGenerals;
    private $orderConstants;
    private $orderMaterials;

    public function __construct()
    {
        $this->orderDetails = array();
        $this->orderRepeat = array();
        $this->orderMetaData = array();
        $this->orderGenerals = array();
        $this->orderConstants = array();
        $this->orderMaterials = array();
    }

    public function processData($dataToProcess)
    {
        $this->orderDetails = $dataToProcess;
        $this->setConstants();
        $materialCount = 1;
        $isMaterial = false;
        $metadata = array("Seller" => 1, "Customer" => 2, "Product" => 3);
        $piecesQuantity = array("Pieces1" => 1, "Pieces2" => 2, "Pieces3" => 3, "Pieces4" => 4);
        foreach ($this->orderDetails as $key => $value) {
            if (array_key_exists($key, $metadata)) {
                $this->orderMetaData[$key] = $value;
            } else {
                if (array_key_exists($key, $piecesQuantity) && $value != 0) {
                    $this->orderRepeat[$key] = $value;
                } else {
                    if ($key != "Quantity1" && $isMaterial == false) {
                        $this->orderGenerals[$key] = $value;
                    } else {
                        $isMaterial = true;
                        if (strstr($key, (string)$materialCount)) {
                            $this->orderMaterials[$materialCount][$key] = $value;
                        } else {
                            $materialCount++;
                            $this->orderMaterials[$materialCount][$key] = $value;
                        }
                    }
                }
            }
        }
    }

    private function setConstants()
    {
        $databaseConnection = new Databasehandler();
        $databaseConnection->connect();
        $query = SqlQueries::getConstants();
        $databaseConnection->safeQuery($query);
        $this->orderConstants = $databaseConnection->safeFetchArray();
        unset($this->orderConstants["ID"]);
    }

    public function getOrderMetaData()
    {
        return $this->orderMetaData;
    }

    public function getOrderRepeat()
    {
        return $this->orderRepeat;
    }

    public function getConstants()
    {
        return $this->orderConstants;
    }

    public function getOrderGenerals()
    {
        if (isset($this->orderGenerals['invoice'])) {
            unset($this->orderGenerals['invoice']);
        }

        return $this->orderGenerals;
    }

    public function getOrderMaterials()
    {
        return $this->orderMaterials;
    }

    public function processCost($quantity, $generals, $constants, $materials)
    {
        $quantity += $generals['Shoddy'];
        $cost = array();
        $cost['gluingCost'] = $this->calculateGluingCost(
            $quantity,
            $generals['GluingMinutesPerPiece'],
            $constants['GluingCost']
        );
        $cost['cuttingCost'] = $this->calculateCuttingCost($quantity, $materials, $constants);
        $cost['printingCost'] = $this->calculatePrintingCost($quantity, $materials, $constants);
        if (array_key_exists('PalletCostDropdown', $generals)) {
            $cost['transportCost'] = $this->calculateTransportCost(
                $quantity,
                $generals['PiecesPerPallet'],
                $generals['PalletCostDropdown']
            );
        } else {
            $cost['transportCost'] = $this->calculateTransportCost(
                $quantity,
                $generals['PiecesPerPallet'],
                $generals['PalletCost']
            );
        }
        $cost['runCost'] = $constants['RunCost'] * $generals['RunHours'];
        $cost['designCost'] = $constants['DesignCost'] * $generals['DesignHours'];
        if (array_key_exists('boxingPrice', $generals)) {
            $cost['boxingPrice'] = $generals['boxingPrice'];
        }
        if (array_key_exists('baggingLength', $generals)) {
            $cost['baggingPrice'] = $generals['baggingLength'] * $constants['BagCost'];
        }
        $cost['glueCost'] = $constants['GlueCost'] * $generals['GlueMeters'];

        return $cost;
    }

    private function calculateGluingCost($quantity, $minutesPerPiece, $gluingCost)
    {
        $GluingHoursPerPiece = $minutesPerPiece / 60;
        $CostPerPiece = $GluingHoursPerPiece * $gluingCost;
        $totalCost = $CostPerPiece * $quantity;

        return $totalCost;
    }

    /**
     * @param $quantity
     * @param $materials
     * @param $constants
     * @return float
     */
    private function calculateCuttingCost($quantity, $materials, $constants)
    {
        /**
         * temaxia ana fillo
         * deuterolepta ana fillo
         * sinolikes wres
         * loop through materials. get for every material seconds for cut and pieces per material sheet
         * find the total sheets by dividing the total pieces with the pieces per sheet
         * find the total seconds by multiplying total sheets with seconds for every sheet
         * find hours by dividing total seconds with 3600
         * find total cost by multiplying total hours with cost per hour.
         */
        $piecesPerSheet = 0;
        $secondsPerSheet = 0;
        $totalCuttingCost = 0;
        foreach ($materials as $key => $value) {
            $individualArray = $materials[$key];
            foreach ($individualArray as $inKey => $inValue) {
                if (strstr($inKey, "MinutesPerPiece")) {
                    $secondsPerSheet = $individualArray[$inKey];
                }
                if (strstr($inKey, "Quantity")) {
                    $piecesPerSheet = $individualArray[$inKey];
                }
            }
            $totalSheets = $quantity / $piecesPerSheet;
            $totalSeconds = $totalSheets * $secondsPerSheet;
            $totalHours = $totalSeconds / 3600;
            $totalCuttingCost += $totalHours * $constants['CuttingCost'];
        }

        return $totalCuttingCost;
    }

    public function calculatePrintingCost($quantity, $materials, $constants)
    {
        /**
         * wres Ektipwsis
         * temaxia ana fillo
         * sinoliko kostos ektipwsis
         * loop through materials. get for every material printType and pieces per sheet.
         * divide for every material quantity with pieces per sheet to get total sheets.
         * divide the total sheets with the sheets printed per hour to find how many hours.
         * get the printing cost by multiplying the total hours with the printing cost per hour
         * add every material's print cost to the total
         */
        $printHours = 0;
        $piecesPerSheet = 0;
        $totalPrintCost = 0;
        foreach ($materials as $key => $value) {
            $individualArray = $materials[$key];
            foreach ($individualArray as $inKey => $inValue) {
                if (strstr($inKey, "PrintType")) {
                    $temp['value'] = $individualArray[$inKey];
                    $databaseConnection = new Databasehandler();
                    $databaseConnection->connect();
                    $databaseConnection->safeQuery(SqlQueries::getPrintingHours(), $temp);
                    $printHours = $databaseConnection->safeFetchArray();
                }
                if (strstr($inKey, "Quantity")) {
                    $piecesPerSheet = $individualArray[$inKey];
                }
            }
            $totalSheets = $quantity / $piecesPerSheet;
            $hoursForSheets = $totalSheets / $printHours['printingPerHour'];
            $PrintCost = $hoursForSheets * $constants['PrintingCost'];
            $totalPrintCost += $PrintCost;
        }

        return $totalPrintCost;
    }

    public function calculateTransportCost($quantity, $piecesPerPallet, $palletCost)
    {
        /**
         * devide total temaxia with temaxia per paleta to find paletes.
         * total cost is pallets miltiplied with cost per pallet
         */
        $numberOfPallets = ceil($quantity / $piecesPerPallet);
        $totalCost = $numberOfPallets * $palletCost;

        return $totalCost;
    }

    private function addInvoiceToDatabase()
    {
    }
}