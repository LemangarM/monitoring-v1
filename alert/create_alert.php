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
    <?php

    function __autoload($class_name)
    {
        include $class_name . '.php';
    }
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>MonitoringApplis - Reviews</title>

            <link href="../css/bootstrap.min.css" rel="stylesheet">
            <link href="../css/datepicker3.css" rel="stylesheet">
            <link href="../css/bootstrap-table.css" rel="stylesheet">
            <link href="../css/bootstrap-datepicker.css" rel="stylesheet">
            <link href="../css/styles.css" rel="stylesheet">

            <!--Icons-->
            <script src="../js/lumino.glyphs.js"></script>
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
                    <li><a href="../index.php"><svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg> Baromètre</a></li>
                    <li><a href="../charts.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Vue Détaillée</a></li>
                    <li><a href="../reviews.php"><svg class="glyph stroked two messages"><use xlink:href="#stroked-two-messages"/></svg> Reviews</a></li>
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
                        $page_title = "Créer Alerte";
                        echo "<h2 class='page-header'>{$page_title}</h1>";
                        ?>
                    </div>
                </div><!--/.row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php
// get database connection
                                include_once 'config/core.php';
                                include_once 'config/database.php';
                                include_once 'objects/alerte.php';
                                include_once '../models/Functions.php';

// get database connection
                                $database = new Database();
                                $db = $database->getConnection();

// instantiate alerte object
                                $alert = new Alertes($db);

// set page headers
//include_once "layout_header.php";
// read alertes button
                                echo "<div class='margin-bottom-1em overflow-hidden'>";
                                echo "<a href='read_alertes.php' class='btn btn-primary pull-right'>";
                                echo "<span class='glyphicon glyphicon-list'></span> Liste des alertes";
                                echo "</a>";
                                echo "</div>";

