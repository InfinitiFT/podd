<?php
header('Content-type: application/json');
include('../functions/functions.php');
//Receiveing Input in Json and decoding
$data         = json_decode(file_get_contents('php://input'));
$user_id      = $data->{"user_id"};
$old_password = $data->{"old_password"};
$new_password = $data->{"new_password"};
//Basic Validation  
if (empty($user_id) || empty($old_password) || empty($new_password)) {
    $response['responseCode']    = 0;
    $response['responseMessage'] = 'UserID and Password fields are required.';
} else {
    $verify = mysql_fetch_assoc(mysql_query("SELECT user_id FROM users WHERE user_id = '" . $user_id . "' AND password = '" . md5($old_password) . "'"));
    if (!empty($verify)) {
        $update                      = mysql_query("UPDATE users SET password = '" . md5($new_password) . "' WHERE user_id = '" . $user_id . "'");
        $response['responseCode']    = 200;
        $response['responseMessage'] = 'Password Updated Successfully';
    } else {
        $response['responseCode']    = 0;
        $response['responseMessage'] = 'Old Password Not Matched';
    }
}
//Sending response after json encoding
$responseJson = json_encode($response);
print $responseJson;

?>
