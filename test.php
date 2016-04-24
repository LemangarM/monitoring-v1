<?php
include_once 'alert/config/database.php';
include_once 'models/tables/Charts.php';

$database = new Database();
$db = $database->getConnection();

$charts = new Charts($db);

foreach ($charts->appName('0999BTVSM') as $data) :
    ?>
    <div class="form-group">
        <img src="images/<?php echo $data->appName ?>.png" id="img">
    </div>
    <div class="entity-name" itemprop="name"><?php echo $data->appName ?></div>
<?php endforeach; ?>


