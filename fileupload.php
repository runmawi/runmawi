<?php

error_reporting(E_ALL);


$connection = ssh2_connect('75.119.145.126', 22527);
ssh2_auth_password($connection, 'manoj', 't94d24w32F8W');

// File upload 
    // $upload_file = realpath("fileupload.php");
    // $destination_dir = "/home/manoj/public_html/fileupload.php";
    // ssh2_scp_send($connection, $upload_file, $destination_dir , 0644);


// connecting 
    $stream = ssh2_exec($connection, "cd /home/manoj/public_html/");
    $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

    stream_set_blocking($errorStream, true);
    stream_set_blocking($stream, true);

    stream_get_contents($stream);
    stream_get_contents($errorStream);

    fclose($errorStream);
    fclose($stream);
    

// Remove the folder 

    $stream2 = ssh2_exec($connection, "rm test");
    $errorstream2 = ssh2_fetch_stream($stream2, SSH2_STREAM_STDERR);

    stream_set_blocking($errorstream2, true);
    stream_set_blocking($stream2, true);

    echo "Output: " .stream_get_contents($stream2);
    echo "Error: " .stream_get_contents($errorstream2);
        
    fclose($errorstream2);
    fclose($stream2);


// Git clone

    $stream1 = ssh2_exec($connection, "git clone https://manojbalaji2793@bitbucket.org/Akash0003/flicknexs.git .");
    $errorStream1 = ssh2_fetch_stream($stream1, SSH2_STREAM_STDERR);

    stream_set_blocking($errorStream1, true);
    stream_set_blocking($stream1, true);

    echo "Output: " . stream_get_contents($stream1);
    echo "Error: " . stream_get_contents($errorStream1);

    fclose($errorStream1);
    fclose($stream1);


// Env Update 

    // $stream3 = ssh2_exec($connection, "git clone https://Mk_webnexs@bitbucket.org/Akash0003/flicknexs.git");
    // $errorstream3 = ssh2_fetch_stream($stream3, SSH2_STREAM_STDERR);

    // stream_set_blocking($errorstream3, true);
    // stream_set_blocking($stream3, true);

    // echo "Output: " . stream_get_contents($stream3);
    // echo "Error: " . stream_get_contents($errorstream3);

    // fclose($errorstream3);
    // fclose($stream3);


?>


