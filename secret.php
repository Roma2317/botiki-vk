<?php
$confirmationToken = '89c8dfd3';
$secretKey = 'nedobovlayteserveradebili';    
// Функция отправляющая сообщения
function vk_msg_send($peer_id, $text){
    
    $request_params = array(
      'message' => $text,
      'attachment' => $attachment,
      'peer_id' => $peer_id,
      'access_token' => 'vk1.a.lHdHYy4juc-2551E95IC2nndS5TVFBp2iMGowmQu0URZP7bpz7YYmhEiHZo3VcdD4wKVmXaCsZ0pI4OWjkvkzFYsSpFuPN49MlV7KN8FwiWO9J3F6cJoULeD-UtLs4a1s8c0_o2K4UrXLCWg4UJdldCXNAJ4tLp75_-luYmdHj4kKKRplxXre_j5WeDVZyGhs2nbbrJaxdwpwrXbxPFp-A',
      'v' => '5.89'
    );
    
    $get_params = http_build_query($request_params); 
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}
$data = json_decode(file_get_contents('php://input')); // Получаем данные с ВК
if(strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0) {
    return;
}
switch ($data->type) {  
    case 'confirmation': 
        echo $confirmationToken; // Если ВК запрашивает подтверждение, то выводим код подтверждения 
    break;  
        
    case 'message_new':
        // Если событие нового сообщения, то получаем его текст
        $message_text = $data->object->text;
        $peer_id = $data->object->peer_id;
        
        $message_text = mb_strtolower($message_text, 'UTF-8'); // Переводим текст к нижнему регистру
        
        // Если сообщение содержит подстроку привет, отправляем сообщение
        if(strpos($message_text, "начать") !== false){
            vk_msg_send($peer_id, "Привет! я бот группы: /help");
        }
        if(strpos($message_text, "/help") !== false){
            vk_msg_send($peer_id, "Мои команды:
                                    /report - репорт
                                    /obnows - узнать об обновлении!
                                    /play - игры (бесплатные)");
        }
        if(strpos($message_text, "/report") !== false){
            vk_msg_send($peer_id, "[Чако]: Администратор уже в пути! Ожидайте ответ через 5-30 минут");
        }
        if(strpos($message_text, "/obnows") !== false){
            vk_msg_send($peer_id, "[Чако]: Обнова выходит каждую неделю в сруду или же в четверг! С уважением бот группы!");
        }
        if(strpos($message_text, "/play") !== false){
            vk_msg_send($peer_id, "[Чако]: Го поиграем в игру Да/нет");
            vk_msg_send($peer_id, "[Чако]: Называй любые Хочу и я буду говорить Да или же Нет");
            }
        }
        
        echo 'ok'; // Обязательно уведомляем сервер, что сообщение получено, текстом ok
    break;
}
?>