<div class='chaport-status-box <?php echo $statusClass ?>'>
    <b><?php echo __('Status:', 'chaport') ?></b>
    <span><?php echo $statusMessage ?></span>
</div>
<p>
    <?php printf(
        __('Please paste a Chaport App ID which you can get under "Chaport Settings" -> <a target="_blank" href="%s">"Installation code"</a>', 'chaport'),
        'https://app.chaport.com/#/settings/installation_code'
    ) ?>
</p>
<p>
    <?php echo __('Alternatively you can provide a custom Chaport installation code.', 'chaport') ?>
</p>
<div class='chaport-note'>
    <div class='label'><?php echo __('Note:', 'chaport') ?></div>
    <div class='text'>
        <p><?php echo __('Custom installation code should set <i>"chaport.visitor"</i> if you want to pass user email & name to Chaport.', 'chaport') ?></p>
        <p><?php printf(
            __('See <i>"Javascript API"</i> on our <a target="_blank" href="%s">Documentation page</a>.', 'chaport'),
            'https://docs.chaport.com/api/v1'
        ) ?></p>
    </div>
</div>
