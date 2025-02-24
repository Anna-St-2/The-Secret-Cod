<?php

session_start(); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $encryptedText = mb_strtolower(trim($_SESSION['encryptedText']));
    $frequency = $_SESSION['frequency'];
    // Получаем частотный анализ и декодируем его из JSON
    // $frequency = json_decode(trim($_SESSION['frequency']), true);
    // var_dump($_POST['frequency']);
    

    if (!is_array($frequency)) {
        echo "Ошибка: Частотный анализ должен быть массивом. Получено: ";
        var_dump($_POST['frequency']);
        exit;
    }


    // if (empty($encryptedText) || empty($frequency)) {
    //     echo "Ошибка: Зашифрованный текст или частоты не указаны.";
    //     exit;
    // }

   // Считаем частоту букв в зашифрованном тексте
   $encryptedFrequency = array_count_values(mb_str_split($encryptedText));
   arsort($encryptedFrequency);

   // Создаем таблицу соответствий
   $mapping = [];
   $encryptedKeys = array_keys($encryptedFrequency);
   $frequencyKeys = array_keys($frequency);

   // Сопоставляем буквы из зашифрованного текста с буквами из частотного массива
   for ($i = 0; $i < min(count($encryptedKeys), count($frequencyKeys)); $i++) {
       $mapping[$encryptedKeys[$i]] = $frequencyKeys[$i]; //$mapping['б'] = 'е';
   }

   // Расшифровываем текст
   $decryptedText = '';
   foreach (mb_str_split($encryptedText) as $char) {
       if (isset($mapping[$char])) {
           $decryptedText .= $mapping[$char];
       } else {
           $decryptedText .= $char; // оставляем как есть
       }
   }

    $_SESSION['decryptedText'] = $decryptedText;
    // print_r($mapping);
    // echo $decryptedText;
    header('Location: index.php');
    exit();

}
?>