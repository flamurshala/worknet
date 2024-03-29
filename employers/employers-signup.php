<?php
session_start();
include('includes/config.php');
$dbh = DBConnectionFactory::createConnection();
error_reporting(0);
if (isset($_POST['signup'])) {
  $conrnper = $_POST['concernperson'];
  $emaill = $_POST['email'];
  $cmpnyname = $_POST['companyname'];
  $tagline = $_POST['tagline'];
  $description = $_POST['description'];
  $website = $_POST['website'];
  $password = $_POST['empppassword'];
  $options = ['cost' => 12];
  $hashedpass = password_hash($password, PASSWORD_BCRYPT, $options);
  $logo = $_FILES["logofile"]["name"];
  $extension = substr($logo, strlen($logo) - 4, strlen($logo));
  $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
  if (!in_array($extension, $allowed_extensions)) {
    echo "<script>alert('Invalid logo format. Only jpg / jpeg/ png /gif format allowed');</script>";
  } else {
    $logoname = md5($logo) . $extension;
    move_uploaded_file($_FILES["logofile"]["tmp_name"], "employerslogo/" . $logoname);

    $ret = "SELECT * FROM  tblemployers where (EmpEmail=:uemail)";
    $queryt = $dbh->prepare($ret);
    $queryt->bindParam(':uemail', $emaill, PDO::PARAM_STR);
    $queryt->execute();
    $results = $queryt->fetchAll(PDO::FETCH_OBJ);
    if ($queryt->rowCount() == 0) {
      $isactive = 1;
      $sql = "INSERT INTO tblemployers(ConcernPerson,EmpEmail,EmpPassword,CompnayName,CompanyTagline,CompnayDescription,CompanyUrl,CompnayLogo,Is_Active) VALUES(:conrnper,:emaill,:hashedpass,:cmpnyname,:tagline,:description,:website,:logoname,:isactive)";
      $query = $dbh->prepare($sql);
      $query->bindParam(':conrnper', $conrnper, PDO::PARAM_STR);
      $query->bindParam(':emaill', $emaill, PDO::PARAM_STR);
      $query->bindParam(':hashedpass', $hashedpass, PDO::PARAM_STR);
      $query->bindParam(':cmpnyname', $cmpnyname, PDO::PARAM_STR);
      $query->bindParam(':tagline', $tagline, PDO::PARAM_STR);
      $query->bindParam(':description', $description, PDO::PARAM_STR);
      $query->bindParam(':website', $website, PDO::PARAM_STR);
      $query->bindParam(':logoname', $logoname, PDO::PARAM_STR);
      $query->bindParam(':isactive', $isactive, PDO::PARAM_STR);
      $query->execute();
      $lastInsertId = $dbh->lastInsertId();
      if ($lastInsertId) {
        $msg = "Jeni kyçur me sukses";
      } else {
        $error = "Diqka shkoj keq. Ju lutem provoni përsëri";
      }
    } else {
      $error = "Email-id ekziston. Ju lutem provoni përsëri";
    }
  }
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employers | Signup</title>
  <link href="../css/custom.css" rel="stylesheet" type="text/css">
  <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="../css/color.css" rel="stylesheet" type="text/css">
  <link href="../css/responsive.css" rel="stylesheet" type="text/css">
  <link href="../css/owl.carousel.css" rel="stylesheet" type="text/css">
  <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="../css/editor.css" type="text/css" rel="stylesheet" />
  <link href="../css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,500,700,900' rel='stylesheet'
    type='text/css'>
</head>

<body class="theme-style-1">
  <div id="wrapper">
    <?php include('includes/header.php'); ?>
    <section id="inner-banner">
      <div class="container">
        <h1>Punëdhënësi</h1>
      </div>
    </section>
    <div id="main">
      <section class="account-option">
        <div class="container">
          <div class="inner-box">
            <div class="text-box">
              <h4>Keni llogari, kyçu.</h4>
              <p>Nëse nuk keni llogari mund ta krijoni një duke i plotësuar të dhënat më poshtë.. </p>
            </div>
            <a href="emp-login.php" class="btn-style-1"><i class="fa fa-sign-in"></i>Sign in Now</a>
          </div>
        </div>
      </section>
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
                <strong>Sukses</strong> :
                <?php echo htmlentities($msg); ?>
              </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <label>Emri dhe mbiemri</label>
                <input type="text" name="concernperson" required autocomplete="off" />
              </div>
              <div class="col-md-6 col-sm-6">
                <label>Emaili</label>
                <input type="email" name="email" id="email" onBlur="userAvailability()" autocomplete="off" required>
                <span id="user-availability-status1" style="font-size:12px;"></span>
              </div>
              <div class="col-md-6 col-sm-6">
                <label>Fjalëkalimi</label>
                <input type="password" name="empppassword" autocomplete="off"
                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
                  title="Të paktën një numër, nje shkronjë të madhe, të vogël dhe së paku 6 karaktere" required>
              </div>
              <div class="col-md-6 col-sm-6">
                <label>Emri kompanisë</label>
                <input type="text" name="companyname" autocomplete="off" required>
              </div>
              <div class="col-md-6 col-sm-6">
                <label>Slogani</label>
                <input type="text" name="tagline" autocomplete="off" required>
              </div>
              <div class="col-md-12">
                <h4 style="color: #333;">Përshkrimi</h4>
                <div class="text-editor-box">
                  <textarea name="description" autocomplete="off" required></textarea>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <label>Website</label>
                <input type="url" name="website" autocomplete="off">
              </div>
              <div class="col-md-6 col-sm-12">
                <label>Logo</label>
                <div class="upload-box">
                  <div class="hold">
                    <input type="file" name="logofile" required>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="btn-col">
                  <input type="submit" name="signup" id="submit" value="Regjistrohu">
                </div>
              </div>
            </div>
          </div>
        </section>
      </form>
    </div>
    <?php include('includes/footer.php'); ?>
  </div>
  <script src="../js/jquery-1.11.3.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/jquery.velocity.min.js"></script>
  <script src="../js/jquery.kenburnsy.js"></script>
  <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="../js/editor.js"></script>
  <script src="../js/jquery.accordion.js"></script>
  <script src="../js/jquery.noconflict.js"></script>
  <script src="../js/theme-scripts.js"></script>
  <script src="../js/custom.js"></script>
  <script>
    function userAvailability() {
      $("#loaderIcon").show();
      jQuery.ajax({
        url: "check_emailavailability.php",
        data: 'email=' + $("#email").val(),
        type: "POST",
        success: function (data) {
          $("#user-availability-status1").html(data);
          $("#loaderIcon").hide();
        },
        error: function () { }
      });
    }
  </script>
</body>

</html>