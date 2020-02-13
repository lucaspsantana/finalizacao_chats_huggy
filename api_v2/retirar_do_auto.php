<?php

function colocar_na_fila($api_token, $chat_id){
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.huggy.io/v2/chats/".$chat_id."/queue
");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, "{}
");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "X-Authorization: Bearer ".$api_token
));

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);

}

function executar_flow($api_token, $chat_id, $flow_id){

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.huggy.io/v2/chats/".$chat_id."/flow
");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"flowId\": ".$flow_id."
}");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "X-Authorization: Bearer ".$api_token
));

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);
}