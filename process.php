<?php

session_start();

$mysqli = new mysqli('localhost','root','','secondchancedb') or die(mysqli_error($mysqli));

include_once 'sessionCheck.php';

$sql = "SELECT * FROM user WHERE username ='" . $_SESSION["current_user"] . "'";
$result = mysqli_query($mysqli, $sql);
$userArr = mysqli_fetch_array($result);

$materialName = '';
$materialType = '';
$description = '';
$pointsPerKg = '';

$update = false;
$materialID = null;


if (isset($_POST['add'])){
  $materialType = $_POST['materialType'];
  $description = $_POST['description'];
  $pointsPerKg= $_POST['pointsPerKg'];
  $admin_username = 'admin01';

  $materialName = mysqli_real_escape_string($mysqli, $_POST['materialName']);
  $check_duplicate = "SELECT materialName FROM material WHERE materialName = '$materialName'";
  $result = mysqli_query($mysqli, $check_duplicate);
  $count = mysqli_num_rows($result);

  if($count > 0){
    $_SESSION['message'] = "Material name already exists.";
    $_SESSION['msg_type'] = "danger";
    header("location: maintainMaterial.php");
  }
  else{
      if($pointsPerKg<1){
        $_SESSION['message'] = "Points Per Kg cannot be negative or 0.";
        $_SESSION['msg_type'] = "danger";
        header("location: maintainMaterial.php");
      }
      else{
        $mysqli->query("INSERT INTO material(materialName,materialType,description,pointsPerKg,admin_username) VALUES ('$materialName', '$materialType','$description','$pointsPerKg','$admin_username')") or
              die($mysqli->error);

          $_SESSION['message'] = "Material has been added successfully.";
          $_SESSION['msg_type'] = "success";
          header("location: maintainMaterial.php");
      }
    }
}

if (isset($_GET['delete'])){
  $materialID = $_GET['delete'];
  $mysqli->query("DELETE FROM submission WHERE materialID = '$materialID'") or die($mysqli->error);
  $mysqli->query("DELETE FROM material WHERE materialID = '$materialID'") or die($mysqli->error);
  $mysqli->query("DELETE FROM collectorMaterials WHERE materialID = '$materialID'") or die($mysqli->error);
  $_SESSION['message'] = "Material has been deleted successfully.";
  $_SESSION['msg_type'] = "success";

  header("location: maintainMaterial.php");
}

if (isset($_GET['edit'])){
  $materialID = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM material WHERE materialID = '$materialID'") or die($mysqli->error);
  if(count($result)==1){
    $row = $result->fetch_array();
    $materialName = $row['materialName'];
    $materialType = $row['materialType'];
    $description = $row['description'];
    $pointsPerKg = $row['pointsPerKg'];
  }
}

if (isset($_POST['update'])){
  $materialID = $_POST['materialID'];
  $materialType = $_POST['materialType'];
  $description = $_POST['description'];
  $pointsPerKg = $_POST['pointsPerKg'];

  if($pointsPerKg<1){
    $_SESSION['message'] = "Points Per Kg cannot be negative or 0.";
    $_SESSION['msg_type'] = "danger";
    header("location: maintainMaterial.php");
  }
  else{
    $mysqli->query("UPDATE material SET materialType='$materialType',description='$description',pointsPerKg='$pointsPerKg' WHERE materialID='$materialID'") or
          die($mysqli->error);

    $_SESSION['message'] = "Material has been updated successfully.";
    $_SESSION['msg_type'] = "success";

    header("location: maintainMaterial.php");
  }

}
$materialID1 = 0;

if (isset($_POST['makeAppointment'])){
  $proposedDate = $_POST['day'];
  $status = 'Proposed';
  $collector_username = $_POST['mySelect'];
  $recycler_username= $_SESSION["current_user"];
  $materialID1 = $_POST['materialID'];

   $mysqli->query("INSERT INTO submission(proposedDate,status,collector_username,recycler_username,materialID) VALUES ('$proposedDate', '$status','$collector_username','$recycler_username','$materialID1')") or
              die($mysqli->error);
  header("location: viewSubmissionsRecycler.php");
}

if (isset($_POST['cancel'])){
  header("location: makeAppointment.php");
}

$recycler_username = "";
$proposedDate = "";
$status = "";
$actualDate = null;
$weightInKg = null;
$pointsAwarded = null;

$materialID2 = null;

if (isset($_POST['addSubmission'])){
  $recycler_username = $_POST['recycler_username'];
  $materialID2 = $_POST['materialID'];
  $status = "Submitted";
  $collector_username = $_SESSION["current_user"];

  $check_duplicate = "SELECT materialID FROM material WHERE materialID = '$materialID2'";
  $result = mysqli_query($mysqli, $check_duplicate);
  $count = mysqli_num_rows($result);

  if($count = 1){
    $mysqli->query("INSERT INTO submission(status,collector_username,recycler_username,materialID) VALUES ('$status','$collector_username','$recycler_username','$materialID2')") or
              die($mysqli->error);

          $_SESSION['message'] = "Submission has been added successfully.";
          $_SESSION['msg_type'] = "success";

      }
  else{
    $_SESSION['message'] = "Material does not exists.";
    $_SESSION['msg_type'] = "danger";
    header("location: recordSubmission.php");
  }
}

$submissionID = 0;
$proposedDate = "";

if (isset($_GET['editSubmission'])){
  $submissionID = $_GET['editSubmission'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM submission s, material m WHERE s.materialID=m.materialID AND submissionID = '$submissionID'") or die($mysqli->error);

    $row = $result->fetch_array();
    $recycler_username = $row['recycler_username'];
    $materialName = $row['materialName'];
    $proposedDate = $row['proposedDate'];
    $actualDate = $row['actualDate'];
    $weightInKg = $row['weightInKg'];
    $pointsAwarded = $row['pointsAwarded'];
    $status = $row['status'];
}


?>
