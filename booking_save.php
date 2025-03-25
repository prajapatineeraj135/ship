<?php
// Start output buffering at the top of your PHP file
ob_start();
?><!DOCTYPE html>
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
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
    }
    .booking_form h1 {
        text-align: center;
    }
    .booking_form label {
        display: block;
        margin-bottom: 5px;
    }
    .booking_form input,
    .booking_form textarea,
    .booking_form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .dimensions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }
    .booking_form button {
        width: 100%;
        padding: 10px;
        margin: 20px 0;
        background-color: rgb(9, 97, 151);
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        font-weight: bold;
    }
    .booking_form button:hover {
        background-color: rgb(111, 200, 255);
        color: rgb(2, 79, 127);
        ;
    }
    .response {
        margin-top: 20px;
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
        if (isset($_POST['selected_courier'])) {
            // Get the selected courier data from the form
            $selectedCourierData = $_POST['selected_courier_data'];
            $shipet_id = $_POST['shipet_id'];
            // Split the data into individual parts (courier_id, company_name, category, cost)
            $dataParts = explode('|', $selectedCourierData);
            $courier_id = $dataParts[0];
            $courier_name = $dataParts[1];
            $courier_cost = $dataParts[3];  // Index 3 for cost since it's the fourth element
            // Prepare the SQL query to insert the data into the booked_shipment table
            $sql = "UPDATE booked_shipments 
            SET courier_id = '$courier_id', courier_name = '$courier_name', courier_cost = '$courier_cost' 
            WHERE shipet_id = '$shipet_id'";
            // Execute the query and check if it was successful
            if ($conn->query($sql) === TRUE) {
                header("Location: http://localhost:3000/ship/booking_confirm.php?shipet_id=$shipet_id");
                exit(); // It's a good practice to call exit after header redirect // Stop the script to ensure the redirection happens
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>
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