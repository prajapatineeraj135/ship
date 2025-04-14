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
    .section {
        margin: 10px;
    }

    .estimate_section {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 500px;
        padding: 20px;
        background-color: hsl(200, 100.00%, 85%);
        border-radius: 20px;
    }

    .estimate_section h1 {
        text-align: center;
        margin-bottom: 10px;
    }

    .estimate_form {
        display: flex;
        flex-direction: column;
        width: 100%;
        padding: 10px;
        border: 2px solid black;
        border-radius: 20px;
    }

    .estimate_input {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        padding: 10px;
    }

    .estimate_input label {
        margin-bottom: 5px;
    }

    .estimate_input input {
        padding: 4px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid;
    }

    .input_radio {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .col {
        padding: 10px;
        display: flex;
        flex-direction: column;
    }

    .estimate_btn {
        width: 100%;
        text-align: center;
    }

    .btn {
        background-color: hsl(50, 100.00%, 50%);
        padding: 10px 20px;
        border: none;
        font-size: medium;
        border-radius: 5px;
        transition-duration: 0.3s;
    }

    .btn:hover {
        background-color: green;
        /* Green */
        color: white;
    }

    @media (max-width:768px) {
        .estimate_section {
            width: 100%;
        }

        .estimate_section h1 {
            font-size: larger;
        }

        .estimate_input {
            grid-template-columns: repeat(1, 1fr);
        }

        .estimate_input label {
            font-size: small;

        }

        .estimate_input input,
        label {
            margin-bottom: 5px;
        }

        .input_radio {
            justify-content: start;
            gap: 10px;
        }
    }

    .estimate_result {
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    .result {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .result h3,
    h5 {
        margin: 5px;
        text-align: left;
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

    @media(max-width: 768px) {
        .result {
            width: 100%;
        }

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
        <section class="section">
            <div class="estimate_result">
                <?php
                include 'connection/api_token.php';
                // Check if form is submitted
                if (isset($_GET['estimate'])) {
                    // Assign POST variables to local variablesS
                    $length = $_GET['length'];
                    $breadth = $_GET['breadth'];
                    $height = $_GET['height'];
                    $weight = $_GET['weight'];
                    $destination_pincode = $_GET['destination_pincode'];
                    $origin_pincode = $_GET['origin_pincode'];
                    $shipment_type = $_GET['shipment_type'];
                    $shipment_value = $_GET['shipment_value'];
                    $volweight = ($length * $breadth * $height * 1000) / 5000;
                    // API URL with token
                    $apiUrl = 'https://www.icarry.in/api_get_estimate&api_token=' . $api_token;
                    // Payload data
                    $data = [
                        'length' => $length,
                        'breadth' => $breadth,
                        'height' => $height,
                        'weight' => $weight,
                        'destination_pincode' => $destination_pincode,
                        'origin_pincode' => $origin_pincode,
                        'destination_country_code' => 'IN',
                        'origin_country_code' => 'IN',
                        'shipment_mode' => 'S',
                        'shipment_type' => $shipment_type,
                        'shipment_value' => $shipment_value,
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
                }
                // Check if $result is set and not empty
                if (isset($result)) {
                    // Display tracking information
                    echo '<div class="result">';
                    echo '<h3> Shipment Estimate Cost</h3>';
                    echo '<h5>From ' . $origin_pincode . ' To ' . $destination_pincode . '</h5>';
                    echo '<h5>Weight: ' . $weight . 'Gm</h5>';
                    echo '<h5>Volumetric Weight: ' . $volweight . 'Gm</h5>';
                    echo '<h5>L-B-H: ' . $length . 'x' . $breadth . 'x' . $height . 'Cm</h5>';
                    echo '<table border="1">';
                    echo '<tr>';
                    echo '<th>Company</th>';
                    echo '<th>Cetegory</th>';
                    echo '<th>Charges</th>';
                    // Add more table headers as needed
                    echo '</tr>';
                    // Check if 'estimates' key exists and it's not empty
                    if (isset($result['success']) && !empty($result['success'])) {

                        foreach ($result['estimate'] as $estimate) {
                            // Check if the courier_cost is numeric, if not, set it to 0
                            if (is_numeric($estimate['courier_cost'])) {
                                // Cast the courier_cost to float and add 20% to it
                                $courier_cost_value = (float)$estimate['courier_cost'] + ($estimate['courier_cost'] * 0.20);
                            } else {
                                // If it's not numeric, assign a default value of 0
                                $courier_cost_value = 0;
                            }
                        
                            // Display the results
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($estimate['courier_group_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($estimate['courier_name']) . '</td>';
                            echo '<td>' . number_format($courier_cost_value, 2) . '</td>'; // Format with 2 decimal places
                            echo '</tr>';
                        }
                        echo '</table>';
                        echo '</div>';
                    }
                } else {
                    //echo '<p class="error">Enter Estimaste Input Details Details</p>';
                }
                ?>
            </div>
            <button class="btn success"><a href="estimate.php">Get More Shipment Rates</a></button>
        </section>
    </main>
    <footer>
        <!-- import here footer file from images/bar/footer.php -->
        <?php include 'bar/footer.php'; ?>
    </footer>
</body>

</html>