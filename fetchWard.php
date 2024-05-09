<?php
session_start();
include('db.php');

header('Content-Type: application/json');

if (isset($_GET['lga_id'])) {
    $lga_id = $_GET['lga_id'];

    $sql = "SELECT ward_id, ward_name FROM ward WHERE lga_id= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lga_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $wards = array();
    while ($row = $result->fetch_assoc()) {
        $wards[] = $row; 
    }

    echo json_encode($wards); 
} else {
    echo json_encode(array("error" => "No LGA ID provided"));
}
?>
