<?php if ($options['wrapper'] !== false): ?>
<div class="row">
<div <?= $options['wrapperAttrs'] ?> >
<?php endif; ?>

<?php if (isset($options['link'])) : ?>
<a href="<?= $options['link'] ?>" class="<?= $options['attr']['class'] ?>">
    <?= $options['label'] ?>
</a>
<?php else: ?>
<?= Form::button($options['label'], $options['attr']) ?>
<?php endif; ?>
<?php include 'help_block.php' ?>

<?php if ($options['wrapper'] !== false): ?>
</div>
</div>
<?php endif; ?>
