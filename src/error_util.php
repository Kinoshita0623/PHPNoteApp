<?php
require_once('escape.php');

function showError(&$errors, $key) {
    ?>
    <div class="error">
        <?php if(isset($errors[$key])) : ?>
            <?= h($errors[$key]) ?>
        <? endif; ?>
    </div>
<?php
}