<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>
    <div class="col-sm-8">
        <?php if (isset($options['icon']) || isset($options['append'])) : ?>
        <div class="input-group">
        <?php endif; ?>
        <?php if (isset($options['icon'])) : ?>
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="<?= $options['icon'] ?>"></i>
                </span>
            </div>
        <?php endif; ?>
        <?= Form::input($type, $name, $options['value'], $options['attr']) ?>
        <?php if (isset($options['append'])) : ?>
            <div class="input-group-append">
                <span class="input-group-text"><?= $options['append'] ?></span>
            </div>
        <?php endif; ?>
        <?php if (isset($options['icon']) || isset($options['append'])) : ?>
        </div>
        <?php endif; ?>

        <?php include 'help_block.php' ?>
        <?php include 'errors.php' ?>
    </div>
<?php endif; ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
