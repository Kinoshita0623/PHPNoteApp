<?php
function showError(&$errors, $key) {
    ?>
    <div class="error">
        <?php if(isset($errors[$key])) : ?>
            <?= $errors[$key] ?>
        <? endif; ?>
    </div>
<?php
}