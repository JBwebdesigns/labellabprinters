<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
    $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        // MailChimp API credentials
        $apiKey = 'API KEY';
        $listID = 'f3c5f167a7';

        // MailChimp API URL
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey, strpos($apiKey, '-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/';

        // member information
        $json = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME'     => $fname,
                'LNAME'     => $lname
            ]
        ]);

        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // store the status message based on response code
        if ($httpCode == 200) {
            $_SESSION['listmsg'] = '<div class="alert alert-success" role="alert">You have successfully subscribed!</div>';
        } else {
            switch ($httpCode) {
                case 400:
                    $msg = 'You are already subscribed.';
                    break;
                default:
                    $msg = 'Some problem occurred, please try again.';
                    break;
            }
            $_SESSION['listmsg'] = '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
        }
    } else {
        $_SESSION['listmsg'] = '<div class="alert alert-danger" role="alert">Please enter valid email address.</div>';
    }
}
// redirect to homepage
header('location: index.php#mailing-list');
