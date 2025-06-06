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
        display: flex;
        flex-direction: row;
        width: 100%;
        margin: 20px auto;
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: 5px;
        text-align: left;
        border: 1px solid #ddd;
        font-size: smaller;
        width: auto;
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

    table button {
        width: 100%;
        padding: 10px;
        background-color: rgb(9, 97, 151);
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        font-weight: bold;
        align-self: center;
    }

    table button:hover {
        background-color: rgb(111, 200, 255);
        color: rgb(2, 79, 127);
        ;
    }
    * Styling for the dropdown container */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Styling for the dropdown button */
    .dropdown-btn {
        padding: 8px 12px;
        font-size: 14px;
        color: #fff;
        background-color: #007bff;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: background-color 0.3s ease;
    }

    .dropdown-btn:hover {
        background-color: #0056b3;
    }

    /* Dropdown menu styling */
    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 5px;
        padding: 5px 0;
    }

    .dropdown-menu .dropdown-item {
        border-radius: 5px;
        color: rgb(0, 0, 0);
        padding: 6px 9px;
        text-decoration: none;
        display: block;
        font-size: 12px;
    }

    #print_label_btn {
        background-color: rgb(9, 145, 40);
    }

    #track_now_btn {
        background-color: #17a2b8;
    }

    .shipment_details_btn {
        background-color: #6c757d;
    }

    #whatsapp_share_btn {
        background-color: rgb(0, 193, 71);
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #ddd;
    }

    /* Show the dropdown menu when hovering over the button */
    .dropdown:hover .dropdown-menu {
        display: block;
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
        // Define the function outside the loop
        include 'functions/courier.php';
        // SQL query to select the data from booked_shipments
        $sql = "SELECT
        id, shipet_id, courier_status, shipment_id, courier_name, courier_cost, pickup_address_id, consignee_name, consignee_mobile, consignee_address, consignee_pincode, consignee_city, consignee_state, parcel_type, parcel_value, parcel_contents, parcel_weight, parcel_length, parcel_breadth, parcel_height 
        FROM booked_shipments WHERE courier_status = 30 ";

        
        $result = $conn->query($sql);
        // Check if there are results
        if ($result->num_rows > 0) {
            // Output data for each row
            echo '<div class="shipment">';
            echo '<div class="shipment_detail"><table border="1">';
            echo '<tr>';
            echo '<th>S. Id</th>';
            echo '<th>Status</th>';
            echo '<th>Address</th>';
            echo '<th>Type</th>';
            echo '<th>Value</th>';
            echo '<th>Contents</th>';
            echo '<th>Dimentions</th>';
            echo '<th>Weight</th>';
            echo '<th>Company</th>';
            echo '<th>Cost</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            while ($row = $result->fetch_assoc()) {
                // Calculate the parcel volume weight (L x B x H / 5000 for dimensional weight in grams)
                $parcel_type = $row['parcel_type'];
                $pickup_address_id = $row['pickup_address_id'];
                $courier_status = $row['courier_status'];
                // Use the function to get the status name
                $status_name = getCourierStatusName($courier_status);
                // This comes from the booked_shipments query
                echo '<tr>';
                echo '<td><strong>' . $row['shipet_id'] . '</strong></td>';
                echo '<td><strong>' . $status_name . '</strong></td>';
                echo '<td><strong>' . $row['consignee_name'] . '</strong>(' . $row['consignee_mobile'] . ')<br>' . $row['consignee_address'] . ' ' . $row['consignee_pincode'] . '</td>';
                echo '<td>' . getPaymentType($parcel_type) . '</td>';
                echo '<td>' . $row['parcel_value'] . '/-Rs</td>';
                echo '<td>' . $row['parcel_contents'] . '</td>';
                echo '<td>' . $row['parcel_length'] . 'X' . $row['parcel_breadth'] . 'X' . $row['parcel_height'] . ' Cm</td>';
                echo '<td>' . $row['parcel_weight'] . ' gm</td>';
                echo '<td>' . $row['courier_name'] . '</td>';
                echo '<td>' . $row['courier_cost'] . '</td>';
                echo '<td>';
                echo '<button><a href="http://localhost:3000/ship/booking_confirm.php?shipet_id=' . $row['shipet_id'] . '" target="_blank">Book</a></button>';
                echo '</td>';

                echo '</tr>';

            }
            echo '</table>';
        } else {
            echo "0 results";
        }






        $book_sql = "SELECT
        id, shipet_id, courier_status, shipment_id, courier_awb, courier_name, courier_cost, pickup_address_id, consignee_name, consignee_mobile, consignee_address, consignee_pincode, consignee_city, consignee_state, parcel_type, parcel_value, parcel_contents, parcel_weight, parcel_length, parcel_breadth, parcel_height 
        FROM booked_shipments WHERE courier_status = 2 ";
        $book_result = $conn->query($book_sql);
        
