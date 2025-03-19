<?php

session_start(); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $encryptedText = mb_strtolower(trim($_SESSION['encryptedText']));
    $frequency = $_SESSION['frequency'];
   
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
//    print_r($encryptedFrequency);

   // Создаем таблицу соответствий
   $mapping = [];
   $encryptedKeys = array_keys($encryptedFrequency);
   $frequencyKeys = array_keys($frequency);

   // сопоставление букв из зашифрованного текста с буквами из частотного анализ
   for ($i = 0; $i < min(count($encryptedKeys), count($frequencyKeys)); $i++) {
       $mapping[$encryptedKeys[$i]] = $frequencyKeys[$i]; //$mapping['б'] = 'е';
   }
   print(count($frequency));
   echo '<br>';
   print(count($encryptedFrequency));   
   echo '<br>';
   print_r($mapping);

   
   $decryptedText = '';
   foreach (mb_str_split($encryptedText) as $char) {
       if (isset($mapping[$char])) {
           $decryptedText .= $mapping[$char];
       } else {
           $decryptedText .= $char; // оставляем как есть
       }
   }
   
    $_SESSION['decryptedText'] = $decryptedText;
    $_SESSION['mapping'] = $mapping;
    // echo $encryptedText;
    // print_r($mapping);
    // echo $decryptedText;
    header('Location: index.php');
    exit();

}
?>