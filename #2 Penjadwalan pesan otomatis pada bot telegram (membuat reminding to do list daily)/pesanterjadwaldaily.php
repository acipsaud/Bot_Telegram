<?php
//date_default_timezone_set('Asia/Makassar');
 
$databaseHost = 'localhost';
$databaseName = 'penjadwalan';
$databaseUsername = 'root';
$databasePassword = '';
// date_default_timezone_set('Asia/Makassar');
 
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 


$tglhariini=date('d/m/Y');
$pesan = mysqli_query($mysqli, "SELECT * FROM botjadwal where tgl='$tglhariini'");


$hasil="<b></b> \n\n";
while($tampilpesan = mysqli_fetch_array($pesan)) 
{
    $hasil.="<b>⚠️ Reminder ⚠️ </b> \n\n";
    $hasil.= $tampilpesan['pesan'];

    $hasil.="\nTengkyu 😊";

    $hasilku = urlencode($hasil);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/sendmessage?chat_id=405823084&parse_mode=HTML&text=".$hasilku);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_exec($ch);

    echo "sukses";
}

?>