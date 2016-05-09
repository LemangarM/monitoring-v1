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
            <link href="css/styles.css" rel="stylesheet">
            <link href="css/bootstrap-datepicker.css" rel="stylesheet">


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
                        <a class="navbar-brand" href="../index.php"><span>Monitoring</span>Applis</a>
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
                        <?php echo "<h2 class='page-header'>{$page_title}</h1>"; ?>
                    </div>
                </div><!--/.row-->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="bootstrap-table">
                                    <div class="fixed-table-toolbar">


                                        <form role="search" action='search_alert.php'>
                                            <div class="input-group col-md-3 pull-left margin-right-1em">
                                                <input type="text" class="form-control" placeholder="recherche..." name="s" id="srch-term" required <?php echo isset($search_term) ? "value='$search_term'" : ""; ?> />
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                                </div>
                                            </div>
                                        </form>

                                        <form role="search" action='search_alert_by_date_range.php'>
                                            <div class="input-group col-md-3 pull-left">
                                                <input type="text" class="form-control" placeholder="Date début..." name="date_from" id="date-debut" required 
                                                       <?php echo isset($date_from) ? "value='$date_from'" : ""; ?> />
                                                <span class="input-group-btn" style="width:0px;"></span>

                                                <input type="text" class="form-control" placeholder="Date fin..." name="date_to" id="date-fin" 
                                                       required <?php echo isset($date_to) ? "value='$date_to'" : ""; ?> />
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                                </div>
                                            </div>
                                        </form>


                                        <div class="columns btn-group pull-right" style="margin-top: -0.5px;">

                                            <!-- create alert button -->
                                            <a href='create_alert.php' class="btn btn-default">
                                                <span class="glyphicon glyphicon-plus"></span> Create Alert
                                            </a>

                                            <!-- export alert to CSV -->
                                            <a href='export_csv.php' class="btn btn-default">
                                                <span class="glyphicon glyphicon-download-alt"></span> Export CSV
                                            </a>

                                            <!-- delete alert records -->
                                            <button class="btn btn-default" id="delete-selected">
                                                <span class="glyphicon glyphicon-remove-circle"></span> Delete Selected
                                            </button>
                                        </div>
                                    </div>
                                    <div class="fixed-table-container">


                                        <?php
