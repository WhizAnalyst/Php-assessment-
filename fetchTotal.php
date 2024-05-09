<?php
session_start();
include('db.php');
if(isset($_GET['lga_id'])) {
  $lga_id = $_GET['lga_id'];

  $sql = "SELECT COUNT(*) as total FROM polling_unit WHERE lga_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $lga_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  echo $row['total'];
}
?>
