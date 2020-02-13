<?php
function closeChat($apiToken,$id){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.huggy.io/v2/chats/".$id."/close");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "{
    \"sendFeedback\": false
  }");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
  "X-Authorization: Bearer $apiToken"
  ));
  $response = curl_exec($ch);
  curl_close($ch);
  var_dump($response);
}
function changeSituation($apiToken, $id){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.huggy.io/v2/chats/$id/situation");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "{
    \"situation\": \"auto\"
  }");
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "X-Authorization: Bearer $apiToken"
  ));
  $response = curl_exec($ch);
  curl_close($ch);
  var_dump($response);
}

function finalizarChatsMassa($apiToken){
  $num = 0;
  $response = "empty";
  while($response != '[]'){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.huggy.io/v2/chats?page=".$num);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "X-Authorization: Bearer $apiToken"
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    $atendimentos = json_decode($response);
    for($i=0; $i < count($atendimentos); $i++){
      if($atendimentos[$i]->closedAt == ""){
          $id = $atendimentos[$i]->id;
          echo "id: $id ";
          //changeSituation($apiToken, $id); //alterar a situação de in_chat para auto afim de finalizar 
          closeChat($id);
      }
    }
    curl_close($ch);
    $num++;
  }
}