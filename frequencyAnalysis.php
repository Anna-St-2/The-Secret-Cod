<?php
session_start(); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $frequencyText = mb_strtolower(trim($_POST['frequencyText']));
    $f2 = $frequencyText;

    // Удаляем регуляркой все символы, кроме букв
    $frequencyText = preg_replace('/[^a-zа-яё]/u', '', $frequencyText);

    // Подсчитываем частоту каждого символа
    $frequency = [];
    // $length = mb_strlen($frequencyText);
    for ($i = 0; $i < mb_strlen($frequencyText); $i++) {
        $char = mb_substr($frequencyText, $i, 1); //извлекаем символ из строки 
        if (isset($frequency[$char])) {
            $frequency[$char]++;
        } else {
            $frequency[$char] = 1;
        }
    }

    // Сортируем массив по убыванию частоты
    arsort($frequency);

   
    $tableAnalysis = "<tr><th>Символ</th><th>Частота</th></tr>";
    foreach ($frequency as $char => $count) {
        $tableAnalysis .= "<tr><td>" . htmlspecialchars($char) . "</td><td>" . $count . "</td></tr>";
    }

    $_SESSION['tableAnalysis'] = $tableAnalysis;
    $_SESSION['frequencyText'] = $f2;
    $_SESSION['frequency'] = $frequency;
    // print_r($frequency);

    // echo $_SESSION['tableAnalysis'];

    // print_r($_SESSION['frequency']);
    header('Location: index.php');
    exit();
}


?>