<?php

error_reporting(E_ALL);

$connection = ssh2_connect('75.119.145.126', 22527);
ssh2_auth_password($connection, 'manoj', 't94d24w32F8W');


// Git clone
$stream = ssh2_exec($connection, "mkdir public_html/Tesing && cd public_html/Tesing && git clone https://manojbalaji2793@bitbucket.org/Akash0003/flicknexs.git .");
    $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

    stream_set_blocking($errorStream, true);
    stream_set_blocking($stream, true);

    echo "Output: " .stream_get_contents($stream);
    echo "Output: " .stream_get_contents($errorStream);

    fclose($errorStream);
    fclose($stream);

// ENV update
    $upload_file = realpath(".env");
    $destination_dir = "/home/manoj/public_html/Tesing/.env";
    ssh2_scp_send($connection, $upload_file, $destination_dir , 0644);
    
?>


