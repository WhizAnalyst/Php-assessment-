<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Page with select button</title>
  <link rel="stylesheet" href="css/all.min.css" />
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font/bootstrap-icons.css">
  <script src="js/sweetalert2@10.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
    }

    h2 {
      text-align: center;
    }

    .selectOptions {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
      font-weight: bold;
    }

    select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      transition: border-color 0.3s ease-in-out;
    }

    select:focus {
      border-color: dodgerblue;
    }

    .totalNo {
      width: 100%;
      padding: 10px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .totalNo {
      animation: slideIn 0.5s forwards;
    }
  </style>
</head>

<body>
  <h2>Display all polling unit</h2>
  <div class="selectOptions">
    <label for="polling_unit">Choose your Local government:</label>
    <select name="polling_unit" id="polling_unit" name="polling_unit" class="polling_unit form-control">
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
    <input class="totalNo" readonly>
  </div>
</body>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
  var pollingUnit = document.querySelector('.polling_unit');
  var totalNo = document.querySelector('.totalNo');

  pollingUnit.addEventListener('change', function() {
    var polVal = this.value;

    fetch('fetchTotal.php?lga_id=' + polVal)
      .then((response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok.');
        }
        return response.json();
      })
      .then((result) => {
        totalNo.value = result;
      })
      .catch((error) => {
        console.error('There has been a problem with your fetch operation:', error);
      });
  });
</script>

</html>