<?php if ($showError && isset($errors) && $errors->hasBag($errorBag)): ?>
    <?php foreach ($errors->getBag($errorBag)->get($nameKey) as $err): ?>
        <div <?= $options['errorAttrs'] ?>><?= $err ?></div>
    <?php endforeach; ?>
<?php elseif ($showError & isset($options['validationMessage'])): ?>
    <div <?= $options['errorAttrs'] ?>><?= $options['validationMessage'] ?></div>
<?php endif; ?>

