<?php
include('db.php');

if (isset($_POST['Submit'])) {
    $sql = "SELECT MAX(result_id) as max_id FROM announced_pu_results";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $lastUniqueId = $row['max_id'];
    $UniqueId = $lastUniqueId + 1;

    $polling_unit_no = 'DT' . time() . rand(1000, 9999);

    $RegDate = date("M-d-Y");
    $party = $_POST['party'];
    $votes = $_POST['votes'];
    $poll_id = $_POST['poll_id'];
    $UserName = $_POST['UserName'];
    $ip_address = $_POST['ip_address'];

    $insertSql = "INSERT INTO announced_pu_results (result_id, polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered, user_ip_address) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("issssss", $UniqueId, $poll_id, $party, $votes, $UserName, $RegDate, $ip_address);

    $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = array("status" => "success", "message" => "New polling unit record created successfully.");
        } else {
            $response = array("status" => "error", "message" => $stmt->error);
        }
    
        $stmt->close();
    
        echo json_encode($response);
    }

$conn->close();
