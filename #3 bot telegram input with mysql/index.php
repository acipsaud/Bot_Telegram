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

    $databaseHost = 'localhost';
    $databaseName = 'pendaftaran';
    $databaseUsername = 'root';
    $databasePassword = '';

    $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
    $getpendaftaran=mysqli_query($mysqli,"select * from tpendaftaran where chat_id='$chat_id'");
    $getdata=mysqli_fetch_array($getpendaftaran);

    if (($getdata['id']=='') || ($getdata['nama']=='') || ($getdata['alamat']=='') || ($getdata['agama']==''))
    {
        if (($text=='/daftar') and ($getdata['id']=='')) 
        {  
            $reply.="Masukan nama anda : ";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
        else if ($getdata['nama']=='')
        {
            mysqli_query($mysqli,"insert into tpendaftaran values ('','$text','','',$chat_id)");
            $reply.="Alamat : ";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
        else if ($getdata['alamat']=='')
        {
            mysqli_query($mysqli,"update tpendaftaran set alamat='$text' where chat_id='$chat_id'");
            $reply.="Agama : ";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
        else if ($getdata['agama']=='')
        {
            mysqli_query($mysqli,"update tpendaftaran set agama='$text' where chat_id='$chat_id'");
            $reply.="Registrasi Berhasil !! ";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
        else
        {
            $reply.="Anda Telah terdaftar";
            $key =['remove_keyboard'=>true,];
            sendTyping($apiLink, $chat_id);
            sendMessage($key,$apiLink, $chat_id, $reply);
        }
    }
    else
    {
        $reply.="Anda Telah terdaftar";
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