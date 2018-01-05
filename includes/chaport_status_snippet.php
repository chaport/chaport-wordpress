<div class='chaport-status-box <?php echo $statusClass ?>'>
    <?php echo __('Integration status:', 'chaport') ?>
    <span><?php echo $statusMessage ?></span>
</div>
<p>
    <?php echo __('Please paste a Chaport App ID which you can get under "Chaport Settings" -> ', 'chaport') ?>
    <a target="_blank" href="https://app.chaport.com/#/settings/installation_code">
        <?php echo __('"Installation code"', 'chaport') ?>
    </a>
</p>
<p>
    <?php echo __('Alternatively you can provide a custom Chaport installation code.', 'chaport') ?>
</p>
