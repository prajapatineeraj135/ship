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
    <title>Home</title>
</head>
<style>
    .estimate_result {
        width: 100%;
        display: flex;
        flex-direction: row;
        gap: 40px;
    }
    table {
        margin: 0 auto;
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
    table tr:nth-child(odd) {
        background-color: rgb(225, 225, 225);
    }
    table td {
        font-size: small;
        color: #333;
    }
    .booked_form button {
        width: 200px;
        padding: 10px;
        margin: 10px 0;
        background-color: rgb(9, 97, 151);
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        font-weight: bold;
        align-self: center;
    }
    .booked_form button:hover {
        background-color: rgb(111, 200, 255);
        color: rgb(2, 79, 127);
        ;
    }
    @media(max-width: 768px) {
        .estimate_result {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }
        table th,
        table td {
            font-size: 11px;
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
        <?php
        // iCarry API token and URL
        include 'connection/api_token.php';
        include 'connection/db_connection.php';
        include 'functions/courier.php';


        if (isset($_GET['shipet_id'])) {
            $shipet_id = $_GET['shipet_id'];
        
            // SQL query to select the data from booked_shipments
            $sql = "SELECT
                id, shipet_id, shipment_id, courier_status, courier_name, courier_cost, pickup_address_id, consignee_name, consignee_mobile, consignee_address, consignee_pincode, consignee_city, consignee_state, parcel_type, parcel_value, parcel_contents, parcel_weight, parcel_length, parcel_breadth, parcel_height 
            FROM booked_shipments WHERE shipet_id = '$shipet_id'";
            
            $result = $conn->query($sql);
        
            // Check if there are results
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $courier_status = $row['courier_status'];
                $status_name = getCourierStatusName($courier_status);
        
                // Check if courier_status is 30, proceed with processing
                if ($courier_status == 30) {
                    // Output data for processing shipment
                    // Calculate the parcel volume weight (L x B x H / 5000 for dimensional weight in grams)
                    $parcel_volume_weight = ($row['parcel_length'] * $row['parcel_breadth'] * $row['parcel_height']) / 5;
                    $parcel_type = $row['parcel_type'];
        
                    // Output the shipment details in a table
                    echo '<div class="estimate_result">';
                    echo '<div class="shipment_detail"><table border="1">';
                    echo '<tr><th>Shipetment status</th><td><strong>' . $status_name. '</strong></td></tr>';
                    echo '<tr><th>Shipet Id</th><td><strong>' . $row['shipet_id'] . '</strong></td></tr>';
                    echo '<tr><th>Name</th><td>' . $row['consignee_name'] . '</td></tr>';
                    echo '<tr><th>Mobile</th><td>' . $row['consignee_mobile'] . '</td></tr>';
                    echo '<tr><th>Address</th><td>' . $row['consignee_address'] . '</td></tr>';
                    echo '<tr><th>Pincode</th><td>' . $row['consignee_pincode'] . '</td></tr>';
                    echo '<tr><th>City</th><td>' . $row['consignee_city'] . '</td></tr>';
                    echo '<tr><th>State</th><td>' . $row['consignee_state'] . '</td></tr>';
                    echo '<tr><th>Parcel Type</th><td>' . getPaymentType($row['parcel_type']) . '</td></tr>';
                    echo '<tr><th>Parcel Value</th><td>' . $row['parcel_value'] . '/-Rs</td></tr>';
                    echo '<tr><th>Parcel Contents</th><td>' . $row['parcel_contents'] . '</td></tr>';
                    echo '<tr><th>Parcel Length</th><td>' . $row['parcel_length'] . ' cm</td></tr>';
                    echo '<tr><th>Parcel Breadth</th><td>' . $row['parcel_breadth'] . ' cm</td></tr>';
                    echo '<tr><th>Parcel Height</th><td>' . $row['parcel_height'] . ' cm</td></tr>';
                    echo '<tr><th>Parcel Weight</th><td>' . $row['parcel_weight'] . ' gm</td></tr>';
                    echo '<tr><th>Volume Weight</th><td>' . $parcel_volume_weight . ' gm</td></tr>';
                    echo '<tr><th>Pickup Address</th><td>' . $row['pickup_address_id'] . '</td></tr>';
                    echo '<tr><th>Courier Name</th><td>' . $row['courier_name'] . '</td></tr>';
                    echo '<tr><th>Courier Cost</th><td>' . $row['courier_cost'] . '/-Rs</td></tr>';
                    echo '<tr><td colspan=2>';
                    echo '<form action="booked.php" method="GET" class="booked_form" id="booked_Form">';
                    echo '<input type="hidden" name="shipet_id" value="' . $shipet_id . '">';
                    echo '<button type="submit" name="booked" value="booked">Book Now</button>';
                    echo '</form></td></tr>';
                    echo '</table></div>';
                    echo '</div>';
                } else {
                    // If the courier_status is not 30, output a message
                    echo "This courier is Booked Now Current Status: " . $status_name;
                }
            } else {
                // If no result found, print an error message
                echo "No shipment found for Shipet ID: " . $shipet_id;
            }
        }
        
        
                
        $conn->close();
        ?>
        </div>
    </main>
    <footer>
        <!-- import here footer file from images/bar/footer.php -->
        <?php include 'bar/footer.php'; ?>
    </footer>
</body>
</html>