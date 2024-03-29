<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
$dbh = DBConnectionFactory::createConnection();

if (strlen($_SESSION['jpaid']) == 0) {
    header('location:logout.php');
} else {
    ?>
    <!doctype html>
    <html lang="en" class="no-focus">

    <head>
        <title>WorkNet - Punët e listuara</title>
        <link rel="stylesheet" href="assets/js/plugins/datatables/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    </head>

    <body>
        <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
            <?php include_once('includes/sidebar.php'); ?>
            <?php include_once('includes/header.php'); ?>

            <main id="main-container">
                <div class="content">
                    <h2 class="content-heading">Punët e listuara</h2>
                    <div class="block">
                        <div class="block-header bg-gd-emerald">
                            <h3 class="block-title">Informacioni për punët e listuara</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Kompania</th>
                                        <th>Emri punës</th>
                                        <th>Kategoria e punës</th>
                                        <th>lloji</th>
                                        <th>Pagesa</th>
                                        <th>Aftësit e kërkuara</th>
                                        <th class="d-none d-sm-table-cell" style="width: 15%;">Lokacioni</th>
                                        <th class="d-none d-sm-table-cell">Data e publikimit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * from tbljobs join tblemployers on tblemployers.id=tbljobs.employerId";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) {
                                            ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?php echo htmlentities($cnt); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row->CompnayName); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row->jobTitle); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row->jobCategory); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row->jobType); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row->salaryPackage); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row->skillsRequired); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row->jobLocation); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlentities($row->postinDate); ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt = $cnt + 1;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
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

        <script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>

        <script src="assets/js/pages/be_tables_datatables.js"></script>
    </body>

    </html>
<?php } ?>