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

            <link href="css/bootstrap.min.css" rel="stylesheet">
            <link href="css/datepicker3.css" rel="stylesheet">
            <link href="css/bootstrap-table.css" rel="stylesheet">
            <link href="css/bootstrap-datepicker.css" rel="stylesheet">
            <link href="css/monitoring-app.css" rel="stylesheet">
            <link href="css/styles.css" rel="stylesheet">

            <!--Icons-->
            <script src="js/lumino.glyphs.js"></script>
        </head>
        <style>
            .jqInvalid {
                color: #ff0000;
            }
        </style>
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
                                include_once 'models/Functions.php';

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
                                        } //else if (empty($_POST['appName'])) {
                                        //echo "<div class='alert alert-danger'>Oups!!! le champ Application est vide.</div>";
                                        //} 
                                        else if (empty($_POST['Criteria'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Critères est vide.</div>";
                                        } else if (empty($_POST['Criteria'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Critères est vide.</div>";
                                        } else if (empty($_POST['MailingList'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Diffusion est vide.</div>";
                                        } else if (empty($_POST['NbOccursHappened'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Occurence souhaité est vide.</div>";
                                        } else if (empty($_POST['Status'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Statut est vide.</div>";
                                        } else if (empty($_POST['appID'])) {
                                            echo "<div class='alert alert-danger'>Oups!!! le champ Date Fin est vide.</div>";
                                        } else {
                                            $idAndroid = array("0001APPEL", "0003BBDUO", "0004BTVSM", "0007BVNUE", "0008BBECM", "0009BBMVB", "0010BBVVM", "0011BANDY");


                                            // set product property values
                                            $alert->app_id = filter_input(INPUT_POST, 'appID');
                                            $alert->name = filter_input(INPUT_POST, 'Name');
                                            $alert->start_date = filter_input(INPUT_POST, 'StartDate');
                                            $alert->end_date = filter_input(INPUT_POST, 'EndDate');
                                            $alert->criteria = filter_input(INPUT_POST, 'Criteria');
                                            $alert->mailing_list = filter_input(INPUT_POST, 'MailingList');
                                            $alert->nombre_occurence_happened = filter_input(INPUT_POST, 'NbOccursHappened');
                                            $alert->status = filter_input(INPUT_POST, 'Status');
                                            if (!empty(filter_input(INPUT_POST, 'Valuenote'))) {
                                                $alert->value = filter_input(INPUT_POST, 'Valuenote');
                                            } else if (!empty(filter_input(INPUT_POST, 'Valuekeywords'))) {
                                                $alert->value = filter_input(INPUT_POST, 'Valuekeywords');
                                            }
                                            if (in_array(filter_input(INPUT_POST, 'appID'), $idAndroid)) {
                                                $alert->store = "ANDROID";
                                            } else {
                                                $alert->store = "IOS";
                                            }
                                            // get appname
                                            $name_app = $alert->getappNameByIb();
                                            // convert appName array to string
                                            $alert->app_name = implode("','", $name_app);


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
                                <form action='create_alert.php' method='post' id="emailFrm">
                                    <table class='table table-hover table-responsive table-bordered'>
                                        <tr>
                                            <td>Alerte</td>
                                            <td><input type='text' name='Name' class='form-control' value="<?php echo isset($_POST['Name']) ? htmlspecialchars($_POST['Name'], ENT_QUOTES) : ""; ?>"></td>
                                        </tr>

                                        <tr>
                                            <td>Date Début</td>
                                            <td>
                                                <!-- step="0.01" was used so that it can accept number with two decimal places -->
                                                <input type='text' name='StartDate' class='form-control' id='date-from' value="<?php echo isset($_POST['StartDate']) ? htmlspecialchars($_POST['StartDate'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Date Fin</td>
                                            <td>
                                                <input type='text' name='EndDate' class='form-control' id='date-to' value="<?php echo isset($_POST['EndDate']) ? htmlspecialchars($_POST['EndDate'], ENT_QUOTES) : ""; ?>" />
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
                                                <select class='form-control' name='Criteria'>
                                                    <option value='Note'>Note</option>
                                                    <option value='Keywords'>Mots Clés</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Valeur</td>
                                            <td>
                                                <input id='note' type='number' name='Valuenote' class='form-control' value="<?php echo isset($_POST['Valuenote']) ? htmlspecialchars($_POST['Valuenote'], ENT_QUOTES) : ""; ?>" />
                                                <input id='keywords' type='text' name='Valuekeywords' class='form-control' value="<?php echo isset($_POST['Valuekeywords']) ? htmlspecialchars($_POST['Valuekeywords'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Occurence</td>
                                            <td>
                                                <input type='number' name='NbOccursHappened' class='form-control' value="<?php echo isset($_POST['NbOccursHappened']) ? htmlspecialchars($_POST['NbOccursHappened'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Diffusion</td>
                                            <td>
                                                <input type='text' id="emails" name='MailingList' class='form-control' value="<?php echo isset($_POST['MailingList']) ? htmlspecialchars($_POST['MailingList'], ENT_QUOTES) : ""; ?>" />
                                            </td>
                                        </tr>

                                        <input readonly="readonly" type='hidden' name='Status' class='form-control' required value="Active" />

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
                <script src="js/jquery-1.11.1.min.js"></script>
                <script src="js/jquery.validate.min.js" type="text/javascript"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/chart.min.js"></script>
                <script src="js/chart-data.js"></script>
                <script src="js/easypiechart.js"></script>
                <script src="js/easypiechart-data.js"></script>
                <script src="js/bootstrap-datepicker.js"></script>
                <script src="js/bootstrap-datepicker.fr.js" charset="UTF-8"></script>
                <script src="js/bootstrap-table.js"></script>
                <script src="js/alert.js"></script>
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
                    // Date parameters
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

                    // form validators

                    $(document).ready(function () {
                        jQuery.validator.addMethod("multiemail", function (value, element) {
                            if (this.optional(element)) {
                                return true;
                            }
                            var emails = value.split(';'),
                                    valid = true;
                            for (var i = 0, limit = emails.length; i < limit; i++) {
                                value = emails[i];
                                valid = valid && jQuery.validator.methods.email.call(this, value, element);
                            }
                            return valid;
                        }, "Please separate email addresses with a ';' and do not use spaces.");


                        $("#emailFrm").validate({
                            errorClass :'jqInvalid',
                            rules: {
                                Name:{
                                    required:true,
                                    
                                },
                                StartDate:{
                                    required:true,
                                },
                                EndDate:{
                                    required:true,
                                },
                                Valuenote: {
                                    required: true,
                                    number: true
                                },
                                Valuekeywords: {
                                    required: true,
                                },
                                NbOccursHappened: {
                                    required: true,
                                    number:true
                                },
                                MailingList: {
                                    required: true,
                                    multiemail: true
                                }
                            },
                            messages:
                                    {
                                        MailingList: {
                                            required: "Please enter email address."
                                        }
                                    }
                        });
                    });
                </script>
                <?php
            } else { // Le mot de passe n'est pas bon.
                header('Location: login.php');
            } // Fin du else.
// Fin du code. émoticône smile