// Check if there are results
if ($book_result->num_rows > 0) {
    // Output data for each row
    
    echo '<div class="shipment_detail"><table border="1">';
    echo '<tr>';
    echo '<th>S. Id</th>';
    echo '<th>Status</th>';
    echo '<th>Address</th>';
    echo '<th>Type</th>';
    echo '<th>Company</th>';
    echo '<th>AWB</th>';
    echo '<th>Cost</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    while ($row = $book_result->fetch_assoc()) {
        // Calculate the parcel volume weight (L x B x H / 5000 for dimensional weight in grams)
        $parcel_type = $row['parcel_type'];
        $pickup_address_id = $row['pickup_address_id'];
        $courier_status = $row['courier_status'];
        // Use the function to get the status name
        $status_name = getCourierStatusName($courier_status);
        // This comes from the booked_shipments query
        echo '<tr>';
        echo '<td><strong>' . $row['shipet_id'] . '</strong></td>';
        echo '<td><strong>' . $status_name . '</strong></td>';
        echo '<td><strong>' . $row['consignee_name'] . '</strong>'.'</td>';
        echo '<td>' . getPaymentType($parcel_type) . '</td>';
        echo '<td>' . $row['courier_name'] . '</td>';
        echo '<td>' . $row['courier_awb'] . '</td>';
        echo '<td>' . $row['courier_cost'] . '</td>';
       
       // Actions Column (Buttons)
                        echo "<td>";

                        // Start of the dropdown container
                        echo "<div class='dropdown'>";

                        // Dropdown button
                        echo "<button class='btn dropdown-btn' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Actions</button>";

                        // Dropdown menu
                        echo "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";

                        // Print Label Button
                        echo "<a href='../php/pdf.php?shipment_id=" . $row['shipet_id'] . "&lable_print=lable' class='dropdown-item' id='print_label_btn'>Print Label</a>";

                        // Track Now Button
                        echo "<a href='tracking.php?shipet_id=" . $row['shipet_id'] . "&track=track' class='dropdown-item' id='track_now_btn'>Track Now</a>";

                        // More Details Button
                        echo "<a href='#' class='dropdown-item' id='shipment_details_btn'>More Details</a>";

                        // WhatsApp Share Button
                        echo "<a href='https://wa.me/" . $row['consignee_mobile'] . "?text=" . urlencode("Hi " . $row['consignee_name'] . ", Your Shipment ID is *" . $row['shipet_id'] . "* and you can track it by the link: http://localhost:3000/ship/tracking.php?shipet_id=" . $row['shipet_id'] . "&track=track. Thanks for connecting with *Shipet.in*") . "' target='_blank' class='dropdown-item' id='whatsapp_share_btn'>Share on WhatsApp</a>";

                        // End of the dropdown menu and container
                        echo "</div>";
                        echo "</div>";

                        echo "</td>";
        echo '</tr>';
    }
    echo '</table></div>';
} else {
    echo "0 results";
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