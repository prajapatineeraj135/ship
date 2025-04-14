<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="shortcut icon" href="images/favicon_io/favicon.ico" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
  <title>Shipet-Tracking</title>
</head>
<style>




 
  .track_section {
    padding: 10px;
    margin: 20px;
    min-width: fit-content;
    justify-content: center;
    align-items: center;
    grid-area: main;
    display: flex;
    flex-direction: column;
    background-color: rgb(141, 194, 255);
    border-radius: 30px 5px;
    border: 1px solid;
  }

  .track_section>img {
    mix-blend-mode: multiply;
    transform: scalex(-1);
    width: 75px;
    height: 75px;
  }

  .track_section>form {
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .track_section>form>input {
    padding: 15px;
    width: 250px;
    height: 20px;
    margin-bottom: 10px;
    border-radius: 5px;
    text-align: center;
    border: 2px solid;
  }

  .track_section>form>input::placeholder {
    font-weight: bold;
    font-size: small
  }

  .track_section>form>button {
    width: fit-content;
    padding: 5px 20px;
    background-color: rgb(250, 250, 150);
    border: 1px solid;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    font-size: medium;
    box-shadow: 5px 5px 5px rgb(0, 0, 0);
  }


  .tracking_section {
    max-width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin: 0 auto;
    background-color: rgb(255, 255, 255);
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .tracking-info {
    text-align: center;
    width: 100%;
  }

  .tracking-info>img {
    width: 100px;

  }

  .tracking-info h3,
  .tracking-info h4 {
    color: #333;
    margin-bottom: 15px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin: 10px 0;
  }

  table th,
  table td {
    padding: 5px;
    text-align: left;
    border: 1px solid #ddd;
    font-size: smaller;
  }

  table th {
    font-weight: bold;
    background-color: hsl(200, 100%, 75%);
    /* Bright blue for header */
    color: hsla(0, 0%, 0%, 0.75);
  }

  table tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  table th:nth-child(1) {
    width: 18%;
  }


  table td {
    font-size: small;
    color: #333;
  }

  @media(max-width: 768px) {
    table th,
  table td {
    font-size: 12px;
  }



  }
</style>

<body>
  <!-- import nav-bar and side-bar from images/bar folder -->
  <?php
  include 'bar/nav-bar.php';
  include 'bar/side-bar.php';
  ?>
  <main>
    <div class="section">
      <div class="track_section">
        <img src="images/gif/track.gif" alt="" class="truck">
        <h3>Track Shipment </h3>
        <form action="" method="GET">
          <input type="text" name="shipet_id" id="shipet_id" pattern="[0-9]+" placeholder="Enter Shipment" maxlength="6" required>
          <button type="submit" name="track" value="track">Track Now</button>
        </form>
      </div>
    </div>
    <div class="section">
      <div class="tracking_section">
        <?php
        include 'connection/db_connection.php';
        include("connection/api_token.php"); // Assuming api_token.php contains the variable $apiToken
        if (isset($_GET['track'])) {
          // Check if user input is provided
          if (empty($_GET['shipet_id'])) {
            echo "Please enter a valid Shipment ID.";
            exit;
          }
          // Get the shipment ID from user input
          $userShipmentId = $_GET['shipet_id'];
          // Prepare the SQL query to get the tracking ID based on the shipment ID
          $stmt = $conn->prepare("SELECT shipment_id FROM booked_shipments WHERE shipet_id = ?");
          if ($stmt) {
            // Bind the parameter (shipment_id)
            $stmt->bind_param("s", $userShipmentId);
            // Execute the statement
            if ($stmt->execute()) {
              // Fetch the result
              $result = $stmt->get_result();
              // Check if the shipment exists
              if ($result->num_rows > 0) {
                // Fetch the shipment details
                $row = $result->fetch_assoc();
                $userTracking = $row['shipment_id'];
              } else {
                echo "No shipment found with ID: " . htmlspecialchars($userShipmentId);
                exit;
              }
            } else {
              echo "Error executing query: " . $stmt->error;
              exit;
            }
            // Close the statement
            $stmt->close();
          } else {
            echo "Error preparing query: " . $conn->error;
            exit;
          }
          // Prepare to send data to the external tracking API
          $apiUrl = 'https://www.icarry.in/api_track_shipment?api_token=' . $api_token;
          $payload = ['shipment_id' => $userTracking];
          // Initialize cURL session
          $ch = curl_init($apiUrl);
          // Set cURL options
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
          // Execute cURL session
          $response = curl_exec($ch);
          // Check for cURL errors
          if ($response === false) {
            echo 'cURL error: ' . curl_error($ch);
            curl_close($ch);
            exit;
          }
          // Close the cURL session
          curl_close($ch);
          // Decode the API response
          $result = json_decode($response, true);
          // Check if the response is valid JSON
          if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Invalid JSON response from the API.";
            exit;
          }
        }
        ?>
        <!-- Display tracking information -->
        <?php
        if (isset($result)) {
          if ($result && isset($result['success']) && $result['success']) {
            // Display tracking information in a customer-friendly format
            echo '<div class="tracking-info">';
            echo '<img src="images/gif/track_info.gif" alt="" class="truck">'; // Sanitize output
            echo '<h3>Shipment ID: ' . htmlspecialchars($userShipmentId) . '</h3>';
            echo '<h4>Status: ' . htmlspecialchars($result['status']) . '</h4>';
            echo '<table class="table" border="1">';
            echo '<tr>';
            echo '<th>Date</th>';
            echo '<th>Time</th>';
            echo '<th>Location</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            // Display the tracking details
            if (isset($result['details']) && !empty($result['details'])) {
              foreach ($result['details'] as $detail) {
                // Convert the datetime string to a DateTime object
                $datetime = new DateTime($detail['datetime']);

                // Extract the date and time separately
                $date = $datetime->format('d-M');
                $time = $datetime->format('H:i');

                // Extract and format the location string
                $location = str_replace('_', ' ', $detail['location']); // Replace underscores with spaces

                // Split the location into parts
                preg_match('/^(\w+\s\w+).*?(\(.*?\))$/', $location, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                  // First two words and part inside parentheses
                  $formattedLocation = $matches[1] . ' ' . $matches[2];
                } else {
                  // Fallback to the full location if pattern doesn't match
                  $formattedLocation = $location;
                }

                echo '<tr>';
                echo '<td>' . htmlspecialchars($date) . '</td>';
                echo '<td>' . htmlspecialchars($time) . '</td>';
                echo '<td>' . htmlspecialchars($formattedLocation) . '</td>'; // Display formatted location
                echo '<td>' . htmlspecialchars($detail['notes']) . '</td>';
                echo '</tr>';
              }
              

               } else {
              echo '<tr><td colspan="3">No tracking details available.</td></tr>';
            }
            echo '</table>';
            echo '</div>';
          } else {
            // Display an error message if the tracking information is incorrect
            echo '<p>This shipment is under process or not found.</p>';
          }
        }
        ?>
      </div>
    </div>
  </main>
  <!-- import here footer file from images/bar/footer.php -->
  <footer>
    <?php include 'bar/footer.php'; ?>
  </footer>
</body>

</html>