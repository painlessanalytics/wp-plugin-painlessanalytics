<div id="painlessanalytics-plugin-container">
    <div class="painlessanalytics-header">
        <div class="painlessanalytics-body">
            <div class="painlessanalytics-container">
                <?php painlessAnalyticsAdmin::view('header'); ?>
                <div class="wrap">
                    <h2><?php echo esc_html(__('Simplified web metrics', 'painlessanalytics')); ?></h2><!-- so messages are relocated here -->
                </div>
            </div>
        </div>
    </div>
    <?php if( !painlessAnalytics::getInstance()->getApiUrl() ) { ?>
    <div class="painlessanalytics-hero">
        <div class="painlessanalytics-body">
            <div class="painlessanalytics-container">
                <p class="painlessanalytics-p-lg"><?php echo esc_html(__('Revolutionary web analytics allowing you to focus on the metrics that matter most.', 'painlessanalytics')); ?></p>
                <p class="painlessanalytics-p-lg"><a class="painlessanalytics-link" 
                    href="https://account.painlessanalytics.com/start" 
                    title="<?php echo esc_attr( __('Sign up for FREE', 'painlessanalytics')); ?>" target="_blank">
                    <?php echo esc_html( __('Sign up for FREE', 'painlessanalytics')); ?></a> | <a class="painlessanalytics-link" 
                    href="https://www.painlessanalytics.com/" 
                    title="<?php echo esc_attr(__('Learn more', 'painlessanalytics')); ?>" target="_blank">
                    <?php echo esc_html(__('Learn more', 'painlessanalytics')); ?></a>
                </p>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="painlessanalytics-section-gray">
        <div class="painlessanalytics-body">
            <div class="painlessanalytics-container">
            <?php painlessAnalyticsAdmin::view('setup'); ?>
            </div>
        </div>
    </div>
    <div class="painlessanalytics-footer">
        <div class="painlessanalytics-container">
            <p>
            <?php echo esc_html( __( 'Having issues?', 'painlessanalytics' ) ); ?>
            <a href="https://www.painlessanalytics.com/company/contact/" target="_blank"><?php echo esc_html( __('Please contact us', 'painlessanalytics') ) ?></a>. 
            <?php echo esc_html( __( 'We want to help you!', 'painlessanalytics' ) ); ?>
            </p>
        </div>
    </div>
</div>