<?php
session_start(); 
 // Устанавливаем заголовок для правильной кодировки
 header('Content-Type: text/html; charset=utf-8'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем и приводим к нижнему регистру введённый текст и ключевое слово
    $text = mb_strtolower(trim($_POST['text']));
    $keyword = mb_strtolower(trim($_POST['keyword']));
    
    // echo "<strong>Исходный текст:</strong> " . htmlspecialchars($text) . "<br>";
    // echo "<strong>Ключевое слово:</strong> " . htmlspecialchars($keyword) . "<br>";
    
    // Функция для формирования изменённого алфавита на основе ключевого слова
    function createModifiedAlphabet($keyword) {
        $alphabet = "абвгдежзийклмнопрстуфхцчшщъыьэюя";
        $modifiedAlphabet = "";

        // Добавляем буквы ключевого слова, пропуская повторяющиеся
        foreach (mb_str_split($keyword) as $char) {
            if (!str_contains($modifiedAlphabet, $char)) {
                $modifiedAlphabet .= $char;
            }
        }

        // Добавляем оставшиеся буквы алфавита
        foreach (mb_str_split($alphabet) as $char) { //mb_str_split  разбивает строку на массив символов 
            if (!str_contains($modifiedAlphabet, $char)) {//str_contains проверка содержитсся ли данный элемент в массиве
                $modifiedAlphabet .= $char;
            }
        }

        return $modifiedAlphabet;
    }
    
    
    // Функция для шифрования текста
    function caesarCipher($text, $modifiedAlphabet) {
        $alphabet = "абвгдежзийклмнопрстуфхцчшщъыьэюя";
        $encryptedText = "";

        foreach (mb_str_split($text) as $char) {//mb_str_split  разбивает строку на массив символов 
            if (str_contains($alphabet, $char)) {
                // Находим индекс буквы в стандартном алфавите
                $index = mb_strpos($alphabet, $char);
                // echo mb_str_split($alphabet)[$index].' -> '.$modifiedAlphabet[$index].'<br>'; //проверка правильного шифрования
                // echo $index." ";
                // Заменяем на букву из изменённого алфавита
                $encryptedText .= mb_str_split($modifiedAlphabet)[$index];
                // echo $modifiedAlphabet[$index]. "<br>";
            } else {
                // Если символ не буква, оставляем его без изменений
                $encryptedText .= $char;
            }
        }

        return $encryptedText;
    }

    // Формируем изменённый алфавит
    $modifiedAlphabet = createModifiedAlphabet($keyword);

    // Шифруем текст
    $encryptedText = caesarCipher($text, $modifiedAlphabet);


   

     // Формируем таблицу соответствия
     $cipherTable = "<table><tr><th>Старый</th><th>Новый</th></tr>";
     $alphabet = "абвгдежзийклмнопрстуфхцчшщъыьэюя";
     foreach (mb_str_split($alphabet) as $index => $char) {
         $cipherTable .= "<tr><td>" . htmlspecialchars($char) . "</td><td>" . htmlspecialchars(mb_str_split($modifiedAlphabet)[$index]) . "</td></tr>";
     }
     $cipherTable .= "</table>";
 
    //  // Выводим результаты
    //  echo "<div class='output'>";
    //  echo "<h3>Новый алфавит:</h3><p>" . htmlspecialchars($modifiedAlphabet) . "</p>";
    //  echo "<h3>Таблица соответствия:</h3>" . $cipherTable;
    //  echo "<h3>Зашифрованный текст:</h3><p>" . htmlspecialchars($encryptedText) . "</p>";
    //  echo "</div>";

      // Сохраняем данные в сессии
    $_SESSION['text'] = $text;
    $_SESSION['keyword'] = $keyword;
    $_SESSION['alphabet'] = $alphabet;
    $_SESSION['modifiedAlphabet'] = htmlspecialchars($modifiedAlphabet);
    $_SESSION['cipherTable'] = $cipherTable;
    $_SESSION['encryptedText'] = htmlspecialchars($encryptedText);

    // Перенаправляем обратно на index.php
    header('Location: index.php');
    exit();

}

?>