// if the form was submitted
                                if ($_POST) {

                                    try {
                                        // data validation
                                        if (empty($_POST['Name'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Alerte est vide.</div>";
                                        } else if (empty($_POST['StartDate'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Date Début est vide.</div>";
                                        } else if (\Models\functions::checkDateTime($_POST['StartDate']) == false) {
                                            echo "<div class='alert alert-danger'>Oups!!! La date de début n'est pas valide. (format attendu aaaa-mm-jj)</div>";
                                        } else if (\Models\functions::checkDateTime($_POST['EndDate']) == false) {
                                            echo "<div class='alert alert-danger'>Oups!!! La date de fin n'est pas valide. (format attendu aaaa-mm-jj)</div>";
                                        } else if (empty($_POST['EndDate'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Date Fin est vide.</div>";
                                        } else if (empty($_POST['Store'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Store est vide.</div>";
                                        } //else if (empty($_POST['appName'])) {
                                            //echo "<div class='alert alert-danger'>Oups!!! le champ Application est vide.</div>";
                                        //} 
                                        else if (empty($_POST['Criteria'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Critères est vide.</div>";
                                        }  else if (empty($_POST['Criteria'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Critères est vide.</div>";
                                        } else if (empty($_POST['Value-note']) && empty($_POST['Value-keywords'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Valeur est vide.</div>";
                                        } else if (empty($_POST['NbOccurs'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Occurence est vide.</div>";
                                        } else if (empty($_POST['MailingList'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Diffusion est vide.</div>";
                                        } else if (empty($_POST['NbOccursHappened'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Occurence souhaité est vide.</div>";
                                        } else if (empty($_POST['Status'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Statut est vide.</div>";
                                        } else if (empty($_POST['appID'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Date Fin est vide.</div>";
                                        } else {
                                            // set product property values
                                            $alert->name = $_POST['Name'];
                                            $alert->start_date = $_POST['StartDate'];
                                            $alert->end_date = $_POST['EndDate'];
                                            $alert->store = $_POST['Store'];
                                            $alert->app_name = $_POST['appName'];
                                            $alert->criteria = $_POST['Criteria'];
                                            $alert->value = $_POST['Value-note'];
                                            $alert->value = $_POST['Value-keywords'];
                                            $alert->nombre_occurence = $_POST['NbOccurs'];
                                            $alert->mailing_list = $_POST['MailingList'];
                                            $alert->nombre_occurence_happened = $_POST['NbOccursHappened'];
                                            $alert->status = $_POST['Status'];
                                            $alert->app_id = $_POST['appID'];

                                            // create the product
                                            if ($alert->create()) {
                                                echo "<div class=\"alert alert-success alert-dismissable\">";
                                                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                                echo "Product was created.";
                                                echo "</div>";

                                                // empty post array
                                                $_POST = array();
                                            }

                                            // if unable to create the product, tell the user
                                            else {
                                                echo "<div class=\"alert alert-danger alert-dismissable\">";
                                                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                                echo "Unable to create product.";
                                                echo "</div>";
                                            }
                                        }
                                    }

                                    // show error if any
                                    catch (PDOException $exception) {
                                        die('ERROR: ' . $exception->getMessage());
                                    }
                                }
                                ?>

                                <!-- HTML form for creating a product -->
                                </br>
                                </br>
                                <form action='create_alert.php' method='post'>
                                    <table class='table table-hover table-responsive table-bordered'>
                                        <tr>
                                            <td>Alerte</td>
                                            <td><input type='text' name='Name' class='form-control' value="<?php echo isset($_POST['Name']) ? htmlspecialchars($_POST['Name'], ENT_QUOTES) : ""; ?>"></td>
                                        </tr>

                                        <tr>
                                            <td>Date Début</td>
                                            <td>
                                                <!-- step="0.01" was used so that it can accept number with two decimal places -->
                                                <input type='date' name='StartDate' class='form-control' id='date-from' required value="<?php echo isset($_POST['StartDate']) ? htmlspecialchars($_POST['StartDate'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Date Fin</td>
                                            <td>
                                                <input type='date' name='EndDate' class='form-control' id='date-to' required value="<?php echo isset($_POST['EndDate']) ? htmlspecialchars($_POST['EndDate'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Store</td>
                                            <td>
                                                <?php
                                                $stmt = $alert->readStore();

                                                // put them in a select drop-down
                                                echo "<select class='form-control' name='Store'>";
                                                while ($Store = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    extract($Store);
                                                    echo "<option value='{$Store}'>{$Store}</option>";
                                                }
                                                echo "</select>";
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Application</td>
                                            <td>
                                                <select class='form-control' name='appID'>
                                                    <optgroup label="Google Play">
                                                        <option value='0001APPEL'>Appels & YOU</option>
                                                        <option value='0002CLOUD'>B.cloud</option>
                                                        <option value='0003BBDUO'>B.duo</option>
                                                        <option value='0004BTVSM'>B.tv</option>
                                                        <option value='0005BTVTB'>B.tv tablette</option>
                                                        <option value='0006MIAMI'>Bbox Miami</option>
                                                        <option value='0007BVNUE'>bienvenue</option>
                                                        <option value='0008BBECM'>Espace Client Mobile</option>
                                                        <option value='0009BBMVB'>Messagerie Vocale Bbox</option>
                                                        <option value='0010BBVVM'>Messagerie vocale visuelle</option>
                                                        <option value='0011BANDY'>World & YOU</option>
                                                    </optgroup>
                                                    <optgroup label="IOS">
                                                        <option value='367615029'>Messagerie Vocale Bbox</option>
                                                        <option value='422590767'>Espace Client Mobile Bouygues Telecom</option>
                                                        <option value='555953050'>B.tv tablette</option>
                                                        <option value='616051890'>B.cloud</option>
                                                        <option value='657368068'>World & YOU</option>
                                                        <option value='732817452'>Box & YOU</option>
                                                        <option value='739824309'>B.tv mobile</option>
                                                        <option value='908345121'>B.duo</option>
                                                        <option value='936804141'>Bbox Miami</option>
                                                    </optgroup>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Critères</td>
                                            <td>
                                                <select class='form-control' name='Criteria'>
                                                    <option value='Note'>Note</option>
                                                    <option value='Keywords'>Mots Clés</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Valeur</td>
                                            <td>
                                                <input id='note' type='number' step="0.1" min="1.0" max="5.0" name='Value' class='form-control' value="<?php echo isset($_POST['Value']) ? htmlspecialchars($_POST['Value'], ENT_QUOTES) : ""; ?>" />
                                                <input id='keywords' type='text' name='Value' class='form-control' value="<?php echo isset($_POST['Value']) ? htmlspecialchars($_POST['Value'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Occurence</td>
                                            <td>
                                                <input type='number' name='NbOccurs' class='form-control' required value="<?php echo isset($_POST['NbOccurs']) ? htmlspecialchars($_POST['NbOccurs'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Occurence Souhaité</td>
                                            <td>
                                                <input type='number' name='NbOccursHappened' class='form-control' required value="<?php echo isset($_POST['NbOccursHappened']) ? htmlspecialchars($_POST['NbOccursHappened'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Diffusion</td>
                                            <td>
                                                <input type='text' name='MailingList' class='form-control' required value="<?php echo isset($_POST['MailingList']) ? htmlspecialchars($_POST['MailingList'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ID</td>
                                            <td>
                                                <input type='text' name='appID' class='form-control' required value="<?php echo isset($_POST['appID']) ? htmlspecialchars($_POST['appID'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>

                                        <input readonly="readonly" type='hidden' name='Status' class='form-control' required value="valide" />

                                        <?php
//                                                $stmt = $alert->read();
//
//                                                // put them in a select drop-down
//                                                echo "<select class='form-control' name='Status'>";
//                                                echo "<option>Select Status...</option>";
//
//                                                while ($Status = $stmt->fetch(PDO::FETCH_ASSOC)) {
//                                                    extract($Status);
//                                                    echo "<option value='{$Status}'>{$Status}</option>";
//                                                }
//
//                                                echo "</select>";
                                        ?>


                                        <tr>
                                            <td></td>
                                            <td>
                                                <button type="submit" class="btn btn-primary">
                                                    <span class="glyphicon glyphicon-plus"></span> Créer
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
                <script src="../js/jquery-1.11.1.min.js"></script>
                <script src="../js/bootstrap.min.js"></script>
                <script src="../js/chart.min.js"></script>
                <script src="../js/chart-data.js"></script>
                <script src="../js/easypiechart.js"></script>
                <script src="../js/easypiechart-data.js"></script>
                <script src="../js/bootstrap-datepicker.js"></script>
                <script src="../js/bootstrap-datepicker.fr.js" charset="UTF-8"></script>
                <script src="../js/bootstrap-table.js"></script>
                <script src="../js/alert.js"></script>
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
                    })
                    $(window).on('resize', function () {
                        if ($(window).width() <= 767)
                            $('#sidebar-collapse').collapse('hide')
                    })

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