<?php
// include database and object files
include_once 'config/core.php';
include_once 'config/database.php';
include_once 'objects/alerte.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$alert = new Alertes($db);

// action variable
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : "";
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : "";

// page header
$page_title="Read Products";
//include_once "layout_header.php";

$stmt=$alert->searchByDateRange($date_from, $date_to, $from_record_num, $records_per_page);

//this is how to get number of rows returned
$num = $stmt->rowCount();

// to identify page for paging
$page_url="search_alert_by_date_range.php?date_from={$date_from}&date_to={$date_to}&";

// include the read template
include_once "read_alertes_template.php";

// page footer
include_once "layout_footer.php";
?>