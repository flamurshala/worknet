<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
$dbh = DBConnectionFactory::createConnection();
if (strlen($_SESSION['jpaid'] == 0)) {
    header('location:logout.php');
} else {
    ?>
    <!doctype html>
    <html lang="en" class="no-focus">

    <head>
        <title>WorkNet - Admin Dashboard</title>
        <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    </head>

    <body>
        <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">

            <?php include_once('includes/sidebar.php'); ?>

            <?php include_once('includes/header.php'); ?>

            <main id="main-container">
                <div class="content">
                    <div class="block-header bg-gd-emerald">
                        <h3 class="block-title">Dashboard</h3>
                    </div>
                    <hr />
                    <div class="row gutters-tiny invisible" data-toggle="appear">
                        <div class="col-6 col-md-4 col-xl-6">
                            <?php
                            $sql1 = "SELECT id from tblcategory";
                            $query1 = $dbh->prepare($sql1);
                            $query1->execute();
                            $results = $query1->fetchAll(PDO::FETCH_OBJ);
                            $totcat = $query1->rowCount(); ?>
                            <a class="block text-center" href="manage-category.php">
                                <div class="block-content ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-gd-dusk">
                                    <div class="ribbon-box">
                                        <?php echo htmlentities($totcat); ?>
                                    </div>
                                    <p class="mt-5">
                                        <i class="si si-book-open fa-3x text-white-op"></i>
                                    </p>
                                    <p class="font-w600 text-white">Të gjitha kategoritë</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-6">
                            <?php
                            $sql2 = "SELECT id from tblemployers";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $results = $query2->fetchAll(PDO::FETCH_OBJ);
                            $totemp = $query2->rowCount();
                            ?>
                            <a class="block text-center" href="employer-list.php">
                                <div class="block-content ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-gd-dusk">
                                    <div class="ribbon-box">
                                        <?php echo htmlentities($totemp); ?>
                                    </div>
                                    <p class="mt-5">
                                        <i class="fa fa-building fa-3x text-white-op"></i>
                                    </p>
                                    <p class="font-w600 text-white">Të gjithë punëdhënësit e regjistruar</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-6">
                            <?php
                            $sql3 = "SELECT id from tbljobseekers";
                            $query3 = $dbh->prepare($sql3);
                            $query3->execute();
                            $results = $query3->fetchAll(PDO::FETCH_OBJ);
                            $totcan = $query3->rowCount();
                            ?>
                            <a class="block text-center" href="reg-jobseekers.php">
                                <div class="block-content ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-gd-sea">

                                    <div class="ribbon-box">
                                        <?php echo htmlentities($totcan); ?>
                                    </div>
                                    <p class="mt-5">
                                        <i class="fa fa-users fa-3x text-white-op"></i>
                                    </p>
                                    <p class="font-w600 text-white">Të gjithë punëkërkuesit e regjistruar</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-6">
                            <?php
                            $sql4 = "SELECT jobId from tbljobs";
                            $query4 = $dbh->prepare($sql4);
                            $query4->execute();
                            $results = $query4->fetchAll(PDO::FETCH_OBJ);
                            $totaljobs = $query4->rowCount();
                            ?>
                            <a class="block text-center" href="all-listed-jobs.php">
                                <div class="block-content ribbon ribbon-bookmark ribbon-crystal ribbon-left bg-gd-sea">
                                    <div class="ribbon-box">
                                        <?php echo htmlentities($totaljobs); ?>
                                    </div>
                                    <p class="mt-5">
                                        <i class="fa fa-tasks fa-3x text-white-op"></i>
                                    </p>
                                    <p class="font-w600 text-white">Të gjitha punët e publikuara</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </main>

            <?php include_once('includes/footer.php'); ?>
        </div>

        <script src="assets/js/core/jquery.min.js"></script>
        <script src="assets/js/core/popper.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script>
        <script src="assets/js/core/jquery.slimscroll.min.js"></script>
        <script src="assets/js/core/jquery.scrollLock.min.js"></script>
        <script src="assets/js/core/jquery.appear.min.js"></script>
        <script src="assets/js/core/jquery.countTo.min.js"></script>
        <script src="assets/js/core/js.cookie.min.js"></script>
        <script src="assets/js/codebase.js"></script>
        <script src="assets/js/plugins/chartjs/Chart.bundle.min.js"></script>
        <script src="assets/js/pages/be_pages_dashboard.js"></script>
    </body>

    </html>
<?php } ?>