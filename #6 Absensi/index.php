<?php

$content = file_get_contents("php://input");
if($content){
    $token = '5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4';
    
    $apiLink = "https://api.telegram.org/bot$token";
    
    $update = file_get_contents('php://input');
    $val = json_decode($update, TRUE);
  
    $chat_id = $val['message']['chat']['id'];
    $text = $val['message']['text'];
    $firstname = $val['message']['from']['first_name'];
    $lastname = $val['message']['from']['last_name'];
    $update_id = $val['update_id'];
    $sender = $val['message']['from'];
    $uid=$val['message']['from']['username'];
    $uid_stat=$val['message']['chat']['type'];
    $lokasi1 = $val["message"]["location"]['longitude'];
    $lokasi2 = $val["message"]["location"]['latitude'];
    
    $databaseHost = 'localhost';
    $databaseName = 'absensi';
    $databaseUsername = 'root';
    $databasePassword = '';

    $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
    $getpendaftaran=mysqli_query($mysqli,"select * from registrasi where chat_id='$chat_id'");
    $getdata=mysqli_fetch_array($getpendaftaran);

    $getabsen=mysqli_query($mysqli,"select * from absen where chat_id='$chat_id'");
    $getdataabsen=mysqli_fetch_array($getabsen);

    if (($text=='/registrasi') or ($getdata['jk']==''))
    {
        if ($getdata['id_registrasi']=='')
        {  
            mysqli_query($mysqli,"insert into registrasi values ('','','','',$chat_id)");
            $reply.="Masukan nama anda : ";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
        else if ($getdata['nama']=='')
        {
            mysqli_query($mysqli,"update registrasi set nama='$text' where chat_id='$chat_id'");
            $reply.="Agama : ";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
            // sendphoto($key,$apiLink, $chat_id, $reply);
        }
        else if ($getdata['agama']=='')
        {
            mysqli_query($mysqli,"update registrasi set agama='$text' where chat_id='$chat_id'");
            $reply.="Jenis Kelamin : ";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
        else if ($getdata['jk']=='')
        {
            mysqli_query($mysqli,"update registrasi set jk='$text' where chat_id='$chat_id'");
            
            $reply.="Registrasi berhasil!!! ketik /absen untuk melakukan absensi";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);            

            mysqli_query($mysqli,"DELETE FROM `report_acitivity_temp` WHERE 1");
            
        }
        else
        {
            $reply.="Registrasi berhasil!!! ketik /absen untuk melakukan absensi";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
    }
    else
    {
        if (($text=='/absen') or ($getdataabsen['longi']==''))
        {
            if ($getdataabsen['id_absen']=='')
            {  
                
                $tgl=date('d/m/Y');
                $jam=date('h:i:s');
                mysqli_query($mysqli,"insert into absen values ('','$tgl','$chat_id','$jam','','','','')");
                $reply.="Absen (Hadir/Izin) : ";
                $key =['remove_keyboard'=>true,];
                sendTyping($apiLink, $chat_id);
                sendMessage($key,$apiLink, $chat_id, $reply);
            }
            else if ($getdataabsen['ket']=='')
            {  
                mysqli_query($mysqli,"update absen set ket='$text' where chat_id='$chat_id'");
                
                if (($text=='Izin') or ($text=='Sakit'))
                {
                    $reply.="Masukan alasan : ";
                    $key =['remove_keyboard'=>true,];
                    sendTyping($apiLink, $chat_id);
                    sendMessage($key,$apiLink, $chat_id, $reply);
                }
                else
                {
                    mysqli_query($mysqli,"update absen set alasan='-' where chat_id='$chat_id'");
                    $reply.="Share kordinat anda : ";
                    $key =['remove_keyboard'=>true,];
                    sendTyping($apiLink, $chat_id);
                    sendMessage($key,$apiLink, $chat_id, $reply);
                }
            }
            else if ($getdataabsen['alasan']=='')
            {  
                $tgl=date('d/m/Y');
                $jam=date('h:i:s');
                
                mysqli_query($mysqli,"update absen set alasan='$text' where chat_id='$chat_id'");
                mysqli_query($mysqli,"update absen set longi='-' where chat_id='$chat_id'");
                mysqli_query($mysqli,"update absen set lat='-' where chat_id='$chat_id'");
                $reply.="Terima kasih sudah melakukan konfirmasi 😊 \n\n<b>Berikut data anda : </b>\n\n";
                
                $first=$sender['first_name'];
                $reply.="✅ Nama : \n<pre> $first </pre>\n";
                $reply.="✅ Waktu absen : \n<pre> $tgl $jam </pre>\n";
                $reply.="✅ Ket : \n<pre> Izin </pre>\n";
                $reply.="✅ Alasan : \n<pre> $text </pre>";
                $key =['remove_keyboard'=>true,];

                $replygrup.="<b>Daftar Absensi</b>\n";
                $replygrup.="<pre>📆".date('d/m/Y h:i:s')."</pre>\n\n";
                $getpendaftaran=mysqli_query($mysqli,"SELECT registrasi.nama,absen.ket,absen.alasan,absen.tgl FROM `absen` inner join registrasi on absen.chat_id=registrasi.chat_id");
                    $nomorhadir=0;$nomortidakhadir=0;

                    $replygrup.="✅ Hadir : \n";
                    foreach ($getpendaftaran as $list) :
                    if ($list['ket']=='Hadir')
                    {
                        $nomorhadir++;
                        $replygrup.=$nomorhadir.'. '.$list['nama']."\n";
                    }
                    endforeach;

                    $replygrup.="\n ⚠️ Izin : \n";
                    foreach ($getpendaftaran as $list) :
                    {
                        if ($list['ket']=='Izin')
                        {
                            $nomortidakhadir++;
                            $replygrup.=$nomortidakhadir.'. '.$list['nama'].' - '.$list['alasan']."\n";
                        }
                    }
                    endforeach;

                sendTyping($apiLink, $chat_id);
                sendMessage($key,$apiLink, $chat_id, $reply);
                sendMessage($key,$apiLink, '-473234728', $replygrup);
            }
            else if ($getdataabsen['longi']=='')
            {  
                $tgl=date('d/m/Y');
                $jam=date('h:i:s');
                // -0.928827, 119.860684
                // $point1 = array("lat" => -0.8969238, "long" => 119.8793304);
                $point1 = array("lat" => -0.928827, "long" => 119.860684);
                $point2 = array("lat" => $lokasi2, "long" => $lokasi1);

                $distance = getDistanceBetweenPoints($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);

                $jarak=number_format($distance['kilometers'],2);

                if ($jarak<=0.20)
                {
                    mysqli_query($mysqli,"update absen set longi='$lokasi1' where chat_id='$chat_id'");
                    mysqli_query($mysqli,"update absen set lat='$lokasi2' where chat_id='$chat_id'");
                    $reply.="Terima kasih sudah sudah melakukan absensi, radius anda berada di $jarak KM dari lokasi kantor  \n\n<b>Berikut data anda : </b>\n\n";

                    $first=$sender['first_name'];
                    $reply.="✅ Nama : \n<pre> $first </pre>\n";
                    $reply.="✅ Waktu absen : \n<pre> $tgl $jam </pre>\n\n";

                    $replygrup.="<b>Daftar Absensi</b>\n";
                    $replygrup.="<pre>📆".date('d/m/Y h:i:s')."</pre>\n\n";
                    $getpendaftaran=mysqli_query($mysqli,"SELECT registrasi.nama,absen.ket,absen.alasan,absen.tgl FROM `absen` inner join registrasi on absen.chat_id=registrasi.chat_id");
                    $nomorhadir=0;$nomortidakhadir=0;

                    $replygrup.="✅ Hadir : \n";
                    foreach ($getpendaftaran as $list) :
                    if ($list['ket']=='Hadir')
                    {
                        $nomorhadir++;
                        $replygrup.=$nomorhadir.'. '.$list['nama']."\n";
                    }
                    endforeach;

                    $replygrup.="\n ⚠️ Izin : \n";
                    foreach ($getpendaftaran as $list) :
                    {
                        if ($list['ket']=='Izin')
                        {
                            $nomortidakhadir++;
                            $replygrup.=$nomorhadir.'. '.$list['nama'].' - '.$list['alasan']."\n";
                        }
                    }
                    endforeach;

                    $key =['remove_keyboard'=>true,];
                    sendTyping($apiLink, $chat_id);
                    sendMessage($key,$apiLink, $chat_id, $reply);
                    
                    sendMessage($key,$apiLink, '-473234728', $replygrup);
                }
                else 
                {
                    $reply.="Sistem mendeteksi bahwa anda berada di <b> $jarak KM </b> dari lokasi kantor. \n\nPastikan anda hadir dikantor untuk melakukan absensi.  \n\n<b>Share kembali kordinat anda : </b>\n\n";
                    
                    $key =['remove_keyboard'=>true,];
                    sendTyping($apiLink, $chat_id);
                    sendMessage($key,$apiLink, $chat_id, $reply);
                }
            }
            else
            {
                $reply.="Ketik /absen untuk melakukan absensi $lokasi1 $lokasi2";
                $key =['remove_keyboard'=>true,];
                sendTyping($apiLink, $chat_id);
                sendMessage($key,$apiLink, $chat_id, $reply);
            }
        }
        else
        {
            $reply.="Ketik /absen untuk melakukan absensi $lokasi1 $lokasi2";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
    }
     
}

function sendMessage($key,$website, $chatId, $message){
    $encodedMarkup = json_encode($key);
    $message = urlencode($message);
    $ch = curl_init($website."/sendmessage?chat_id=$chatId&parse_mode=HTML&text=$message&reply_markup=$encodedMarkup");// jika parse_mode ganti jadi markdown
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
}

function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2) {
    $theta = $lon1 - $lon2;
    $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $feet  = $miles * 5280;
    $yards = $feet / 3;
    $kilometers = $miles * 1.609344;
    $meters = $kilometers * 1000;
    return compact('miles','feet','yards','kilometers','meters'); 
}

function sendTyping($website, $chatId){
    $ch = curl_init($website."/sendChatAction?chat_id=$chatId&action=typing");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    $result = curl_exec($ch);
    curl_close($ch);
}

?>
