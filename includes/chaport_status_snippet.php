<div class='chaport-status-box <?php echo $statusClass ?>'>
    <b><?php echo __('Status:', 'chaport') ?></b>
    <span><?php echo $statusMessage ?></span>
</div>
<p>
    <?php printf(
        __('Please paste a Chaport App ID which you can get under <a target="_blank" href="%s">Settings -> Installation code</a> in Chaport app.', 'chaport'),
        'https://app.chaport.com/#/settings/installation_code'
    ) ?>
</p>
