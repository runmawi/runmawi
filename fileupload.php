<?php

require('cpanel/cpanel/cPanel.php');

$Domain_Name = "domain";
$username    = 'manoj';
$password    = 't94d24w32F8W';
$host    = '75.119.145.126';
$port = '2083';

$connection = ssh2_connect( $host, 22527);
ssh2_auth_password($connection, $username, $password);

// Git clone
    $stream = ssh2_exec($connection, "mkdir public_html/$Domain_Name && cd public_html/$Domain_Name && git clone https://manojbalaji2793@bitbucket.org/Akash0003/flicknexs.git .");
    $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

    stream_set_blocking($errorStream, true);
    stream_set_blocking($stream, true);

    // echo "Output: " .stream_get_contents($stream);
    echo "Output - GIT Clone: " .stream_get_contents($errorStream);

    fclose($errorStream);
    fclose($stream);


// ENV Upload
    $upload_file = realpath(".env.example");
    $destination_dir = "/home/manoj/public_html/$Domain_Name/.env";
    ssh2_scp_send($connection, $upload_file, $destination_dir , 0644);


// Create a New database user
    $cpanel = new CPANEL($username,$password,$host,$port); 

    $create_db_user = $cpanel->uapi(
        'Mysql', 'create_user',
        array(
            'name'       => 'manoj_'.$Domain_Name,
            'password'   => 'CHennai@01',
        ));

// Create a New database.
        $create_db = $cpanel->uapi(
            'Mysql', 'create_database',
            array(
                'name'    => 'manoj_'.$Domain_Name,
            ));


// Migration & Seeding
    $Stream1 = ssh2_exec($connection, "cd public_html/$Domain_Name &&  php artisan migrate:refresh --seed;");
    $errorStream1 = ssh2_fetch_Stream($Stream1, SSH2_STREAM_STDERR);

    Stream_set_blocking($errorStream1, true);
    Stream_set_blocking($Stream1, true);

    echo "Output - Seeding: " .stream_get_contents($Stream1);
    echo "Output - Migration: " .Stream_get_contents($errorStream1);
    fclose($errorStream1);
    fclose($Stream1);
    
?>


