<?php
/**
 * Function to get the status name based on courier_status code
 *
 * @param int $courier_status The courier status code
 * @return string The corresponding status name
 */

function getCourierStatusName($courier_status) {
    // Map courier_status codes to status names
    $status_mapping = [
        1  => 'Pending Pickup',
        2  => 'Processing',
        3  => 'Shipped',
        7  => 'Canceled',
        12 => 'Damaged',
        14 => 'Lost',
        16 => 'Voided',
        21 => 'Delivered',
        22 => 'In Transit',
        23 => 'Returned to Origin',
        24 => 'Manifested',
        25 => 'Pickup Scheduled',
        26 => 'Out For Delivery',
        27 => 'Pending Return',
        30 => 'Draft'
    ];

    // Return the corresponding status name or 'Unknown Status' if not found
    return isset($status_mapping[$courier_status]) ? $status_mapping[$courier_status] : 'Unknown Status';
}



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
?>