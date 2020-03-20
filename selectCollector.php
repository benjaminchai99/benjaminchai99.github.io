<?php
  session_start();

  include_once 'secondChance.php';
  include_once 'sessionCheck.php';

  $sql = "SELECT * FROM user WHERE username ='" . $_SESSION["current_user"] . "'";
  $result = mysqli_query($con, $sql);
  $userArr = mysqli_fetch_array($result);
?>

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

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
      $('.schedule').click(function(){
        $('#ui-datepicker-div').css('zIndex','1060');
        });

    </script>

    <style type="text/css">
    .ui-datepicker{z-index: 99 !important};
    </style>


  </head>
  <body>
  <form action="process.php" method="post">
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
              <div class="mb-0 site-logo"><a href="viewSubmissionsCollector.php"><img src="images/ecoSaveLogoSmall.png"></a></div>
            </div>
            <div class="col-10">
              <nav class="site-navigation text-right" role="navigation">
                <div class="container">
                  <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>
                  <ul class="site-menu js-clone-nav d-none d-lg-block">
                    <li><a href="#">Welcome, <?php echo $userArr['username']; ?></a></li>
                    <li class="has-children">
                      <a href="#">Actions</a>
                      <ul class="dropdown arrow-top">
                        <li><a href="viewSubmissionsRecycler.php">View Submissions</a></li>
                        <li class="active"><a href="makeAppointment.php">Make Appointment</a></li>
                        <li><a href="manageProfileRecycler.php">Manage Profile</a></li>
                        <li><a href="login.php">Log out</a></li>
                      </ul>
                    </li>
                    <li><a href="#">EcoPoints : <?php echo $userArr['totalPoints']; ?></a></li>
                    <li><a href="#">EcoLevel : <?php echo $userArr['ecoLevel']; ?></a></li>
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
            <span class="caption d-block mb-2 font-secondary font-weight-bold">Make Appointment</span>
            <h2 class="site-section-heading text-uppercase text-center font-secondary">Step 2: Select a collector & propose a date</h2>
          </div>
        </div>

        <?php
          $mysqli = new mysqli('localhost','root','','secondchancedb') or die(mysqli_error($mysqli));
          $materialID = $_GET['select'];
          if (isset($_GET['select'])){
             $result2 = $mysqli->query("SELECT * FROM user u, collectorMaterials c WHERE u.username = c.collectorUsername AND c.materialID = $materialID") or die($mysqli->error);
          }
        ?>
        <div class="row justify-content-center">
          <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Username</th>
                          <th>Address</th>
                          <th>Working Days</th>
                          <th>StartTime</th>
                          <th>EndTime</th>
                        </tr>
                      </thead>
                      <?php
                       while($row2 = $result2->fetch_assoc()):
                      ?>
                      <tr>
                        <td><?php echo $row2['username'] ?></td>
                        <td><?php echo $row2['address'] ?></td>
                        <td><?php echo $row2['days'] ?></td>
                        <td><?php echo $row2['startTime'] ?></td>
                        <td><?php echo $row2['endTime'] ?></td>
                      </tr>
                    <?php endwhile; ?>
                    </table>
        </div>
        <br><br>
        <input type="hidden" name="materialID" value="<?php echo $materialID ?>">
        <?php $result3 = $mysqli->query("SELECT DISTINCT username FROM  user u, collectorMaterials c WHERE u.username = c.collectorUsername AND c.materialID = $materialID") or die($mysqli->error); ?>
        <div class="row">
          <div class="col no-gutters">
              <div class="leftside">
                <div class="row">
                    <h5>Select a collector:&emsp;</h5>
                      <select id="mySelect" name="mySelect" required>
                        <?php while($row3 = mysqli_fetch_array($result3)):; ?>
                            <option><?php echo $row3[0]; ?></option>
                            <?php endwhile; ?>
                        </select>
                  </div>
              </div>
          </div>
          <div class="col no-gutters">
              <div class="rightside">
                <div class="row">
                    <h5>Propose a date:&emsp;</h5>

                      <input type="date" name="day" required/>

                </div>
              </div>
          </div>
        </div>
        <br><br>
        <div class="row">
          <button type="submit" class="btn btn-success" name="makeAppointment">Make Appointment</button>&emsp;
          <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
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
                    <li><a href="viewSubmissionsRecycler.php">View Submissions</a></li>
                    <li><a href="makeAppointment.php">Make Appointment</a></li>
                    <li><a href="manageProfileRecycler.php">Manage Profile</a></li>
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
  <script>var mySelect document.getElementById("mySelect").value</script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
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

  </form>
  </body>
</html>
