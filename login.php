<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__ . '/config.php';
session_start();

$client = new Google_Client();
$client->setAuthConfig(CLIENT_SECRET_PATH);
$client->setApplicationName(APPLICATION_NAME);
$client->setScopes(SCOPES);
$client->setAccessType('offline');

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  /*$drive = new Google_Service_Drive($client);
  $files = $drive->files->listFiles(array())->getItems();
  echo json_encode($files);*/
} else {
  $pos = strripos('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], '/');
  $redirect_uri = substr_replace('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], 'oauth2callback.php', $pos+1);
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>