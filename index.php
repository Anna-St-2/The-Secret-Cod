<?php
session_start(); 

// Получаем данные из сессии
$text = isset($_SESSION['text']) ? $_SESSION['text'] : '';
$keyword = isset($_SESSION['keyword']) ? $_SESSION['keyword'] : '';
$alphabet = isset($_SESSION['alphabet']) ? $_SESSION['alphabet'] : '';
$modifiedAlphabet = isset($_SESSION['modifiedAlphabet']) ? $_SESSION['modifiedAlphabet'] : '';
$cipherTable = isset($_SESSION['cipherTable']) ? $_SESSION['cipherTable'] : '';
$frequencyText = isset($_SESSION['frequencyText']) ? $_SESSION['frequencyText'] : '';
$frequency = isset($_SESSION['frequency']) ? $_SESSION['frequency'] : '';
$encryptedText = isset($_SESSION['encryptedText']) ? $_SESSION['encryptedText'] : '';
$tableAnalysis = isset($_SESSION['tableAnalysis']) ? $_SESSION['tableAnalysis'] : '';
$decryptedText = isset($_SESSION['decryptedText']) ? $_SESSION['decryptedText'] : '';
$mapping = isset($_SESSION['mapping']) ? $_SESSION['mapping'] : '';


echo '<style>
.output { display: ' . ((isset($_SESSION['keyword'])) ? 'flex' : 'none') . '; }
</style>';

echo '<style>
.frequency-container { display: ' . (!empty(($_SESSION['tableAnalysis'])) ? 'flex' : 'none') . '; }
</style>';

echo '<style>
.result-card-decryptedText { display: ' . (!empty(($_SESSION['decryptedText'])) ? 'flex' : 'none') . '; }
</style>';