// display the products if there are any
                                        if ($num > 0) {

                                            // order opposite of the current order
                                            $reverse_order = isset($order) && $order == "asc" ? "desc" : "asc";

                                            // field name
                                            $field = isset($field) ? $field : "";

                                            // field sorting arrow
                                            $field_sort_html = "";

                                            if (isset($field_sort) && $field_sort == true) {
                                                $field_sort_html.="<span class='badge'>";
                                                $field_sort_html.=$order == "asc" ? "<span class='glyphicon glyphicon-arrow-up'></span>" : "<span class='glyphicon glyphicon-arrow-down'></span>";
                                                $field_sort_html.="</span>";
                                            }
                                            echo "<table class='table table-hover table-responsive table-bordered'>";
                                            echo "<tr>";
                                            echo "<th class='text-align-center'><input type='checkbox' id='checker' /></th>";
                                            echo "<th style='width:20%;'>";
                                            echo "<a href='read_alertes_sorted_by_fields.php?field=Name&order={$reverse_order}'>";
                                            echo "Alerte";
                                            echo $field == "Name" ? $field_sort_html : "";
                                            echo "</a>";
                                            echo "</th>";
                                            echo "<th>";
                                            echo "<a href='read_alertes_sorted_by_fields.php?field=StartDate&order={$reverse_order}'>";
                                            echo "Date Début";
                                            echo $field == "StartDate" ? $field_sort_html : "";
                                            echo "</a>";
                                            echo "</th>";
                                            echo "<th>";
                                            echo "<a href='read_alertes_sorted_by_fields.php?field=EndDate&order={$reverse_order}'>";
                                            echo "Date Fin";
                                            echo $field == "EndDate" ? $field_sort_html : "";
                                            echo "</a>";
                                            echo "</th>";
                                            echo "<th>";
                                            echo "<a href='read_alertes_sorted_by_fields.php?field=Store&order={$reverse_order}'>";
                                            echo "Store";
                                            echo $field == "EndDate" ? $field_sort_html : "";
                                            echo "</a>";
                                            echo "</th>";
                                            echo "<th style='width:15%;'>";
                                            echo "<a href='read_alertes_sorted_by_fields.php?field=appName&order={$reverse_order}'>";
                                            echo "Application";
                                            echo $field == "appName" ? $field_sort_html : "";
                                            echo "</a>";
                                            echo "</th>";
                                            echo "<th>";
                                            echo "<a href='read_alertes_sorted_by_fields.php?field=Criteria&order={$reverse_order}'>";
                                            echo "Critères";
                                            echo $field == "Criteria" ? $field_sort_html : "";
                                            echo "</a>";
                                            echo "</th>";
                                            echo "<th>";
                                            echo "<a href='read_alertes_sorted_by_fields.php?field=Value&order={$reverse_order}'>";
                                            echo "Valeur";
                                            echo $field == "Value" ? $field_sort_html : "";
                                            echo "</a>";
                                            echo "</th>";
                                            echo "<th>";
                                            echo "<a href='read_alertes_sorted_by_fields.php?field=NbOccurs&order={$reverse_order}'>";
                                            echo "Occurence";
                                            echo $field == "NbOccurs" ? $field_sort_html : "";
                                            echo "</a>";
                                            echo "</th>";
//    echo "<th>";
//    echo "<a href='read_alertes_sorted_by_fields.php?field=NbOccursHappened&order={$reverse_order}'>";
//    echo "Occurence Souhaité";
//    echo $field == "NbOccursHappened" ? $field_sort_html : "";
//    echo "</a>";
//    echo "</th>";
//    echo "<th style='width:15%;'>";
//    echo "<a href='read_alertes_sorted_by_fields.php?field=MailingList&order={$reverse_order}'>";
//    echo "Diffusion";
//    echo $field == "MailingList" ? $field_sort_html : "";
//    echo "</a>";
//    echo "</th>";
//    echo "<th>";
//    echo "<a href='read_alertes_sorted_by_fields.php?field=Status&order={$reverse_order}'>";
//    echo "Status";
//    echo $field == "Status" ? $field_sort_html : "";
//    echo "</a>";
//    echo "</th>";
//    echo "<th>";
//    echo "<a href='read_alertes_sorted_by_fields.php?field=LastUpdateDate&order={$reverse_order}'>";
//    echo "Mise à jour";
//    echo $field == "LastUpdateDate" ? $field_sort_html : "";
//    echo "</a>";
//    echo "</th>";
                                            echo "<th>Actions</th>";
                                            echo "</tr>";

                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                                extract($row);

                                                echo "<tr>";
                                                echo "<td class='text-align-center'><input type='checkbox' name='item[]' class='checkboxes' value='{$Id}' /></td>";
                                                echo "<td>{$Name}</td>";
                                                //echo "<td>&#36;" . number_format($price, 2) . "</td>";
                                                echo "<td>{$StartDate}</td>";
                                                echo "<td>{$EndDate}</td>";
                                                echo "<td>{$Store}</td>";
                                                echo "<td>{$appName}</td>";
                                                echo "<td>{$Criteria}</td>";
                                                echo "<td>{$Value}</td>";
                                                echo "<td>{$NbOccurs}</td>";
//        echo "<td>{$NbOccursHappened}</td>";
//        echo "<td>{$MailingList}</td>";
//        echo "<td>{$Status}</td>";
//        echo "<td>{$LastUpdateDate}</td>";
                                                echo "<td>";

                                                // edit product button
                                                echo "<a href='update_alert.php?id={$Id}' class='btn btn-default'>";
                                                echo "<span class='glyphicon glyphicon-edit'></span>";
                                                echo "</a> ";

                                                // delete product button
                                                echo "<a delete-id='{$Id}' delete-file='delete_alert.php' class='btn btn-default'>";
                                                echo "<span class='glyphicon glyphicon-remove'></span>";
                                                echo "</a>";

                                                echo "</td>";

                                                echo "</tr>";
                                            }

                                            echo "</table>";

                                            // needed for paging
                                            $total_rows = 0;

                                            if ($page_url == "read_alertes.php?") {
                                                $total_rows = $alert->countAll();
                                                //} else if (isset($app_name) && $page_url == "category.php?appName={$app_name}&") {
                                                //    $total_rows = $alert->countAll_ByAppName();
                                            } else if (isset($search_term) && $page_url == "search_alert.php?s={$search_term}&") {
                                                $total_rows = $alert->countAll_BySearch($search_term);
                                            } else if (isset($field) && isset($order) && $page_url == "read_alertes_sorted_by_fields.php?field={$field}&order={$order}&") {
                                                $total_rows = $alert->countAll();
                                            }

                                            // search by date range
                                            else if (isset($date_from) && isset($date_to) && $page_url == "search_alert_by_date_range.php?date_from={$date_from}&date_to={$date_to}&") {
                                                $total_rows = $alert->countSearchByDateRange($date_from, $date_to);
                                            }

                                            // paging buttons
                                            include_once 'paging.php';
                                        }

// tell the user there are no products
                                        else {
                                            echo "<div class=\"alert alert-danger alert-dismissable\">";
                                            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                                            echo "No Alert found.";
                                            echo "</div>";
                                        }
                                        ?>
                                    </div>
                                </div>
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
                    })
                    $(window).on('resize', function () {
                        if ($(window).width() <= 767)
                            $('#sidebar-collapse').collapse('hide')
                    })


                    $('#date-debut').datepicker({
                        format: 'yyyy-mm-dd',
                        endDate: new Date(),
                        language: 'fr',
                        todayBtn: true,
                        autoclose: true
                                //startDate: '-1d'
                    });

                    $('#date-fin').datepicker({
                        format: 'yyyy-mm-dd',
                        language: 'fr',
                        todayBtn: true,
                        autoclose: true
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