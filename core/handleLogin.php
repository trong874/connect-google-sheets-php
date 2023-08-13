<?php
require '../vendor/autoload.php';

const HOME_URL = '../index.php';

date_default_timezone_set('Asia/Ho_Chi_Minh');// Set time zone


$client = new Google_Client();
$client->setApplicationName('Users');
$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
$client->setAuthConfig('../credentials.json');
$client->setAccessType('offline');
$client->setIncludeGrantedScopes(true);

$service = new Google_Service_Sheets($client);
$spreadsheetId = '1kDiRcAD6fFvq7z9LF7aOj5SaZW3RCnnqVMDyBE6qLmA'; // ID file sheet
$range = 'Users!A2:B'; // Tên trang cần lấy dữ liệu
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$accounts = $response->getValues();

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {


    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    foreach ($accounts as $account) {
        if (!$account) continue;
        [$db_username,$db_password] = $account;
        if ($db_username === $username) {
            if ($db_password === $password) {
                $range = 'Logs!A:B';
                $value = [
                    [$username,date('d-m-Y H:i:s')],
                ];

                $body = new Google_Service_Sheets_ValueRange([
                    'values' => $value
                ]);

                $params = [
                    'valueInputOption' => 'RAW'
                ];

                $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

                $_SESSION['auth'] = ['username'=> $username,'check'=>true];

                header('Location: '. HOME_URL);
                die();
            }
            break;
        }
    }
    $_SESSION['err_message'] = 'Login information is not correct';
    header('Location: '. $_SERVER['HTTP_REFERER']);
    die();
}