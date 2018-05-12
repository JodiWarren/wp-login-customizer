<?php

namespace JwLoginCustomizer\AdminTemplate;

function get_page_contents() { ?>

<form method="POST" action="options.php">
	<?php settings_fields( JW_LOGIN_CUSTOMIZER_DOMAIN );	//pass slug name of page, also referred
	//to in Settings API as option group name
	do_settings_sections( JW_LOGIN_CUSTOMIZER_DOMAIN ); 	//pass slug name of page
	submit_button();
	?>
</form>

<?php } ?>
