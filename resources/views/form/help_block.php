<?php if ($options['help_block']['text'] && !$options['is_child']): ?>
    <div <?= $options['help_block']['helpBlockAttrs'] ?>>
        <?= $options['help_block']['text'] ?>
    </div>
<?php endif; ?>
