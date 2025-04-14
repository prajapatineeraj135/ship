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
    .booking_form {
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
    }

    .booking_form h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2em;
    }

    .form label {
        display: block;
        margin-bottom: 5px;
    }

    .form input,
    .form textarea,
    .form select {
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .dimensions {
        display: flex;
        flex-direction: row;
    }

    .form button {
        width: 200px;
        padding: 10px;
        margin: 20px 0;
        background-color: rgb(9, 97, 151);
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        font-weight: bold;
        align-self: center;
    }

    .form button:hover {
        background-color: rgb(111, 200, 255);
        color: rgb(2, 79, 127);
        ;
    }

    .response {
        margin-top: 20px;
    }

    .form {
        display: flex;
        flex-direction: column;
    }

    .col2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .col {
        display: flex;
        flex-direction: column;
    }

    @media (max-width: 768px) {

        .booking_form,
        .form_container {
            padding: 5px;
        }

        .booking_form h1 {
            font-size: 1.5em;
        }

        .form input,
        label,
        select {
            font-size: small;
        }

        .col2 {
            grid-template-columns: repeat(1, 1fr);
            gap: 0;
        }

        .dimensions {
            display: flex;
            flex-direction: column;
            justify-content: left;
            align-content: center;
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
        include 'connection/db_connection.php';
        include("connection/api_token.php");
        $sql = "SELECT shipet_id FROM booked_shipments ORDER BY shipet_id DESC LIMIT 1";
        $result = $conn->query($sql);
        // Initialize the new shipment ID
        $shipet_id = 202501;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $last_shipet_id = $row['shipet_id'];
            // Increment the last shipet_id
            $shipet_id = $last_shipet_id + 1;
        }
        // Ensure the new_shipet_id is at least 6 digits
        $shipet_id = str_pad($shipet_id, 6, '0', STR_PAD_LEFT);
        // Now $new_shipet_id contains the new incremented ID, padded to at least 6 digits
        ?>
        <!-- HTML Form with read-only shipment_id -->
        <div class="booking_form">
            <h1>Book a Shipment</h1>
            <form action="booking_estimate.php" method="POST" class="form">
                <div class="form_container col">
                    <div class="col2">
                        <div class="col left">
                            <input type="hidden" name="shipet_id" id="shipet_id" value="<?php echo $shipet_id; ?>" readonly>
                            <!-- Consignee Information -->
                            <label for="consignee_name">Consignee Name:</label>
                            <input type="text" id="consignee_name" name="consignee_name" required>
                            <label for="consignee_mobile">Consignee Mobile:</label>
                            <input type="text" id="consignee_mobile" name="consignee_mobile" required pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number">
                            <label for="consignee_address">Consignee Address:</label>
                            <input id="consignee_address" name="consignee_address" required></input>
                            <label for="consignee_pincode">Consignee Pincode:</label>
                            <input type="text" id="consignee_pincode" name="consignee_pincode" oninput="fetchLocation()" placeholder="Enter Pincode" maxlength="6" minlength="6">
                            <label for="consignee_city">Consignee City:</label>
                            <input type="text" id="consignee_city" name="consignee_city" readonly>
                            <label for="consignee_state_name">Consignee State:</label>
                            <input type="text" id="consignee_state_name" name="consignee_state_name" readonly />
                            <input type="hidden" id="consignee_state" name="consignee_state" readonly />
                        </div>


                     
                            <div class="col right">
                                <!-- Parcel Information -->
                                <label for="parcel_value">Parcel Value (INR):</label>
                                <input type="text" id="parcel_value" name="parcel_value" required>
                                <label for="parcel_type">Parcel Type:</label>
                                <select id="parcel_type" name="parcel_type" required>
                                    <option value="P">Prepaid</option>
                                    <option value="C">COD</option>
                                </select>
                                <label for="parcel_contents">Parcel Contents:</label>
                                <input id="parcel_contents" name="parcel_contents" required></input>
                                <label for="parcel_weight">Parcel Weight (gm):</label>
                                <input type="text" id="parcel_weight" name="parcel_weight" required>
                                <label for="parcel_dimensions">Parcel Dimensions:</label>
                                <div class="dimensions">
                                    <div class="col">
                                        <label for="parcel_length">Lenght:</label>
                                        <input type="text" id="parcel_length" name="parcel_length" placeholder="Cm" required>
                                    </div>
                                    <div class="col">
                                        <label for="parcel_breadth">Breadth:</label>
                                        <input type="text" id="parcel_breadth" name="parcel_breadth" placeholder="Cm" required>
                                    </div>
                                    <div class="col">
                                        <label for="parcel_height">Height:</label>
                                        <input type="text" id="parcel_height" name="parcel_height" placeholder="Cm" required>
                                    </div>
                                </div>

                                <!-- Pickup Address ID -->
                                <label for="pickup_address_id">Pickup Address:</label>
                                <select style="background-color: lightblue;" id="pickup_address_id" name="pickup_address_id" required>
                                    <option value="" disabled selected>Select your Pickup Address</option>
                                    <?php
                                    // Use prepared statement to fetch warehouse data
                                    $stmt = $conn->prepare("SELECT warehouse_id, nickname, pincode FROM warehouses");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        // Output each row as an option
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . htmlspecialchars($row['warehouse_id'], ENT_QUOTES) . "'>Pickup Point: " . htmlspecialchars($row['nickname'], ENT_QUOTES) . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No warehouses available</option>";
                                    }
                                    // Close statement and connection
                                    $stmt->close();
                                    $conn->close();
                                    ?>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" name="estimate" value="estimate">Get Estimate</button>
            </form>
        </div>



    </main>
    <footer>
        <!-- import here footer file from images/bar/footer.php -->
        <?php include 'bar/footer.php'; ?>
    </footer>
</body>

</html>



<!-- THIS SCRIPT FOR PINCODE FATCH DATA FROM PINCODE.PHP -->
<script>
    function fetchLocation() {
        let pincode = document.getElementById("consignee_pincode").value.trim();

        if (pincode.length === 6) {
            fetch(`functions/pincode.php?pincode=${pincode}`)
                .then(response => response.json())
                .then(data => {
                    console.log("API Response:", data); // Debugging purpose

                    if (data.city && data.state && data.state_code) {
                        document.getElementById("consignee_city").value = data.city;
                        document.getElementById("consignee_state_name").value = data.state;
                        document.getElementById("consignee_state").value = data.state_code;
                    } else {
                        document.getElementById("consignee_city").value = "Not Found";
                        document.getElementById("consignee_state_name").value = "";
                        document.getElementById("consignee_state").value = "";
                    }
                })
                .catch(error => console.error("Error fetching data:", error));
        } else {
            document.getElementById("consignee_city").value = "";
            document.getElementById("consignee_state_name").value = "";
            document.getElementById("consignee_state").value = "";
        }
    }
</script>