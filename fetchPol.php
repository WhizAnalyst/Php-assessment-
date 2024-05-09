<?php
session_start();
include('db.php');

header('Content-Type: application/json');

if (isset($_GET['Ward_id'])) {
    $Ward_id = $_GET['Ward_id'];

    $sql = "SELECT polling_unit_id, polling_unit_name FROM polling_unit WHERE ward_id= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Ward_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $pols = array();
    while ($row = $result->fetch_assoc()) {
        $pols[] = $row; 
    }

    echo json_encode($pols); 
} else {
    echo json_encode(array("error" => "No Ward Id provided"));
}
?>
