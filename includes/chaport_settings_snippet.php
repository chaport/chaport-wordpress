<form action='options.php' method='POST'>
    <?php settings_fields('chaport_options') ?>
    <?php do_settings_sections('chaport') ?>
    <p class='submit'>
        <input type='submit' name='submit' id='submit' class='button button-primary' value='<?php echo esc_attr__('Save Changes', 'chaport') ?>' />
    </p>
</form>
