<?php
session_start();
include('includes/config.php');
$dbh = DBConnectionFactory::createConnection();
error_reporting(0);
if (strlen($_SESSION['jsid']) == 0) {
  header('location:emp-login.php');
} else {
  if (isset($_POST['update'])) {
    $img = $_FILES["image"]["name"];
    $uid = $_SESSION['jsid'];
    $resume = $_FILES["resume"]["name"];
    $extension = substr($resume, strlen($resume) - 4, strlen($resume));
    $allowed_extensions = array(".pdf", "docx", ".doc");
    if (!in_array($extension, $allowed_extensions)) {
      echo "<script>alert('Invalid Resume format. Only jpg / jpeg/ png /gif format allowed');</script>";
    } else {
      $resumename = md5($resume) . time() . $extension;
      move_uploaded_file($_FILES["resume"]["tmp_name"], "Jobseekersresumes/" . $resumename);
      $sql = "update  tbljobseekers set Resume=:resumename where id=:uid";
      $query = $dbh->prepare($sql);
      $query->bindParam(':uid', $uid, PDO::PARAM_STR);
      $query->bindParam(':resumename', $resumename, PDO::PARAM_STR);
      $query->execute();
      echo '<script>alert("Your resume has been updated")</script>';
      echo "<script>window.location.href ='profile.php'</script>";
    }
  }
  ?>
  <!doctype html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employers | Përditëso Detajet e llogarisë</title>
    <link href="css/custom.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/color.css" rel="stylesheet" type="text/css">
    <link href="css/responsive.css" rel="stylesheet" type="text/css">
    <link href="css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/editor.css" type="text/css" rel="stylesheet" />
    <link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,500,700,900' rel='stylesheet'
      type='text/css'>
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
  </head>

  <body class="theme-style-1">
    <div id="wrapper">
      <?php include('includes/header.php'); ?>
      <section id="inner-banner">
        <div class="container">
          <h1>Përditëso CV</h1>
        </div>
      </section>
      <div id="main">
        <form name="empsignup" enctype="multipart/form-data" method="post">
          <section class="resum-form padd-tb">
            <div class="container">
              <?php if (@$error) { ?>
                <div class="errorWrap">
                  <strong>ERROR</strong> :
                  <?php echo htmlentities($error); ?>
                </div>
              <?php } ?>
              <?php if (@$msg) { ?>
                <div class="succMsg">
                  <strong>Success</strong> :
                  <?php echo htmlentities($msg); ?>
                </div>
              <?php } ?>
              <div class="row">
                <?php
                $uid = $_SESSION['jsid'];
                $sql = "SELECT * from  tbljobseekers  where id=:uid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                  foreach ($results as $result) {
                    ?>
                    <div class="col-md-6 col-sm-6">
                      <label>CV e tanishme</label>
                      <a href="Jobseekersresumes/<?php echo $result->Resume; ?>" target="_blank"><img src="images/resume.png"
                          title="Click Here for View Resume" align="center"></a>
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <label>Përditëso CV</label>
                      <div class="upload-box">
                        <div class="hold">
                          <input type="file" name="resume" required>
                          </span>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                }
                ?>
                <div class="col-md-12">
                  <div class="btn-col">
                    <input type="submit" name="update" value="Update">
                  </div>
                </div>
              </div>
            </div>
          </section>
        </form>
      </div>
      <?php include('includes/footer.php'); ?>
    </div>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.velocity.min.js"></script>
    <script src="js/jquery.kenburnsy.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/editor.js"></script>
    <script src="js/jquery.accordion.js"></script>
    <script src="js/jquery.noconflict.js"></script>
    <script src="js/theme-scripts.js"></script>
    <script src="js/custom.js"></script>
  </body>

  </html>
<?php }
?>