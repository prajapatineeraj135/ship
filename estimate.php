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

        flex-direction: row;
        justify-content: center;
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
        <section Class="section" >
            <div class="estimate_section">
                <form action="estimate_result.php" method="GET" class="estimate_form">
                    <h1>Shipment Estimate Cost</h1>
                    <div class="estimate_input">
                        <div class="col 1">
                            <label for="length">Length(Cm):</label>
                            <input type="integer" name="length" class="textfield" required>
                            <label for="breadth">Breadth(Cm):</label>
                            <input type="integer" name="breadth" class="textfield" required>
                            <label for="height">Height(Cm):</label>
                            <input type="integer" name="height" class="textfield" required>
                            <label for="weight">Weight(Gm):</label>
                            <input type="integer" name="weight" class="textfield" required>
                            <label for="shipment_value">Shipment Value:</label>
                            <input type="text" name="shipment_value" class="textfield" pattern="[0-9]+" required>
                        </div>
                        <div class="col 2">
                            <label for="origin_pincode">Sender Pincode:</label>
                            <input type="text" id="origin_pincode" name="origin_pincode"
                                oninput="fetchLocation('origin_pincode', 'origin_city')"
                                placeholder="Enter Pincode" maxlength="6" minlength="6" required>


                            <label for="origin_city">City:</label>
                            <input type="text" id="origin_city" name="origin_city" readonly>


                            <label for="destination_pincode"> Reciver Pincode:</label>
                            <input type="text" id="destination_pincode" name="destination_pincode"
                                oninput="fetchLocation('destination_pincode', 'destination_city')"
                                placeholder="Enter Pincode" maxlength="6" minlength="6" required><label for="destination_city">City:</label>
                            <input type="text" id="destination_city" name="destination_city" readonly>



                            
                            <label for="shipment_type">Shipment Type:</label>
                            <div class="input_radio">
                                <label><input type="radio" name="shipment_type" value="P" <?php if (isset($_POST['shipment_type']) && $_POST['shipment_type'] == 'P') echo 'checked'; ?> required>Prepaid</label>
                                <label><input type="radio" name="shipment_type" value="C" <?php if (isset($_POST['shipment_type']) && $_POST['shipment_type'] == 'C') echo 'checked'; ?> required>COD</label>
                            </div>
                        </div>
                    </div>
                    <div class="estimate_btn"><button type="submit" name="estimate" value="estimate" class="btn">Get Estimate Rate</button></div>
                </form>

            </div>
        </section>
    </main>
    <footer>
        <!-- import here footer file from images/bar/footer.php -->
        <?php include 'bar/footer.php'; ?>
    </footer>
</body>

</html>

