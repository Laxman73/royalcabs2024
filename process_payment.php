<?php
// Replace these with your actual Pine Labs credentials
$merchant_id = '15360';
$access_code = 'X75JTIDP4Z6P7WIWSKPM946F9DGF6A39';
$secret_key = '2CT71BH69U05FNVWYCQZW6P1YZMVQ992';

// Retrieve the payment details from the form
$amount = $_POST['amount']; // For simplicity, assuming you only have an amount field

// Prepare the request payload
$request_data = array(
    'amount' => $amount,
    'merchant_id' => $merchant_id,
    // Include other required parameters based on Pine Labs API documentation
);

// Generate the hash using the Secret Key
$hash_string = http_build_query($request_data);
$hash = hash_hmac('sha256', $hash_string, $secret_key);

// Add the hash to the request data
$request_data['hash'] = $hash;

// Make the API call to Pine Labs using cURL
$api_url = 'https://api-staging.pluralonline.com'; // Replace with the actual API endpoint
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Handle the API response
if ($response) {
    // Parse the response JSON
    $response_data = json_decode($response, true);
    
    var_dump($response_data);

    // Check the payment status and take appropriate actions
    if ($response_data['status'] === 'success') {
        // Payment success
        echo "Payment successful! Transaction ID: " . $response_data['transaction_id'];
        // Update the payment status in your database or perform other tasks as needed
    } else {
        // Payment failed
        echo "Payment failed! Error: " . $response_data['error_message'];
        // Handle the failed payment scenario
    }
} else {
    // API call failed
    echo "API call to Pine Labs failed!";
    // Handle the error
}
?>
