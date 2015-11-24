<?php

if ($_POST['chat'] != null && $_POST['chat'] != "") {

    $chat = $_POST['chat'];

    $config = parse_ini_file('./config/config.ini');

    $logdata = array('type' => 'skype');

    preg_match_all("/\[(?:(?!\n\[).)*/s", $chat, $matches);

    if($matches) {

        $messages = array();

        foreach ($matches as $array) {
            foreach ($array as $match) {
                preg_match("@\[([^]]*)] ([^]]*): (.*)@s", $match, $s);
                $message = array('time' => $s[1],
                    'author' => $s[2],
                    'message' => $s[3]);
                array_push($messages, $message);
            }
        }

        $logdata['messages'] = $messages;
        $string_log = json_encode($logdata);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $string_log);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($string_log))
        );

        curl_setopt($curl, CURLOPT_URL, $config['apiurl'] . '/v1/submit.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);

        curl_close($curl);

        $result_array = json_decode($result, true);

        echo($result);

        if($result_array['ok']) {

            header("Location: " . $result_array['response']['id'] . '/');
        }
    }
}