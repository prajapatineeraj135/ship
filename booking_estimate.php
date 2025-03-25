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
    include 'bar/nav-bar.php';
    include 'bar/side-bar.php';
    ?>
    <main>
        <!-- PHP Code to Handle Form Submission -->
        <section class="section">
            <div class="estimate_result">
                <?php
                include 'connection/api_token.php';
                include 'connection/db_connection.php';
                // Check if form is submitted
                if (isset($_POST['estimate'])) {
                    $shipet_id = $_POST['shipet_id'];
                    $consignee_name = $_POST['consignee_name'];
                    $consignee_mobile = $_POST['consignee_mobile'];
                    $consignee_address = $_POST['consignee_address'];
                    $consignee_pincode = $_POST['consignee_pincode'];
                    $consignee_city = $_POST['consignee_city'];
                    $consignee_state = $_POST['consignee_state'];
                    $parcel_type = $_POST['parcel_type'];
                    $parcel_value = $_POST['parcel_value'];
                    $parcel_contents = $_POST['parcel_contents'];
                    $parcel_weight = $_POST['parcel_weight'];
                    $parcel_length = $_POST['parcel_length'];
                    $parcel_breadth = $_POST['parcel_breadth'];
                    $parcel_height = $_POST['parcel_height'];
                    $pickup_address_id = $_POST['pickup_address_id'];
                    $parcel_volume_wieght = ($parcel_length * $parcel_breadth * $parcel_height) / 5;
                    $courier_status = 30;
                    // SQL query to insert into booked_shipments
                    $sql = "INSERT INTO booked_shipments 
(shipet_id, courier_status, consignee_name, consignee_mobile, consignee_address, consignee_pincode, 
consignee_city, consignee_state, parcel_type, parcel_value, parcel_contents, 
parcel_weight, parcel_length, parcel_breadth, parcel_height, pickup_address_id)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $stmt = $conn->prepare($sql);

                    // Check if the prepare statement was successful
                    if ($stmt === false) {
                        die('Prepare failed: ' . $conn->error);
                    }

                    // Bind the parameters to the prepared statement
                    $stmt->bind_param(
                        "ssssssssssssssss",
                        $shipet_id,
                        $courier_status,
                        $consignee_name,
                        $consignee_mobile,
                        $consignee_address,
                        $consignee_pincode,
                        $consignee_city,
                        $consignee_state,
                        $parcel_type,
                        $parcel_value,
                        $parcel_contents,
                        $parcel_weight,
                        $parcel_length,
                        $parcel_breadth,
                        $parcel_height,
                        $pickup_address_id
                    );

                    // Execute the statement
                    if ($stmt->execute()) {
                        //echo "Record inserted successfully!";
                    } else {
                        echo "Error inserting record: " . $stmt->error;
                    }
                    $stmt->close();
                    // Get consignor pincode and address
                    $sql = "SELECT pincode, nickname FROM warehouses WHERE warehouse_id = $pickup_address_id";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $consignor_pincode = $row['pincode'];
                        $pickup_address = $row['nickname'];
                    } else {
                        $consignor_pincode = 'default_pincode'; // Set an appropriate default value
                    }
                    // API URL with token
                    $apiUrl = 'https://www.icarry.in/api_get_estimate&api_token=' . $api_token;
                    // Payload data
                    $data = [
                        'length' => $parcel_length,
                        'breadth' => $parcel_breadth,
                        'height' => $parcel_height,
                        'weight' => $parcel_weight,
                        'destination_pincode' => $consignee_pincode,
                        'origin_pincode' => $consignor_pincode,
                        'destination_country_code' => 'IN',
                        'origin_country_code' => 'IN',
                        'shipment_mode' => 'S',
                        'shipment_type' => $parcel_type,
                        'shipment_value' => $parcel_value,
                    ];
                    // Initialize cURL session
                    $ch = curl_init($apiUrl);
                    // Set cURL options
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    // Execute cURL session
                    $response = curl_exec($ch);
                    // Close cURL session
                    curl_close($ch);
                    // Decode the JSON response
                    $result = json_decode($response, true);
                    function getPaymentType($parcel_type)
                    {
                        if ($parcel_type == 'P') {
                            return 'Prepaid';
                        } elseif ($parcel_type == 'C') {
                            return 'COD';
                        } else {
                            return 'Invalid Code';
                        }
                    }
                }
                // Check if $result is set and not empty
                if (isset($result)) {
                    echo '<form action="booking_save.php" method="POST" class="estimate_form">';
                    echo '<div class="estimate_result">';
                    echo '<div class="shipment detail"> <table border="1">';
                    echo '<tr><th>Name</th><th>Details</th></tr>';
                    echo '<tr><td>Shipment Id</td><td>' . $shipet_id . '</td></tr>';
                    echo '<tr><td>Name</td><td>' . $consignee_name . '</td></tr>';
                    echo '<tr><td>Mobile</td><td>' . $consignee_mobile . '</td></tr>';
                    echo '<tr><td>Address</td><td>' . $consignee_address . '</td></tr>';
                    echo '<tr><td>Pincode</td><td>' . $consignee_pincode . '</td></tr>';
                    echo '<tr><td>City</td><td>' . $consignee_city . '</td></tr>';
                    echo '<tr><td>State</td><td>' . $consignee_state . '</td></tr>';
                    echo '<tr><td>Parcel Type</td><td>' . getPaymentType($parcel_type) . '</td></tr>';
                    echo '<tr><td>Parcel Value</td><td>' . $parcel_value . '/-Rs</td></tr>';
                    echo '<tr><td>Parcel Contents</td><td>' . $parcel_contents . '</td></tr>';
                    echo '<tr><td>Parcel Length</td><td>' . $parcel_length . ' cm</td></tr>';
                    echo '<tr><td>Parcel breadth</td><td>' . $parcel_height . ' cm</td></tr>';
                    echo '<tr><td>Parcel Height</td><td>' . $parcel_height . ' cm</td></tr>';
                    echo '<tr><td>Parcle Weight</td><td>' . $parcel_weight . ' gm</td></tr>';
                    echo '<tr><td>Parcle Volume Weight</td><td>' . $parcel_volume_wieght . ' gm</td></tr>';
                    echo '<tr><td>Pickup Address</td><td>' . $pickup_address . '</td></tr>';
                    echo '</table> </div>';
                    echo '<div class="estimate_cost" <h3>Shipment Estimate Cost</h3>';
                    echo '<p>Select Any One Curier Company</p>';
                    echo '<table border="1">';
                    echo '<tr>';
                    // echo '<th>Company Code</th>';
                    echo '<th>Company Name</th>';
                    echo '<th>Category</th>';
                    echo '<th>Charges</th>';
                    echo '<th>Select</th>';
                    echo '</tr>';
                    echo '<input type="hidden" name="shipet_id" value="' . $shipet_id . '">';
                    // Check if 'estimates' key exists and it's not empty
                    if (isset($result['success']) && !empty($result['success'])) {
                        foreach ($result['estimate'] as $estimate) {
                           $courier_cost = number_format(($estimate['courier_cost'] + ($estimate['courier_cost'] * 0.20)), 2);

                            $courier_name = $estimate['courier_group_name'];
                            $courier_category = $estimate['courier_name'];
                            $courier_id = $estimate['courier_id'];
                            echo '<tr>';
                            // Radio button that passes all selected row's data when chosen
                            // echo '<td>' . $courier_id . '</td>';
                            echo '<td>' . $courier_name . '</td>';
                            echo '<td>' . $courier_category . '</td>';
                            echo '<td>' . $courier_cost . ' /- Rs</td>';
                            echo '<td><input type="radio" name="selected_courier_data" value="'
                                . $courier_id . '|'  // Courier Code
                                . $courier_name . '|'            // Company Name
                                . $courier_category . '|'                // Category
                                . $courier_cost                          // Cost
                                . '" required></td>';
                            echo '</tr>';
                        }
                    }
                    echo '</table><br>';
                    echo '<button type="submit" name="selected_courier" value="selected_courier">Select Curier</button>';
                    echo '</div></div>';
                    echo '</form> ';
                } else {
                    echo '<p class="error">Error Fetching Estimates Contact Suport Team On Call +91-9509930493.</p>';
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