<?php
    $painlessanalyticsSettings = get_option('painlessanalytics');
    $embedCode = !empty($painlessanalyticsSettings['embed']) ? $painlessanalyticsSettings['embed'] : '';
    $enabled = painlessAnalytics::getInstance()->getTrackUrl();
?>
<div class="painlessanalytics-form-setup">
    <?php if( empty($embedCode) ) { // If not enabled, lets give them a better experience ?>
    <a class="painlessanalytics-setup-link" href="#" onclick="return painlessanalyticsSetupLink(this)"><?php echo esc_html(__('Have a Painless Analytics embed code?', 'painlessanalytics')); ?></a>
    <?php } else if ( !$enabled ) { ?>
    <h3 id="painlessanalytics-status"><?php echo esc_html(__( 'Analytics Status', 'painlessanalytics' )); ?></h3>
    <p class="painlessanalytics-p-error">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
</svg>
    <?php echo esc_html(__('Painless Analytics is NOT enabled on your site', 'painlessanalytics')); ?></p>
    <?php } else { ?>
    <h3 id="painlessanalytics-status"><?php echo esc_html(__( 'Analytics Status', 'painlessanalytics' )); ?></h3>
    <p class="painlessanalytics-p-success">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
    </svg>
    <?php echo esc_html(__('Painless Analytics is enabled on your site', 'painlessanalytics')); ?></p>
    <?php } ?>
    <div id="powerpress-form-wrapper-setup" class="painlessanalytics-form-wrapper <?php echo ( !empty($embedCode) ? '' : 'painlessanalytics-none'); ?>">
    <form action="options.php" method="post">
        <?php settings_fields('painlessanalytics_settings_group'); ?>
        <h3 id="painlessanalytics-enter-setup-token"><?php echo esc_html( __( 'Painless Analytics embed code', 'painlessanalytics' )); ?></h3>
        <div class="painlessanalytics-input-row">
            <textarea id="embed" name="painlessanalytics[embed]" rows="10" type="text" class="painlessanalytics-textbox" placeholder="<?php echo esc_attr(__( 'Embed Code', 'painlessanalytics' )); ?>" class="regular-text code" aria-labelledby="painlessanalytics-enter-setup-token"
            ><?php echo esc_html($embedCode); ?></textarea>
        </div>
        <div class="painlessanalytics-button-row">
            <?php submit_button(); ?>
        </div>
    </form>
    </div>
</div>
<script>
function painlessanalyticsSetupLink(elem) {
    elem.classList.add('painlessanalytics-none');
    document.getElementById('powerpress-form-wrapper-setup').classList.remove('painlessanalytics-none');
    return false;
}
</script>