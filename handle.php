<?php
require __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('Asia/Ho_Chi_Minh');// Set time zone


$client = new Google_Client();
$client->setApplicationName('Users');
$client->setScopes([Google_Service_Sheets::SPREADSHEETS_READONLY]);
$client->setAuthConfig('./credentials.json');
$client->setAccessType('offline');

$service = new Google_Service_Sheets($client);
$spreadsheetId = '1kDiRcAD6fFvq7z9LF7aOj5SaZW3RCnnqVMDyBE6qLmA'; // ID file sheet
$range = 'Users!A3:B'; // Tên trang cần lấy dữ liệu
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$accounts = $response->getValues();

$redirect_range = 'Users!B1';
$response = $service->spreadsheets_values->get($spreadsheetId, $redirect_range);
[[$redirect_url]] = $response->getValues();

session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    foreach ($accounts as $account) {
        if (!$account) continue;
        [$db_username,$db_password] = $account;
        if ($db_username === $username) {
            if ($db_password === $password) {
                $file_log = 'log.txt';
                $current = file_get_contents($file_log);
                $current .="Account: $username - " . 'Login at -> ' . date('d-m-Y H:i:s'). "\n";
                file_put_contents($file_log, $current);
                header('Location: '. $redirect_url);
            }
            break;
        }
    }
    $_SESSION['err_message'] = 'Login information is not correct';
    header('Location: '. $_SERVER['HTTP_REFERER']);
    die();
}