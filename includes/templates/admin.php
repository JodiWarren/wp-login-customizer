<?php

namespace JwLoginCustomizer\AdminTemplate;

/**
 * Render contents of Settings page
 */
function get_page_contents() { ?>

    <h1><?= __( 'JW Login Customizer', JW_LOGIN_CUSTOMIZER_DOMAIN ) ?></h1>
    <form method="POST" action="options.php">
		<?php settings_fields( JW_LOGIN_CUSTOMIZER_DOMAIN );
		do_settings_sections( JW_LOGIN_CUSTOMIZER_DOMAIN );
		submit_button();
		?>
    </form>

<?php } ?>
