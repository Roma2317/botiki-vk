<?php
$confirmationToken = '89c8dfd3';
$secretKey = 'nedobovlayteserveradebili';    
// ������� ������������ ���������
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
$data = json_decode(file_get_contents('php://input')); // �������� ������ � ��
if(strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0) {
    return;
}
switch ($data->type) {  
    case 'confirmation': 
        echo $confirmationToken; // ���� �� ����������� �������������, �� ������� ��� ������������� 
    break;  
        
    case 'message_new':
        // ���� ������� ������ ���������, �� �������� ��� �����
        $message_text = $data->object->text;
        $peer_id = $data->object->peer_id;
        
        $message_text = mb_strtolower($message_text, 'UTF-8'); // ��������� ����� � ������� ��������
        
        // ���� ��������� �������� ��������� ������, ���������� ���������
        if(strpos($message_text, "������") !== false){
            vk_msg_send($peer_id, "������! � ��� ������: /help");
        }
        if(strpos($message_text, "/help") !== false){
            vk_msg_send($peer_id, "��� �������:
                                    /report - ������
                                    /obnows - ������ �� ����������!
                                    /play - ���� (����������)");
        }
        if(strpos($message_text, "/report") !== false){
            vk_msg_send($peer_id, "[����]: ������������� ��� � ����! �������� ����� ����� 5-30 �����");
        }
        if(strpos($message_text, "/obnows") !== false){
            vk_msg_send($peer_id, "[����]: ������ ������� ������ ������ � ����� ��� �� � �������! � ��������� ��� ������!");
        }
        if(strpos($message_text, "/play") !== false){
            vk_msg_send($peer_id, "[����]: �� �������� � ���� ��/���");
            vk_msg_send($peer_id, "[����]: ������� ����� ���� � � ���� �������� �� ��� �� ���");
            }
        }
        
        echo 'ok'; // ����������� ���������� ������, ��� ��������� ��������, ������� ok
    break;
}
?>