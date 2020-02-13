
<?php
  set_time_limit(1800); //tempo em segundos
  function closeChat($id, $companyID,$apiToken){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.huggy.app/v3/companies/".$companyID."/chats/".$id."/close");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_PUT, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      "Accept: application/json",
      "Authorization: Bearer ".$apiToken
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    var_dump($response);
  }

  function finalizarChatsMassa($apiToken, $companyID, $initialDate, $finalDate, $situation){
    $num = 0;
    $response = "";
    $initialDate = strtotime($initialDate); 
    $finalDate = strtotime($finalDate);
      while($response != "[]"){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.huggy.app/v3/companies/".$companyID."/chats?situation=".$situation."&page=".$num);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/json",
          "Accept: application/json",
          "Authorization: Bearer ".$apiToken
        ));
        $response = curl_exec($ch);
        $chats = json_decode($response);
        curl_close($ch);
            for($i=0; $i < count($chats); $i++){
              $createdAt= strtotime(substr($chats[$i]->createdAt,0, 10));
              if($createdAt>= $initialDate && $createdAt <= $finalDate){
                $id = $chats[$i]->id;
                closeChat($id, $companyID, $apiToken); 
                usleep(100); //tempo em microssegundos
              }
            }
        $num++;
        }
  }

  $apiToken ="o seu Token api fica aqui";
  finalizarChatsMassa($apiToken, 10755,"2020-01-23","2020-02-10", "auto");
