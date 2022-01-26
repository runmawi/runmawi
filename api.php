<?php
// Log everything during development.
// If you run this on the CLI, set 'display_errors = On' in php.ini.
error_reporting(E_ALL);
 
// Declare your username and password for authentication.
$username = 'manoj';
$password = 't94d24w32F8W';
 
// Define the API call.
$cpanel_host = '75.119.145.126';
$request_uri = "https://$cpanel_host:2083/execute/Fileman/upload_files";
 
// Define the filename and destination.
$upload_file = realpath("fileupload.php");
$destination_dir = "public_html/Test";
 
// Set up the payload to send to the server.
if( function_exists( 'curl_file_create' ) ) {
    $cf = curl_file_create( $upload_file );
} else {
    $cf = "@/".$upload_file;
}
$payload = array(
    'dir'    => $destination_dir,
    'file-1' => $cf
);
 
// Set up the cURL request object.
$ch = curl_init( $request_uri );
curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
curl_setopt( $ch, CURLOPT_USERPWD, $username . ':' . $password );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );


// Set up a POST request with the payload.
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
 
// Make the call, and then terminate the cURL caller object.
$curl_response = curl_exec( $ch );
curl_close( $ch );
 

// Decode and validate output.
$response = json_decode( $curl_response );
if( empty( $response ) ) {
    echo "The cURL call did not return valid JSON:\n";
    die( $response );
} elseif ( !$response->status ) {
    echo "The cURL call returned valid JSON, but reported errors:\n";
    die( $response->errors[0] . "\n" );
}
 
// Print and exit.
die( print_r( $response ) );
?>


<!-- 
Main Account Credentials

url: https://75.119.145.126:2087
Username: root
Password: As6EEE3wPM
Cpanel access: 
url: https://75.119.145.126:2083
UserName: vodflicknexs
PassWord: t94d24w32F8W

Test Account for file deployment
url: https://75.119.145.126:2083
UserName: manoj
PassWord: t94d24w32F8W -->
