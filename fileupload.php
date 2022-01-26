<?php


$connection = ssh2_connect('shell.example.com', 22);
ssh2_auth_password($connection, 'manoj', 't94d24w32F8W');

ssh2_scp_send($connection, '/local/filename', '/remote/filename', 0644);

// Run a command that will probably write to stderr (unless you have a folder named /hom)
$stream = ssh2_exec($connection, "cd /hom");
$errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

// Enable blocking for both streams
stream_set_blocking($errorStream, true);
stream_set_blocking($stream, true);

// Whichever of the two below commands is listed first will receive its appropriate output.  The second command receives nothing
echo "Output: " . stream_get_contents($stream);
echo "Error: " . stream_get_contents($errorStream);

// Close the streams       
fclose($errorStream);
fclose($stream);

