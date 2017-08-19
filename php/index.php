<?php
require dirname(__FILE__) . '/vendor/autoload.php';

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use MimeType\MimeType;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$dotenv->required(['CLIENT_ID', 'CLIENT_SECRET', 'ACCESS_TOKEN']);

$dropboxApplication = new DropboxApp(getenv('CLIENT_ID'), getenv('CLIENT_SECRET'), getenv('ACCESS_TOKEN'));
$dropbox = new Dropbox($dropboxApplication);

try {
    $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $fileDownload = $dropbox->getTemporaryLink($urlPath);
    $fileInfo = parse_url($fileDownload->getLink());
    header('Content-Type: '.MimeType::getType($urlPath));
    header("X-Accel-Redirect: /internal_redirect/{$fileInfo['scheme']}/{$fileInfo['host']}{$fileInfo['path']}");
}
catch (\Exception $e) {
    http_response_code(strpos($e->getMessage(), 'not_found') !== false ? 404 : 500);
    echo $e->getMessage();
}