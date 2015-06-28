<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 14-Sep-14
 * Time: 3:37 PM
 */

include realpath(dirname(__DIR__)).'\\Classes\\Model\\AdminModel.php';
include realpath(dirname(__DIR__)).'\\Classes\\SqlQueries.php';
include realpath(dirname(__DIR__)).'\\Classes\\Databasehandler.php';
if (isset($_POST['searchInput']) && !empty($_POST['searchInput'])) {
    $databaseConnection = new Databasehandler();
    $databaseConnection->connect();
    $field = $_POST['searchID'];
    $value = $_POST['searchInput'];

    $sanitizedSearchInput = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sanitizedSearchInput = filter_var($sanitizedSearchInput, FILTER_SANITIZE_STRING);
    $sanitizedSearchInput = filter_var($sanitizedSearchInput, FILTER_SANITIZE_MAGIC_QUOTES);

    $sanitizedSearchField = filter_var($field, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $tempArray['field'] = $sanitizedSearchField;
    $tempArray['value'] = $sanitizedSearchInput;

    $adminQuery = SqlQueries::searchOrders();
    $databaseConnection->safeQuery($adminQuery, $tempArray);
    $result = $databaseConnection->safeFetchAll();

    if (!empty($result)) {
        $result['ajaxResult'] = true;
        $result = json_encode($result);
    } else {
        $result['searchInput'] = $sanitizedSearchInput;
        $result['message'] = " returned no results";
        $result['ajaxResult'] = false;
    }

    echo json_encode($result);
}