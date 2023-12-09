
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?


require 'vendor/autoload.php'; // Include the Google API PHP client library

$client = new Google_Client();
$client->setAuthConfig('path/to/your/credentials.json'); // Path to your downloaded JSON file
$client->setAccessType('offline');
$client->setScopes(Google_Service_Gmail::GMAIL_READONLY);

$tokenPath = 'path/to/your/token.json'; // Specify the path where the token will be stored

if (file_exists($tokenPath)) {
    $accessToken = json_decode(file_get_contents($tokenPath), true);
    $client->setAccessToken($accessToken);
}

if ($client->isAccessTokenExpired()) {
    if ($client->getRefreshToken()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    } else {
        // Handle the situation where the refresh token is missing
    }
}

$service = new Google_Service_Gmail($client);

$messages = $service->users_messages->listUsersMessages('me', ['maxResults' => 5]);

$response = [];

foreach ($messages->getMessages() as $message) {
    $msg = $service->users_messages->get('me', $message->getId());
    $headers = $msg->getPayload()->getHeaders();
    $subject = '';
    $from = '';

    foreach ($headers as $header) {
        if ($header->getName() == 'Subject') {
            $subject = $header->getValue();
        } elseif ($header->getName() == 'From') {
            $from = $header->getValue();
        }
    }

    $response[] = [
        'subject' => $subject,
        'from' => $from,
    ];
}

header('Content-Type: application/json');
echo json_encode($response);

?>
</body>
</html>