<?php
require __DIR__ . '/DriveAPI/vendor/autoload.php';

function getClient()
{
    putenv('CREDENTIALS=../credentials.json');
    putenv('TOKEN=../token.json');
    $client = new Google_Client();
    $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->setScopes(['https://www.googleapis.com/auth/drive']);
    $client->setAuthConfig(getenv('CREDENTIALS'));
    $client->setAccessType('offline');

    //Load previously authorized credentials from a file.
    $credentialsPath = getenv('TOKEN');
    if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
        echo "Please contact an administrator.";
    }
    $client->setAccessToken($accessToken);

    //Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    putenv('CREDENTIALS');
    putenv('TOKEN');
    return $client;
}