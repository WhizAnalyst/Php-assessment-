<?php
session_start();
include('db.php');
$ip_address = getenv("REMOTE_ADDR")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Store Polling Unit Results</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/sweetalert2@10.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
</head>

<body>
    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
    <div class="container">
        <h1>Enter New Polling Unit Results</h1>
        <form id="pollingForm">
            <div class="form-group">
                <label for="lga_id">LGA :</label>
                <select id="lga_id" name="lga_id" required>
                    <option value="">Select</option>
                    <?php
                    $sql = "SELECT lga_id, lga_name FROM lga";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["lga_id"] . "'>" . $row["lga_name"] . "</option>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ward_id">Ward:</label>
                <select id="ward_id" name="ward_id" required>
                    <option value="">Select</option>
                </select>
            </div>

            <div class="form-group">
                <label for="polling_unit_id">Polling Unit</label>
                <select id="polling_unit_id" name="polling_unit_id" required>
                    <option value="">Select</option>
                </select>
            </div>

            <div class="form-group">
                <label for="enetered_by_user">User name:</label>
                <input type="text" id="enetered_by_user" name="enetered_by_user" required>
            </div>

            <div class="form-group">
                <label for="party">Party:</label>
                <select id="party" name="party">
                    <option value="">Select</option>
                </select>
            </div>

            <div class="form-group">
                <label for="votes">Votes:</label>
                <input type="number" id="votes" name="votes" required>
            </div>

            <input type="submit" class="submit" value="Submit">
        </form>
    </div>
</body>
<script>
    var Submit = document.querySelector('.submit');
    var ip_address = '<?php echo $ip_address; ?>';
    var lgaid = document.getElementById('lga_id');
    var wardDropdown = document.getElementById('ward_id');
    var PolName = document.getElementById('polling_unit_id');

    lgaid.addEventListener('change', function() {
        var lga_id = this.value;
        wardDropdown.innerHTML = '<option value="">Select</option>';

        if (lga_id) {
            fetch('fetchWard.php?lga_id=' + lga_id)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok.');
                    }
                    return response.json();
                })
                .then((result) => {
                    result.forEach(function(ward) {
                        wardDropdown.innerHTML += '<option value="' + ward.ward_id + '">' + ward.ward_name + '</option>';
                    });
                })
                .catch((error) => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        }
    });
    wardDropdown.addEventListener('change', function() {
        var Ward_id = this.value;
        PolName.innerHTML = '<option value="">Select</option>';

        if (Ward_id) {
            fetch('fetchPol.php?Ward_id=' + Ward_id)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok.');
                    }
                    return response.json();
                })
                .then((result) => {
                    result.forEach(function(Pol) {
                        PolName.innerHTML += '<option value="' + Pol.polling_unit_id + '">' + Pol.polling_unit_name + '</option>';
                    });
                })
                .catch((error) => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        }
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showLocation);
    } else {
        console.log('Geolacation is not supported by this browser.');
    }

    function showLocation(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
    }
    Submit.addEventListener('click', function() {
        var lga_id = document.getElementById('lga_id').value;
        var ward_id = document.getElementById('ward_id').value;
        var poll_id = document.getElementById('polling_unit_id').value;
        var votes = document.getElementById('votes').value;
        var UserName = document.getElementById('enetered_by_user').value;
        var party = document.getElementById('party').value;


        console.log(party, votes, poll_id, UserName);
        if (party != "" && votes != "" && poll_id != "" && UserName != "") {
            $.ajax({
                url: "SubmitPollDetails.php",
                type: "POST",
                async: false,
                data: {
                    "Submit": 1,
                    "party": party,
                    "votes": votes,
                    "poll_id": poll_id,
                    "UserName": UserName,
                    "ip_address": ip_address,
                },
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.status === "success") {
                        alert("Registration Successful: " + response.message);
                    } else {
                        alert("Issue: " + response.message);
                    }
                }

            });
        } else {
            alert("Field Missing");
        }
    })
</script>

</html>