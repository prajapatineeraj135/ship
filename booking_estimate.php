<?php
session_start();
include('../auth/connection.php');
include('../auth/api_token.php');
include('../assets/notification.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/account.php?section=login");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['shipment_id'])) {
    $shipment_id = intval($_GET['shipment_id']);

    $sql = "SELECT * FROM shipments WHERE shipment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $shipment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $shipment = $result->fetch_assoc();

        $pickup_address_id   = $shipment['pickup_address_id'];
        $consignee_name      = $shipment['consignee_name'];
        $consignee_mobile    = $shipment['consignee_mobile'];
        $consignee_address   = $shipment['consignee_address'];
        $consignee_pincode   = $shipment['consignee_pincode'];
        $parcel_type         = $shipment['parcel_type'];
        $parcel_value        = $shipment['parcel_value'];
        $parcel_contents     = $shipment['parcel_contents_description'];
        $length              = $shipment['length'];
        $breadth             = $shipment['breadth'];
        $height              = $shipment['height'];
        $weight              = $shipment['weight'];
        $parcel_volume_weight = ($length * $breadth * $height) / 5000;

        // Fetch consignor pincode and nickname
        $sql = "SELECT pincode, nickname FROM pickup_address WHERE warehouse_id = ?";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("i", $pickup_address_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2 && $result2->num_rows > 0) {
            $row = $result2->fetch_assoc();
            $consignor_pincode = $row['pincode'];
            $pickup_address = $row['nickname'];
        } else {
            $consignor_pincode = '000000';
            $pickup_address = 'Unknown';
        }

        // Call iCarry API
        $apiUrl = 'https://www.icarry.in/api_get_estimate?api_token=' . $apiToken;

        $data = [
            'length' => $length,
            'breadth' => $breadth,
            'height' => $height,
            'weight' => $weight,
            'destination_pincode' => $consignee_pincode,
            'origin_pincode' => $consignor_pincode,
            'destination_country_code' => 'IN',
            'origin_country_code' => 'IN',
            'shipment_mode' => 'S',
            'shipment_type' => $parcel_type,
            'shipment_value' => $parcel_value,
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);

        if ($response === false) {
            echo '<p class="error">cURL Error: ' . curl_error($ch) . '</p>';
            exit();
        }

        curl_close($ch);
        $result = json_decode($response, true);

        // Uncomment for debugging API response
        // echo '<pre>'; print_r($result); echo '</pre>';

        function getPaymentType($parcel_type) {
            return $parcel_type === 'P' ? 'Prepaid' : ($parcel_type === 'C' ? 'COD' : 'Unknown');
        }

        echo '<form action="booking_save.php" method="POST" class="estimate_form">';
        echo '<div class="estimate_result">';

        echo '<div class="shipment detail">';
        echo '<table border="1">';
        echo '<tr><th>Name</th><th>Details</th></tr>';
        echo '<tr><td>Shipment Id</td><td>' . htmlspecialchars($shipment_id) . '</td></tr>';
        echo '<tr><td>Name</td><td>' . htmlspecialchars($consignee_name) . '</td></tr>';
        echo '<tr><td>Mobile</td><td>' . htmlspecialchars($consignee_mobile) . '</td></tr>';
        echo '<tr><td>Address</td><td>' . htmlspecialchars($consignee_address) . '</td></tr>';
        echo '<tr><td>Pincode</td><td>' . htmlspecialchars($consignee_pincode) . '</td></tr>';
        echo '<tr><td>Parcel Type</td><td>' . getPaymentType($parcel_type) . '</td></tr>';
        echo '<tr><td>Parcel Value</td><td>' . htmlspecialchars($parcel_value) . ' /- Rs</td></tr>';
        echo '<tr><td>Parcel Contents</td><td>' . htmlspecialchars($parcel_contents) . '</td></tr>';
        echo '<tr><td>Parcel Length</td><td>' . htmlspecialchars($length) . ' cm</td></tr>';
        echo '<tr><td>Parcel Breadth</td><td>' . htmlspecialchars($breadth) . ' cm</td></tr>';
        echo '<tr><td>Parcel Height</td><td>' . htmlspecialchars($height) . ' cm</td></tr>';
        echo '<tr><td>Parcel Weight</td><td>' . htmlspecialchars($weight) . ' Kg</td></tr>';
        echo '<tr><td>Volume Weight</td><td>' . htmlspecialchars($parcel_volume_weight) . ' Kg</td></tr>';
        echo '<tr><td>Pickup Address</td><td>' . htmlspecialchars($pickup_address) . '</td></tr>';
        echo '</table>';
        echo '</div>';

        echo '<div class="estimate_cost"><h3>Shipment Estimate Cost</h3>';
        echo '<p>Select Any One Courier Company</p>';
        echo '<table border="1">';
        echo '<tr><th>Company Name</th><th>Category</th><th>Charges</th><th>Select</th></tr>';

        echo '<input type="hidden" name="shipet_id" value="' . htmlspecialchars($shipment_id) . '">';

        if (isset($result['estimate']) && is_array($result['estimate']) && count($result['estimate']) > 0) {
            foreach ($result['estimate'] as $estimate) {
                $courier_cost = number_format(($estimate['courier_cost'] * 1.20), 2);
                echo '<tr>';
                echo '<td>' . htmlspecialchars($estimate['courier_group_name']) . '</td>';
                echo '<td>' . htmlspecialchars($estimate['courier_name']) . '</td>';
                echo '<td>' . $courier_cost . ' /- Rs</td>';
                echo '<td><input type="radio" name="selected_courier_data" value="'
                    . htmlspecialchars($estimate['courier_id']) . '|'
                    . htmlspecialchars($estimate['courier_group_name']) . '|'
                    . htmlspecialchars($estimate['courier_name']) . '|'
                    . $courier_cost . '" required></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4" style="text-align:center;color:red;">No courier estimates available. Please check shipment details or try again later.</td></tr>';
        }

        echo '</table><br>';
        echo '<button type="submit" name="selected_courier" value="selected_courier">Select Courier</button>';
        echo '</div></div>';
        echo '</form>';

    } else {
        echo '<p class="error">Shipment not found.</p>';
    }
} else {
    echo '<p class="error">No shipment ID provided.</p>';
}
?>
