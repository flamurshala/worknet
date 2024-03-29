<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
$dbh = DBConnectionFactory::createConnection();
if (strlen($_SESSION['jpaid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $editid = $_GET['editid'];

        $sql = "update tblcategory set CategoryName=:category,Description=:description where id=:editid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':editid', $editid, PDO::PARAM_STR);
        $query->execute();
        echo '<script>alert("Category Updated successfully .")</script>';
        echo "<script>window.location.href ='manage-category.php'</script>";
    }

    ?>
    <!doctype html>
    <html lang="en" class="no-focus">

    <head>
        <title>WorkNet - Përditëso kategorinë</title>
        <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    </head>

    <body>
        <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">

            <?php include_once('includes/sidebar.php'); ?>

            <?php include_once('includes/header.php'); ?>

            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="content">

                    <!-- Register Forms -->
                    <h2 class="content-heading"> Përditëso kategorinë</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Bootstrap Register -->
                            <div class="block block-themed">
                                <div class="block-header bg-gd-emerald">
                                    <h3 class="block-title"> Përditëso kategorinë</h3>
                                </div>
                                <div class="block-content">
                                    <form method="post">
                                        <?php
                                        $editid = $_GET['editid'];
                                        $sql = "SELECT * from tblcategory where id=:editid";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':editid', $editid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) { ?>
                                                <div class="form-group row">
                                                    <label class="col-12" for="register1-email">kategoria:</label>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control"
                                                            value="<?php echo htmlentities($row->CategoryName); ?>" name="category"
                                                            required="true">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-12" for="register1-email">Përshkrimi i kategorisë:</label>
                                                    <div class="col-12">
                                                        <textarea class="form-control" rows="5" name="description"
                                                            required="true"><?php echo htmlentities($row->Description); ?></textarea>
                                                    </div>
                                                </div>
                                                <?php $cnt = $cnt + 1;
                                            }
                                        } ?>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-alt-success" name="submit">
                                                    <i class="fa fa-plus mr-5"></i> Përditëso
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
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
    </body>

    </html>
<?php } ?>