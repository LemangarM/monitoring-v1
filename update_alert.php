<?php
session_start(); // À placer obligatoirement avant tout code HTML.
if (isset($_POST['logoutValue'])) { // Si les variables existent.
    $logoutValue = $_POST['logoutValue'];
} else {
    $logoutValue = "";
}

if ($logoutValue == 1) {
    $_SESSION['connect'] == 0;
}
if ($_SESSION['connect'] == 1) {
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>MonitoringApplis - Reviews</title>

            <link href="css/bootstrap.min.css" rel="stylesheet">
            <link href="css/datepicker3.css" rel="stylesheet">
            <link href="css/bootstrap-table.css" rel="stylesheet">
            <link href="css/bootstrap-datepicker.css" rel="stylesheet">
            <link href="css/monitoring-app.css" rel="stylesheet">
            <link href="css/styles.css" rel="stylesheet">

            <!--Icons-->
            <script src="js/lumino.glyphs.js"></script>

            <!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/respond.min.js"></script>
            <![endif]-->

        </head>

        <body>
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php"><span>Monitoring</span>Applis</a>
                        <ul class="user-menu">
                            <li class="dropdown pull-right">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo $_SESSION['login']; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
                                    <li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
                                    <li><a href="login.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div><!-- /.container-fluid -->
            </nav>

            <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
                <form role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </form>
                <ul class="nav menu">
                    <li><a href="index.php"><svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg> Baromètre</a></li>
                    <li><a href="charts.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Vue Détaillée</a></li>
                    <li><a href="reviews.php"><svg class="glyph stroked two messages"><use xlink:href="#stroked-two-messages"/></svg> Reviews</a></li>
                    <li class="active"><a href="read_alertes.php"><svg class="glyph stroked sound on"><use xlink:href="#stroked-sound-on"/></svg> Alerting</a></li>

                    <li role="presentation" class="divider"></li>
                </ul>

            </div><!--/.sidebar-->

            <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                        <li class="active">Icons</li>
                    </ol>
                </div><!--/.row-->

                <div class='row'>
                    <div class='col-lg-12'>
                        <?php
                        $page_title = "Editer Alerte";
                        echo "<h2 class='page-header'>{$page_title}</h1>";
                        ?>
                    </div>
                </div><!--/.row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php
// include database and object files
                                include_once 'config/core.php';
                                include_once 'config/database.php';
                                include_once 'objects/alerte.php';

// get database connection
                                $database = new Database();
                                $db = $database->getConnection();

// prepare alert object
                                $alert = new Alertes($db);

// read alertes button
                                echo "<div class='margin-bottom-1em overflow-hidden'>";
                                echo "<a href='read_alertes.php' class='btn btn-primary pull-right'>";
                                echo "<span class='glyphicon glyphicon-list'></span> Liste des alertes";
                                echo "</a>";
                                echo "</div>";

// get ID of the product to be edited
                                $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// set ID property of product to be edited
                                $alert->id = $id;

// if the form was submitted
                                if ($_POST) {

                                    try {
                                        // server-side data validation
                                        if (empty($_POST['Name'])) {
                                            echo "<div class='alert alert-danger'>l'intitulé de l'alerte ne peut pas étre vide.</div>";
                                        } else if (empty($_POST['StartDate'])) {
                                            echo "<div class='alert alert-danger'>La date de débute ne peut étre vide.</div>";
                                        } else if (empty($_POST['EndDate'])) {
                                            echo "<div class='alert alert-danger'>La date de fin ne peut étre vide.</div>";
                                        } else if (empty($_POST['appID'])) {
                                            echo "<div class='alert alert-danger'>Le Nom de l'application ne peut étre vide.</div>";
                                        } else {
                                            $idAndroid = array("0001APPEL", "0003BBDUO", "0004BTVSM", "0007BVNUE", "0008BBECM", "0009BBMVB", "0010BBVVM", "0011BANDY");

                                            // set product property values
                                            $alert->name = $_POST['Name'];
                                            $alert->start_date = $_POST['StartDate'];
                                            $alert->end_date = $_POST['EndDate'];
                                            $alert->app_name = $_POST['appName'];
                                            $alert->criteria = $_POST['Criteria'];
                                            $alert->value = $_POST['Value'];
                                            $alert->nombre_occurence = $_POST['NbOccurs'];
                                            $alert->mailing_list = $_POST['MailingList'];
                                            $alert->nombre_occurence_happened = $_POST['NbOccursHappened'];
                                            $alert->status = $_POST['Status'];
                                            $alert->app_id = $_POST['appID'];
                                            if (in_array(filter_input(INPUT_POST, 'appID'), $idAndroid)) {
                                                $alert->store = "ANDROID";
                                            } else {
                                                $alert->store = "IOS";
                                            }

                                            // update the product
                                            if ($alert->update()) {
                                                echo "<div class=\"alert alert-success alert-dismissable\">";
                                                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                                echo "Product was updated.";
                                                echo "</div>";
                                            }

                                            // if unable to update the product, tell the user
                                            else {
                                                echo "<div class=\"alert alert-danger alert-dismissable\">";
                                                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                                echo "Unable to update product.";
                                                echo "</div>";
                                            }
                                        }

                                        // values to fill up our form
                                        $Name = $_POST['Name'];
                                        $StartDate = $_POST['StartDate'];
                                        $EndDate = $_POST['EndDate'];
                                        $Store = $_POST['Store'];
                                        $appName = $_POST['appName'];
                                        $Criteria = $_POST['Criteria'];
                                        $Value = $_POST['Value'];
                                        $NbOccurs = $_POST['NbOccurs'];
                                        $MailingList = $_POST['MailingList'];
                                        $NbOccursHappened = $_POST['NbOccursHappened'];
                                        $Status = $_POST['Status'];
                                        $appID = $_POST['appID'];
                                    }

                                    // show errors, if any
                                    catch (PDOException $exception) {
                                        die('ERROR: ' . $exception->getMessage());
                                    }
                                } else {
                                    // read the details of product to be edited
                                    $alert->readOne();
                                }
                                ?>

                                <!-- HTML form for updating a product -->
                                </br>
                                </br>
                                <form action='update_alert.php?id=<?php echo $id; ?>' method='post'>

                                    <table class='table table-hover table-responsive table-bordered'>

                                        <tr>
                                            <td>Alerte</td>
                                            <td><input type='text' name='Name' value="<?php echo htmlspecialchars($alert->name, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required></td>
                                        </tr>

                                        <tr>
                                            <td>Date début</td>
                                            <td>
                                                <!-- step="0.01" was used so that it can accept number with two decimal places -->
                                                <input type='text' name='StartDate' id="date-from" value="<?php echo htmlspecialchars($alert->start_date, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required />
                                                <!--<input type="text" class="form-control" placeholder="Date Début..." name="StartDate" id="date-from" required <?php //echo isset($alert->start_date) ? "value='$alert->start_date'" : "";                ?> />-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Date fin</td>
                                            <td>
                                                <!-- step="0.01" was used so that it can accept number with two decimal places -->
                                                <input type='text'  name='EndDate' id="date-to" value="<?php echo htmlspecialchars($alert->end_date, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required />

                                                    <!--<input type="text" class="form-control" placeholder="Date Fin..." name="EndDate" id="date-to" required <?php // echo isset($alert->end_date) ? "value='$alert->end_date'" : "";               ?> />-->
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Application</td>
                                            <td>
                                                <select class='form-control' name='appID'>
                                                    <optgroup label="Google Play">
                                                        <option value='0001APPEL'>Appels & YOU</option>
                                                        <option value='0003BBDUO'>B.duo</option>
                                                        <option value='0004BTVSM'>B.tv</option>
                                                        <option value='0007BVNUE'>bienvenue</option>
                                                        <option value='0008BBECM'>Espace Client Mobile</option>
                                                        <option value='0009BBMVB'>Messagerie Vocale Bbox</option>
                                                        <option value='0010BBVVM'>Messagerie vocale visuelle</option>
                                                        <option value='0011BANDY'>World & YOU</option>
                                                    </optgroup>
                                                    <optgroup label="IOS">
                                                        <option value='367615029'>Messagerie Vocale Bbox</option>
                                                        <option value='422590767'>Espace Client Mobile Bouygues Telecom</option>
                                                        <option value='657368068'>World & YOU</option>
                                                        <option value='739824309'>B.tv mobile</option>
                                                        <option value='908345121'>B.duo</option>
                                                    </optgroup>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Critères</td>
                                            <td>
                                                <?php
                                                $stmt = $alert->readCriteria();

// put them in a select drop-down
                                                echo "<select class='form-control' name='Criteria'>";

                                                echo "<option>Please select...</option>";
                                                while ($Criteria = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    extract($Criteria);

                                                    // current category of the product must be selected
                                                    if ($alert->criteria == $Criteria) {
                                                        echo "<option value='$Criteria' selected>";
                                                    } else {
                                                        echo "<option value='$Criteria'>";
                                                    }

                                                    echo "$Criteria</option>";
                                                }
                                                echo "</select>";
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Valeur</td>
                                            <td>
                                                <!-- step="0.01" was used so that it can accept number with two decimal places -->
                                                <input type='text' name='Value' value="<?php echo htmlspecialchars($alert->value, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Occurence</td>
                                            <td>
                                                <!-- step="0.01" was used so that it can accept number with two decimal places -->
                                                <input type='text' name='NbOccurs' value="<?php echo htmlspecialchars($alert->nombre_occurence, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Occurence Souhaité</td>
                                            <td>
                                                <!-- step="0.01" was used so that it can accept number with two decimal places -->
                                                <input type='text' name='NbOccursHappened' value="<?php echo htmlspecialchars($alert->nombre_occurence_happened, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Diffusion</td>
                                            <td>
                                                <!-- step="0.01" was used so that it can accept number with two decimal places -->
                                                <input type='text' name='MailingList' value="<?php echo htmlspecialchars($alert->mailing_list, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Statut</td>
                                            <td>
                                                <?php
                                                $stmt = $alert->read();

                                                // put them in a select drop-down
                                                echo "<select class='form-control' name='Status'>";

                                                echo "<option>Please select...</option>";
                                                while ($Status = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    extract($Status);

                                                    // current category of the product must be selected
                                                    if ($alert->status == $Status) {
                                                        echo "<option value='$Status' selected>";
                                                    } else {
                                                        echo "<option value='$Status'>";
                                                    }

                                                    echo "$Status</option>";
                                                }
                                                echo "</select>";
                                                ?>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td></td>
                                            <td>
                                                <button type="submit" class="btn btn-primary">
                                                    <span class='glyphicon glyphicon-edit'></span> Editer
                                                </button>
                                            </td>
                                        </tr>

                                    </table>
                                </form>

                                <?php
                                include_once "layout_footer.php";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="js/jquery-1.11.1.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/chart.min.js"></script>
                <script src="js/chart-data.js"></script>
                <script src="js/easypiechart.js"></script>
                <script src="js/easypiechart-data.js"></script>
                <script src="js/bootstrap-datepicker.js"></script>
                <script src="js/bootstrap-datepicker.fr.js" charset="UTF-8"></script>
                <script src="js/bootstrap-table.js"></script>
                <script>
                    !function ($) {
                        $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
                            $(this).find('em:first').toggleClass("glyphicon-minus");
                        });
                        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
                    }(window.jQuery);

                    $(window).on('resize', function () {
                        if ($(window).width() > 768)
                            $('#sidebar-collapse').collapse('show')
                    });
                    $(window).on('resize', function () {
                        if ($(window).width() <= 767)
                            $('#sidebar-collapse').collapse('hide')
                    });

                    $('#date-from').datepicker({
                        format: 'yyyy-mm-dd',
                        endDate: new Date(),
                        language: 'fr',
                        todayBtn: true,
                        autoclose: true
                                //startDate: '-1d'
                    });

                    $('#date-to').datepicker({
                        format: 'yyyy-mm-dd',
                        language: 'fr',
                        todayBtn: true,
                        autoclose: true
                    });

                    $("#date-to").on("dp.change", function (e) {
                        $('#date-from').data("DateTimePicker").minDate(e.date);
                    });
                    $("#date-from").on("dp.change", function (e) {
                        $('#date-to').data("DateTimePicker").maxDate(e.date);
                    });
                </script>
        </body>

    </html>
    <?php
} else { // Le mot de passe n'est pas bon.
    header('Location: login.php');
} // Fin du else.
// Fin du code. émoticône smile
?>