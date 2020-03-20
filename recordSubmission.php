<!DOCTYPE html>
<html lang="en">
  <head>
    <title>EcoSave &mdash; Recycling System </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Oswald:400,700|Work+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">

  </head>
  <body>
  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <div class="site-wrap">
    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->

    <div class="site-navbar-wrap js-site-navbar bg-white">
      <div class="container">
        <div class="site-navbar bg-light">
          <div class="row align-items-center">
            <div class="col-2">
              <div class="mb-0 site-logo"><a href="viewSubmissionsAdmin.php"><img src="images/ecoSaveLogoSmall.png"></a></div>
            </div>
            <div class="col-10">
              <?php include_once "process.php" ?>
               <nav class="site-navigation text-right" role="navigation">
                <div class="container">
                  <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>
                  <ul class="site-menu js-clone-nav d-none d-lg-block">
                    <li><a href="#">welcome, <?php echo $userArr['username']; ?></a></li>
                    <li class="has-children">
                      <a href="#">Actions</a>
                      <ul class="dropdown arrow-top">
                        <li><a href="viewSubmissionsCollector.php">View Submissions</a></li>
                        <li class="active"><a href="recordSubmission.php">Record Submission</a></li>
                        <li><a href="manageProfileCollector.php">Manage Profile</a></li>
                        <li><a href="manageMaterial.php">Manage Material</a></li>
                        <li><a href="login.php">Log Out</a></li>
                      </ul>
                    </li>
                    <li><a href="#">EcoPoints : <?php echo $userArr['totalPoints']; ?></a></li>
                  </ul>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="slant-1"></div>

    <div class="site-section first-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12 text-center" data-aos="fade">
            <span class="caption d-block mb-2 font-secondary font-weight-bold">EcoSave</span>
            <h2 class="site-section-heading text-uppercase text-center font-secondary">Record Submissions</h2>
          </div>
        </div>

        <?php require_once 'process.php'; ?>

        <?php
          $mysqli = new mysqli('localhost','root','','secondchancedb') or die(mysqli_error($mysqli));
          $result = $mysqli->query("SELECT * FROM submission s WHERE collector_username='" . $_SESSION["current_user"] . "'") or die($mysqli->error);
        ?>
        <div class="row justify-content-center">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>RecyclerUsername</th>
                <th>MaterialID</th>
                <th>ProposedDate</th>
                <th>ActualDate</th>
                <th>WeightInKg</th>
                <th>PointsAwarded</th>
                <th>Status</th>
                <th colspan="2">Actions</th>
              </tr>
            </thead>
            <?php
              while($row = $result->fetch_assoc()):
            ?>
            <tr>
              <td><?php echo $row['recycler_username'] ?></td>
              <td><?php echo $row['materialID'] ?></td>
              <td><?php echo $row['proposedDate'] ?></td>
              <td><?php echo $row['actualDate'] ?></td>
              <td><?php echo $row['weightInKg'] ?></td>
              <td><?php echo $row['pointsAwarded'] ?></td>
              <td><?php echo $row['status'] ?></td>
              <td>
                <a href="recordSubmission.php?editSubmission=<?php echo $row['submissionID'];?>"
                  class="btn btn-info">Edit</a>
                  <a href="process.php?process=<?php echo $row['submissionID'];?>"
                    class="btn btn-dark">Process</a>
              </td>
            </tr>
          <?php endwhile; ?>
          </table>
        </div>
        <?php
        if(isset($_SESSION['message'])):
        ?>
        <div class="alert alert-<?=$_SESSION['msg_type']?>">
          <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
          ?>
        </div>
      <?php endif; ?>
        <div class="row">
          <form action="process.php" method="post">
            <input type="hidden" name="submissionID" value="<?php echo $submissionID ?>">
            <div class="row justify-content-center">
              <table class="table">
              <thead><tr>
                 <th>
              <?php
              if($update == true):
              ?>
              <input type="text" name="recycler_username" class="form-control"
              value="<?php echo $recycler_username;?>" disabled>
              <?php
              else:
              ?>
              <input type="text" name="recycler_username" class="form-control"
              value="<?php echo $recycler_username;?>" required>
              <?php
              endif;
              ?>
            </th>
            <th>

             <input type="int" name="materialID" class="form-control"
              value="<?php echo $materialID;?>" required>
            </th>
             <th>
              <input type="text" name="proposedDate" class="form-control"
              value="<?php echo $proposedDate;?>" disabled>
            </th>
            <th>

              <input type="text" name="actualDate" class="form-control"
              value="<?php echo $actualDate;?>" disabled>
            </th>
            <th>

              <input type="text" name="weightInKg" class="form-control"
              value="<?php echo $weightInKg;?>"  disabled>
            </th>
            <th>

              <input type="text" name="pointsAwarded" class="form-control"
              value="<?php echo $pointsAwarded;?>" disabled>
            </th>
            <th>
              <input type="text" name="status" class="form-control"
              value="<?php echo $status;?>" disabled>
            </th>
            <th>


            </th>
            <th>
              <?php
              if($update == true):
              ?>
              <button type="submit" class="btn btn-info" name="updateSubmission">Save changes</button>
              <?php
              else:
              ?>
              <button type="submit" class="btn btn-success" name="addSubmission">Add</button>
              <?php
              endif;
              ?>
            </th></tr>
          </table>
        </div>
          </form>
        </div>
      </div>
    </div>

    <div class="py-5 bg-primary">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6 text-center mb-3 mb-md-0">
            <h2 class="text-uppercase text-white mb-4" data-aos="fade-up">You have a better idea?</h2>
            <a href="mailto:enquiry@ecosave.com.my" class="btn btn-bg-primary font-secondary text-uppercase" data-aos="fade-up" data-aos-delay="100">Contact Us</a>
          </div>
        </div>
      </div>
    </div>




    <footer class="site-footer bg-dark">
      <div class="container">


        <div class="row">
          <div class="col-md-4 mb-4 mb-md-0">
            <h3 class="footer-heading mb-4 text-white">About</h3>
            <p>EcoSave is a recycling platform that aims to contribute towards efforts to combat climate change by encouraging community members to become collectors and recyclers for recyclable materials.</p>
            <p><a href="#" class="btn btn-primary text-white px-4">Read More</a></p>
          </div>
          <div class="col-md-5 mb-4 mb-md-0 ml-auto">
            <div class="row mb-4">
              <div class="col-md-6">
                <h3 class="footer-heading mb-4 text-white">Quick Menu</h3>
                  <ul class="list-unstyled">
                    <li><a href="viewSubmissionsCollector.php">View Submissions</a></li>
                    <li><a href="recordSubmission.php">Record Submission</a></li>
                    <li><a href="manageProfileCollector.php">Manage Profile</a></li>
                    <li><a href="manageMaterial.php">Manage Material</a></li>
                    <li><a href="login.php">Log Out</a></li>
                  </ul>
              </div>
            </div>
            <div class="row mb-5">
              <div class="col-md-12">
              <h3 class="footer-heading mb-4 text-white">Stay up to date</h3>
              <form action="#" class="d-flex footer-subscribe">
                <input type="text" class="form-control rounded-0" placeholder="Enter your email">
                <input type="submit" class="btn btn-primary rounded-0" value="Subscribe">
              </form>
            </div>
            </div>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Powered <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="#" target="_blank" >Divine</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>


          </div>

        </div>
      </div>
    </footer>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>

  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>


  </body>
</html>
