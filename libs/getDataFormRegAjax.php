<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if(isset($_POST['gameId'])) {
    
    $game_id = (int)($_POST['gameId']);
    
} else {
   echo json_encode('Ошибка! данные не переданы ',  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK); 
}

$result = [
    'game_title' => getGameNameById($game_id)
];
        
echo json_encode($result);
        
?>