// Очищаем сессию после получения данных
// unset($_SESSION['text'], $_SESSION['keyword'], $_SESSION['alphabet'], $_SESSION['modifiedAlphabet'], $_SESSION['cipherTable'], $_SESSION['encryptedText'], $_SESSION['tableAnalysis']);
// Очистка сессии, если это необходимо
if (isset($_GET['clear_session'])) {
    unset($_SESSION['text'], $_SESSION['keyword'], $_SESSION['alphabet'], $_SESSION['modifiedAlphabet'], $_SESSION['cipherTable'], $_SESSION['frequencyText'], $_SESSION['frequency'], $_SESSION['encryptedText'], $_SESSION['tableAnalysis'], $_SESSION['decryptedText'], $_SESSION['mapping']);
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Secret Cod</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h3>The Secret Cod</h3>
        <a class ="btnClean" href="?clear_session=1">Очистить сессию</a>
    </header>

    <div class="container instructions">
            <h2>Что делает приложение?</h2>
            <p>
                Наше приложение позволяет вам легко шифровать и расшифровывать тексты с помощью улучшенного шифра Цезаря. Вы можете защитить свои сообщения, используя ключевое слово, и даже анализировать частоту букв в текстах для более сложных задач.
            </p>
            <h3>Основные функции:</h3>
            <ul>
                <li><strong>Шифрование текста:</strong> Введите текст и ключевое слово, чтобы получить зашифрованное сообщение.</li>
                <li><strong>Расшифровка текста:</strong> Используйте ключевое слово, чтобы восстановить исходный текст.</li>
                <li><strong>Анализ частоты букв:</strong> Узнайте, какие буквы чаще всего встречаются в тексте.</li>
                <li><strong>Автоматическая расшифровка:</strong> Попробуйте расшифровать текст без ключа, используя частотный анализ.</li>
            </ul>
            <h3>Как это работает?</h3>
            <p>
                Приложение создаёт уникальный алфавит на основе вашего ключевого слова и использует его для шифрования. Для расшифровки можно использовать ключ или метод частотного анализа.
            </p>
            <button onclick="location.href='#try-it'">Попробовать сейчас</button>
    </div>


    
    <form action="caesarCipher.php" method="post" class="container c1" >
        <h2>Шифрование текста</h2>
        <label for="text">Введите текст:</label>
        <textarea name="text" id="text" rows="4" placeholder="Введите текст для шифрования..."><?php echo htmlspecialchars($text); ?></textarea>

        <label for="keyword">Ключевое слово:</label>
        <input type="text" name="keyword" id="keyword" placeholder="Введите ключевое слово..." value="<?php echo htmlspecialchars($keyword); ?>">

        <button type="submit">Зашифровать</button>
        
       
        <div class="output">
            <h3>Результаты шифрования</h3>
            <div class="result-card">
                <h4>Новый алфавит:</h4>
                <p id="newAlphabet"><?php echo htmlspecialchars($modifiedAlphabet); ?></p>
            </div>
            <div class="result-card">
                <h4>Таблица соответствия:</h4>
                <input type="checkbox" id="accordion-toggle-alphabet" class="accordion-toggle-alphabet">
                <label for="accordion-toggle-alphabet" class="accordion-label-alphabet">Показать/Скрыть таблицу</label>
                <div class="panel">
                    <table>
                        <tbody>
                            <tr><td>Старая буква</td><td>Зашифрованная буква</td></tr>
                            <?php
                            foreach (mb_str_split($alphabet) as $index => $char) {
                                echo "<tr><td>" . htmlspecialchars($char) . "</td><td>" . htmlspecialchars(mb_str_split($modifiedAlphabet)[$index]) . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        
            <div class="result-card">
                <h4>Зашифрованный текст:</h4>
                <div id="encryptedText"><?php echo htmlspecialchars($encryptedText); ?></div>
            </div>
        </div>
    </form>

    
    

    <form action="frequencyAnalysis.php" method="post" class="container">
        <h2>Анализ частоты символов</h2>
        <label for="frequencyText">Введите текст для анализа:</label>
        <textarea id="frequencyText" name="frequencyText" rows="4" placeholder="Текст для анализа частоты..."><?php echo htmlspecialchars($frequencyText);?></textarea>
        <button>Анализировать</button>

        <div class="output">
            <div class="result-card">
                <!-- <div class="frequency-container"> -->
                    <h4>Таблица частоты символов</h4>
                    <input type="checkbox" id="accordion-toggle-frequency" class="accordion-toggle-frequency">
                    <label for="accordion-toggle-frequency" class="accordion-label-frequency">Показать/Скрыть таблицу</label>
                    <div class="panel">
                        
                        <table class="frequency-table">
                        <?php
                            echo $tableAnalysis;
                            // isset($_SESSION['tableAnalysis'])? echo $_SESSION['tableAnalysis']:echo '(((((';
                            ?>
                        </table>
                    </div>
            <!-- </div> -->
        </div>
        </div>
    </form>


    <form action="alKindi.php" method="post" class="container">
        <h2>Расшифровка методом Аль-Кинди</h2>
        <label for="decrypt">Введите зашифрованный текст:</label>
        <textarea id="decrypt" rows="4" name="encryptedText" placeholder="Зашифрованный текст..."><?php echo htmlspecialchars($encryptedText); ?></textarea>
        <!-- <input type="hidden" name="frequency" value='<?php echo json_encode($frequency); ?>'> -->
        <!-- <p><?php print_r($decryptedText); ?></p> -->
        <button>Расшифровать</button>
        <div class="output">

            <div class="result-card-decryptedText result-card">
                <h4>Расшифрованный текст:</h4>
                <p id='decryptedText'><?php echo $decryptedText;?></p>
            </div>

            <div class="output">
                <div class="result-card">
                    <h4>Таблица соответствий:</h4>
                    <!-- Чекбокс для аккордеона -->
                    <input type="checkbox" id="accordion-toggle-mapping" class="accordion-toggle-frequency">
                    <label for="accordion-toggle-mapping" class="accordion-label-frequency">Показать/Скрыть таблицу</label>
                    
                    <!-- Панель с таблицей -->
                    <div class="panel">     
                        <table class="frequency-table">
                            <thead>
                                <tr>
                                    <th>Зашифрованный символ</th>
                                    <th>Расшифрованный символ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Проверяем, есть ли данные в массиве $mapping
                                if (!empty($mapping)) {
                                    // Динамически заполняем таблицу
                                    foreach ($mapping as $encryptedChar => $decryptedChar) {
                                        echo "<tr>
                                                <td>" . htmlspecialchars($encryptedChar) . "</td>
                                                <td>" . htmlspecialchars($decryptedChar) . "</td>
                                            </tr>";
                                    }
                                } else {
                                    // Если массив пуст, выводим сообщение
                                    echo "<tr><td colspan='2'>Нет данных для отображения</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </form>
</body>
</html>
