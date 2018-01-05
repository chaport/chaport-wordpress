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
