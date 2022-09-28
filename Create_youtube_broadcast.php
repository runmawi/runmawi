<?php

if (!file_exists(__DIR__ . "/vendor/autoload.php")) {
    throw new \Exception(
        'please run "composer require google/apiclient:~2.0" in "' .
            __DIR__ .
            '"'
    );
}

require_once __DIR__ . "/vendor/autoload.php";
session_start();

$OAUTH2_CLIENT_ID ="592443666387-86osj17vgar9djnavhd8ehk1cv7kb2fs.apps.googleusercontent.com";
$OAUTH2_CLIENT_SECRET = "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";

$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);

$client->setScopes("https://www.googleapis.com/auth/youtube");
$redirect = filter_var(
    "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"],
    FILTER_SANITIZE_URL
);
$client->setRedirectUri($redirect);

$youtube = new Google_Service_YouTube($client);

$tokenSessionKey = "token-" . $client->prepareScopes();
if (isset($_GET["code"])) {
    if (strval($_SESSION["state"]) !== strval($_GET["state"])) {
        die("The session state did not match.");
    }

    $client->authenticate($_GET["code"]);
    $_SESSION[$tokenSessionKey] = $client->getAccessToken();
    header("Location: " . $redirect);
}

if (isset($_SESSION[$tokenSessionKey])) {
    $client->setAccessToken($_SESSION[$tokenSessionKey]);
}

if ($client->getAccessToken()) {
    try {
        $broadcastSnippet = new Google_Service_YouTube_LiveBroadcastSnippet();
        $broadcastSnippet->setTitle("New Broadcast");
        $broadcastSnippet->setScheduledStartTime("2022-09-26T15:43:09+05:30");

        $status = new Google_Service_YouTube_LiveBroadcastStatus();
        $status->setPrivacyStatus("public");

        $broadcastInsert = new Google_Service_YouTube_LiveBroadcast();
        $broadcastInsert->setSnippet($broadcastSnippet);
        $broadcastInsert->setStatus($status);
        $broadcastInsert->setKind("youtube#liveBroadcast");

        $broadcastsResponse = $youtube->liveBroadcasts->insert(
            "snippet,status",
            $broadcastInsert,
            []
        );

        $streamSnippet = new Google_Service_YouTube_LiveStreamSnippet();
        $streamSnippet->setTitle("New Stream");

        $cdn = new Google_Service_YouTube_CdnSettings();
        $cdn->setFormat("240p");
        $cdn->setIngestionType("rtmp");
        $cdn->setResolution("240p");
        $cdn->setframeRate("30fps");

        $streamInsert = new Google_Service_YouTube_LiveStream();
        $streamInsert->setSnippet($streamSnippet);
        $streamInsert->setCdn($cdn);
        $streamInsert->setKind("youtube#liveStream");

        $streamsResponse = $youtube->liveStreams->insert(
            "snippet,cdn",
            $streamInsert,
            []
        );

        $bindBroadcastResponse = $youtube->liveBroadcasts->bind(
            $broadcastsResponse["id"],
            "id,contentDetails",
            [
                "streamId" => $streamsResponse["id"],
            ]
        );

        $htmlBody = "<h3>Added Broadcast</h3><ul>";
        $htmlBody .= sprintf(
            "<li>%s published at %s (%s)</li>",
            $broadcastsResponse["snippet"]["title"],
            $broadcastsResponse["snippet"]["publishedAt"],
            $broadcastsResponse["id"]
        );
        $htmlBody .= "</ul>";

        $htmlBody .= "<h3>Added Stream</h3><ul>";
        $htmlBody .= sprintf(
            "<li>%s (%s)</li>",
            $streamsResponse["snippet"]["title"],
            $streamsResponse["id"]
        );
        $htmlBody .= "</ul>";

        $htmlBody .= "<h3>Bound Broadcast</h3><ul>";
        $htmlBody .= sprintf(
            "<li>Broadcast (%s) was bound to stream (%s).</li>",
            $bindBroadcastResponse["id"],
            $bindBroadcastResponse["contentDetails"]["boundStreamId"]
        );
        $htmlBody .= "</ul>";
    } catch (Google_Service_Exception $e) {
        $htmlBody = sprintf(
            "<p>A service error occurred: <code>%s</code></p>",
            htmlspecialchars($e->getMessage())
        );
    } catch (Google_Exception $e) {
        $htmlBody = sprintf(
            "<p>An client error occurred: <code>%s</code></p>",
            htmlspecialchars($e->getMessage())
        );
    }

    $_SESSION[$tokenSessionKey] = $client->getAccessToken();
} elseif ($OAUTH2_CLIENT_ID == "REPLACE_ME") {
    $htmlBody = <<<END
  <h3>Client Credentials Required</h3>
  <p>
    You need to set <code>\$OAUTH2_CLIENT_ID</code> and
    <code>\$OAUTH2_CLIENT_ID</code> before proceeding.
  <p>
END;
} else {
    $state = mt_rand();
    $client->setState($state);
    $_SESSION["state"] = $state;

    $authUrl = $client->createAuthUrl();
    $htmlBody = <<<END
  <h3>Authorization Required</h3>
  <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
?>

<!doctype html>
<html>
<head>
<title>Bound Live Broadcast</title>
</head>
<body>
  <?= $htmlBody ?>
</body>
</html>