<?php
$script = <<< JS
    BX24.init(function () {
    var result = document.getElementById("result");
    if(result.className === 'success') {
        BX24.installFinish();
    }
});
JS;
?>
<h2>Установка приложения</h2>

<?php if ($errorsList ?? false): ?>

    <div id="result" class="failed">
        Ошибки при установке приложения:
        <pre><?php print_r($errorsList) ?></pre>
    </div>

<?php else: ?>
    <div id="result" class="success">
        Приложение успешно установлено
    </div>

    <script src="//api.bitrix24.com/api/v1/"></script>
    <?php $this->registerJs($script, yii\web\View::POS_READY); ?>
<?php endif; ?>
