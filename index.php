<?php

$content = file_get_contents("php://input");
if($content){
    $token = '5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4';
    
    $apiLink = "https://api.telegram.org/bot$token";
    
    $update = file_get_contents('php://input');
    $val = json_decode($update, TRUE);
  
    $chat_id = $val['message']['chat']['id'];
    $text = $val['message']['text'];
    $update_id = $val['update_id'];
    $sender = $val['message']['from'];
    $uid=$val['message']['from']['username'];
    $uid_stat=$val['message']['chat']['type'];
    $photo_id = $val["message"]["photo"][2]["file_id"];

    $databaseHost = 'localhost';
    $databaseName = 'pendaftaran';
    $databaseUsername = 'root';
    $databasePassword = '';

    $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
    $getpendaftaran=mysqli_query($mysqli,"select * from report_acitivity_temp where chat_id='$chat_id'");
    $getdata=mysqli_fetch_array($getpendaftaran);

    if (($text=='/report') or ($getdata['id']!=''))
    {
        if ($getdata['id']=='')
        {  
            mysqli_query($mysqli,"insert into report_acitivity_temp values ('','','','',$chat_id)");
            $reply.="Masukan eviden/foto aktivitas : ";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
        else if ($getdata['eviden']=='')
        {
            $foto=sendphoto($photo_id, $apiLink, $token);
            // mysqli_query($mysqli,"insert into report_acitivity_temp values ('','$foto','','',$chat_id)");
            mysqli_query($mysqli,"update report_acitivity_temp set eviden='$foto' where chat_id='$chat_id'");
            $reply.="lokasi : ";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
            // sendphoto($key,$apiLink, $chat_id, $reply);
        }
        else if ($getdata['lokasi']=='')
        {
            mysqli_query($mysqli,"update report_acitivity_temp set lokasi='$text' where chat_id='$chat_id'");
            $reply.="Aktivitas : ";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
        else if ($getdata['aktivitas']=='')
        {
            mysqli_query($mysqli,"update report_acitivity_temp set aktivitas='$text' where chat_id='$chat_id'");
            mysqli_query($mysqli,"INSERT INTO `report_activity`(`id`, `eviden`, `lokasi`, `aktivitas`, `chat_id`) SELECT*from report_acitivity_temp;");
            
            $databaseHost = 'localhost';
            $databaseName = 'pendaftaran';
            $databaseUsername = 'root';
            $databasePassword = '';
            $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
            $pesan = mysqli_query($mysqli, "SELECT * FROM report_acitivity_temp where chat_id='$chat_id'");
            $hasil='';
            while($tampilpesan = mysqli_fetch_array($pesan)) 
            {
                $lokasi=$tampilpesan['lokasi'];
                $aktivitas=$tampilpesan['aktivitas'];
                $eviden=$tampilpesan['eviden'];
            }

            $url = $eviden;
            $getfile=explode("/",$url);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            $filename = $getfile[6];
            $fp = fopen($filename, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);

            $hasil.="<b>📷 Report Activity  </b> \n\n";
            $hasil.= "Lokasi : ".$lokasi."\n";
            $hasil.= "Aktivitas : ".$aktivitas."\n";
            $message = $hasil;

            $url = 'https://api.telegram.org/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/sendPhoto';
            $file = new CURLFile(realpath($getfile[6]));
            $param = array('chat_id'=>'-473234728','caption'=>$message,'photo'=>$file, 'parse_mode'=>'HTML');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$param);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST');
            curl_exec($ch);
            curl_close($ch);

            $reply.="Report Terkirim!!! silahkan cek grup kawal report activity untuk melihat hasilnya";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);

            

            

            mysqli_query($mysqli,"DELETE FROM `report_acitivity_temp` WHERE 1");
            
        }
        else
        {
            $reply.="Ketik /report untuk memasukan visiting";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
    }
    else
    {
        $reply.="Ketik /report untuk memasukan visiting";
        $key =['remove_keyboard'=>true,];
        sendTyping($apiLink, $chat_id);
        sendMessage($key,$apiLink, $chat_id, $reply);
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

function sendphoto($photo_id, $website,$token){
    $ch = curl_init($website.'/getfile?file_id='.$photo_id);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $photo_path= curl_exec($ch);
    curl_close($ch);
    $photo_path = json_decode($photo_path, TRUE);
    $photo_path = $photo_path["result"]["file_path"];
    $photo_url = "https://api.telegram.org/file/bot".$token."/".$photo_path."";
    return $photo_url;
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