<?php
session_start(); // Начинаем сессию

// Получаем данные из сессии, если они есть
$text = isset($_SESSION['text']) ? $_SESSION['text'] : '';
$keyword = isset($_SESSION['keyword']) ? $_SESSION['keyword'] : '';
$alphabet = isset($_SESSION['alphabet']) ? $_SESSION['alphabet'] : '';
$modifiedAlphabet = isset($_SESSION['modifiedAlphabet']) ? $_SESSION['modifiedAlphabet'] : '';
$cipherTable = isset($_SESSION['cipherTable']) ? $_SESSION['cipherTable'] : '';
$encryptedText = isset($_SESSION['encryptedText']) ? $_SESSION['encryptedText'] : '';

// Очищаем сессию после получения данных
unset($_SESSION['text'], $_SESSION['keyword'], $_SESSION['newAlphabet'], $_SESSION['cipherTable'], $_SESSION['encryptedText']);
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
    <header>The Secret Codddddd</header>

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


    
    <form action="caesarCipher.php" method="post" class="container">
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
                <input type="checkbox" id="accordion-toggle" class="accordion-toggle">
                <label for="accordion-toggle" class="accordion-label">Показать/Скрыть таблицу</label>
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
            </div>
            <div class="result-card">
                <h4>Зашифрованный текст:</h4>
                <div id="encryptedText"><?php echo htmlspecialchars($encryptedText); ?></div>
            </div>
        </div>
    </form>

    
    

    <div class="container">
        <h2>Анализ частоты символов</h2>
        <label for="frequency-text">Введите текст для анализа:</label>
        <textarea id="frequency-text" rows="4" placeholder="Текст для анализа частоты..."></textarea>

        <button>Анализировать</button>

        <div class="frequency-container">
            <h2>Частота букв</h2>
            <table class="frequency-table">
                <thead>
                    <tr>
                        <th>Буква</th>
                        <th>Частота</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>А</td><td>12%</td></tr>
                    <tr><td>Б</td><td>3%</td></tr>
                    <tr><td>В</td><td>8%</td></tr>
                    <tr><td>Г</td><td>2%</td></tr>
                    <tr><td>Д</td><td>5%</td></tr>
                    <tr><td>Е</td><td>10%</td></tr>
                    <tr><td>Ж</td><td>1%</td></tr>
                    <tr><td>З</td><td>4%</td></tr>
                    <tr><td>И</td><td>9%</td></tr>
                    <tr><td>К</td><td>6%</td></tr>
                    <tr><td>Л</td><td>7%</td></tr>
                    <tr><td>М</td><td>5%</td></tr>
                    <tr><td>Н</td><td>11%</td></tr>
                    <tr><td>О</td><td>14%</td></tr>
                    <tr><td>П</td><td>6%</td></tr>
                </tbody>
            </table>
        </div>
        
    </div>

    <div class="container">
        <h2>Расшифровка методом Аль-Кинди</h2>
        <label for="decrypt">Введите зашифрованный текст:</label>
        <textarea id="decrypt" rows="4" placeholder="Зашифрованный текст..."></textarea>

        <button>Расшифровать</button>
    </div>
</body>
</html>
