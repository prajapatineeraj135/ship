<?php
if (isset($_GET['pincode'])) {
    $pincode = $_GET['pincode'];
    if (preg_match('/^\d{6}$/', $pincode)) {
        $api_url = "https://api.postalpincode.in/pincode/" . $pincode;
        $response = file_get_contents($api_url);
        $data = json_decode($response, true);

        if (!empty($data) && isset($data[0]['Status']) && $data[0]['Status'] === "Success") {
            $city = $data[0]['PostOffice'][0]['District'];
            $state = $data[0]['PostOffice'][0]['State'];

            // Mapping state names to their short codes
            $stateMapping = [
                "Andhra Pradesh" => "AP", "Arunachal Pradesh" => "AR", "Assam" => "AS",
                "Bihar" => "BI", "Chandigarh" => "CH", "Dadra and Nagar Haveli" => "DA",
                "Daman and Diu" => "DM", "Delhi" => "DE", "Goa" => "GO",
                "Gujarat" => "GU", "Haryana" => "HA", "Himachal Pradesh" => "HP",
                "Jammu and Kashmir" => "JA", "Karnataka" => "KA", "Kerala" => "KE",
                "Lakshadweep Islands" => "LI", "Madhya Pradesh" => "MP", "Maharashtra" => "MA",
                "Manipur" => "MN", "Meghalaya" => "ME", "Mizoram" => "MI",
                "Nagaland" => "NA", "Odisha" => "OD", "Puducherry" => "PO",
                "Punjab" => "PU", "Rajasthan" => "RA", "Sikkim" => "SI",
                "Tamil Nadu" => "TN", "Tripura" => "TR", "Uttar Pradesh" => "UP",
                "West Bengal" => "WB", "Telangana" => "TS", "Jharkhand" => "JH",
                "Uttarakhand" => "UK", "Chattisgarh" => "CG", "Ladakh" => "LA"
            ];

            $stateCode = $stateMapping[$state] ?? "";
            echo json_encode(["city" => $city, "state" => $state, "state_code" => $stateCode]);
        } else {
            echo json_encode(["error" => "Invalid Pincode"]);
        }
    } else {
        echo json_encode(["error" => "Invalid Pincode Format"]);
    }
    exit;
}
?>
