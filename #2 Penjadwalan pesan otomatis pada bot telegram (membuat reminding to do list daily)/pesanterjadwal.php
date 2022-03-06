<?php
//date_default_timezone_set('Asia/Makassar');
 
$hasil="<b></b> \n\n";
$hasil.="<b>⚠️ Reminder ⚠️ </b> \n";
$hasil.="Bot ini akan mengingatkanmu setiap harinya ❤️\n";

$hasil.="\nTengkyu 😊";


$hasilku = urlencode($hasil);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/sendmessage?chat_id=405823084&parse_mode=HTML&text=".$hasilku);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
curl_exec($ch);

?>