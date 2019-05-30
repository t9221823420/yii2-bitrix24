<?php
/**
 * Created by PhpStorm.
 * User: bw
 * Date: 17.05.2019
 * Time: 11:42
 */
?>


    <h2>Установка приложения</h2>

<?php if ($errorsList): ?>

    <div id="result" class="failed">
        Ошибки при установке приложения:
        <pre><?php print_r($errorsList) ?></pre>
    </div>

<?php else: ?>
    <div id="result" class="success">
        Приложение успешно установлено
    </div>
<?php endif; ?>