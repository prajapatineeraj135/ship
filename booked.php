<?php 
ob_start();
?>
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
    .estimate_form button {
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
    .estimate_form button:hover {
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
    
    ob_start();
    include 'bar/nav-bar.php';
    include 'bar/side-bar.php';
    ob_end_flush();
    ?>
    <main>
        <!-- PHP Code to Handle Form Submission -->
        <section class="section">
            <div class="estimate_result">
                <?php
                // iCarry API token and URL
                include 'connection/api_token.php';
                include 'connection/db_connection.php';
                
if (isset($_GET['booked'])) {
    $shipet_id = $_GET['shipet_id'];
    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, shipet_id, courier_id, pickup_address_id, consignee_name, consignee_mobile, consignee_address, consignee_pincode, consignee_city, consignee_state, parcel_type, parcel_value, parcel_contents, parcel_weight, parcel_length, parcel_breadth, parcel_height FROM booked_shipments WHERE shipet_id = ?");
    $stmt->bind_param("s", $shipet_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Assign variables
        $courier_id = $row['courier_id'];
        $pickup_address_id = $row['pickup_address_id'];
        $consignee_name = $row['consignee_name'];
        $consignee_mobile = $row['consignee_mobile'];
        $consignee_address = $row['consignee_address'];
        $consignee_pincode = $row['consignee_pincode'];
        $consignee_city = $row['consignee_city'];
        $consignee_state = $row['consignee_state'];
        $parcel_type = $row['parcel_type'];
        $parcel_value = $row['parcel_value'];
        $parcel_contents = $row['parcel_contents'];
        $parcel_weight = $row['parcel_weight'];
        $parcel_length = $row['parcel_length'];
        $parcel_breadth = $row['parcel_breadth'];
        $parcel_height = $row['parcel_height'];
        // Ensure API token is set
        if (!isset($api_token)) {
            die("API token is missing.");
        }
        $api_url = "https://www.icarry.in/api_add_shipment_surface&api_token=$api_token";
        // Prepare shipment data
        $shipment = [
            'pickup_address_id' => $pickup_address_id,
            'courier_id' => $courier_id,
            'consignee' => [
                'name' => $consignee_name,
                'mobile' => $consignee_mobile,
                'address' => $consignee_address,
                'city' => $consignee_city,
                'pincode' => $consignee_pincode,
                'state' => $consignee_state,
                'country_code' => 'IN'
            ],
            'parcel' => [
                'type' => $parcel_type,
                'value' => $parcel_value,
                'currency' => 'INR',
                'contents' => $parcel_contents,
                'weight' => [
                    'weight' => $parcel_weight,
                    'unit' => 'gm'
                ],
                'dimensions' => [
                    'length' => $parcel_length,
                    'breadth' => $parcel_breadth,
                    'height' => $parcel_height,
                    'unit' => 'cm'
                ]
            ]
        ];
        // Initialize cURL session
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Send JSON request
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($shipment));
        // Execute cURL and get response
        $response = curl_exec($ch);
        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
            curl_close($ch);
            exit();
        }
        curl_close($ch);
        // Decode response
        $result = json_decode($response, true);
        echo '<div class="response">';
        if (isset($result['success']) && $result['success']) {
            echo "<h3>Shipment Booked Successfully!</h3>";
            $courier_status = 2;
            $courier_awb = $result['awb'];
            $shipment_id = $result['shipment_id'];
            // Update the booked shipment with AWB and shipment ID
            $update_stmt = $conn->prepare("UPDATE booked_shipments SET courier_awb = ?, shipment_id = ?, courier_status = ? WHERE shipet_id = ?");
            $update_stmt->bind_param("ssis", $courier_awb, $shipment_id, $courier_status, $shipet_id);
            if ($update_stmt->execute()) {
                header("Location: http://localhost:3000/ship/booking_confirm.php?shipet_id=$shipet_id");
                exit();
            } else {
                echo "Error updating shipment: " . $conn->error;
            }
        } else {
            echo "<p>Error: " . $result['error'] . " Please Contact Shipet™ Customer Care 9509930493</p>";
        }
        echo '</div>';
    } else {
        echo "No shipment found for the provided Shipet ID.";
    }
    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
            </div>
        </section>
        </div>
    </main>
    <footer>
        <!-- import here footer file from images/bar/footer.php -->
        <?php include 'bar/footer.php'; ?>
    </footer>
</body>
</html>
<?php 
ob_end_flush();
?>