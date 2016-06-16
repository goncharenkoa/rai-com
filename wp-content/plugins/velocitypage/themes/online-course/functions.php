<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Theme_Online_Course extends AdLabs_VP_Theme {
	public function __construct() {
	}

	public function ensure_data( &$page ) {
		$page->add_field( 'h1', array( 'id' => 'h1' ) );
		$page->add_field( 'p', array( 'id' => 'footer' ) );
		$page->add_row_area( 'default', array( 'id' => 'default' ) );
		$page->add_row_area( 'default', array( 'id' => 'header' ) );
	}

	public function bootstrap_data( &$p, $post ) {
		// .header
		$p->add_field( 'h1', array( 'id' => 'h1', 'value' => 'Online Course' ) );

		// .rows
		$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );

		// Row 1
		$row = $row_area->add_row( 'full-width', array( 'id' => 'default' ) );

		// Row 1 / Row A
		$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Want to design beautiful WordPress pages in minutes?' ) );

		// Row 1 / Row B
		$h2_item = $item_area->add_item( 'h2', array( 'id' => 'h2' ) );
		$h2_item->add_field( 'h2', array( 'id' => 'default', 'value' => 'Learn how to build high-converting landing pages' ) );

		// Row 1 / Row C
		$h4_item = $item_area->add_item( 'h4', array( 'id' => 'h4' ) );
		$h4_item->add_field( 'h4', array( 'id' => 'default', 'value' => 'Our 10-part video course will teach you little known tips and tricks to get you started today.' ) );

		// Row 2
		$row2 = $row_area->add_row( 'split-12-12', array( 'id' => 'second' ) );

		// Row 2 / Col 1
		$item_area = $row2->add_item_area( '50-percent', array( 'id' => 'default' ) );
		$media_item = $item_area->add_item( 'media', array( 'id' => 'media' ) );
		$media_item->add_field( 'media', array( 'id' => 'default', 'value' => 'http://www.youtube.com/watch?v=v47WEyeSMSA' ) );

		// Row 2 / Col 2
		$item_area = $row2->add_item_area( '50-percent', array( 'id' => 'second' ) ) ;
		$text_item = $item_area->add_item( 'mailchimp', array( 'id' => 'mailchimp' ) );
		$text_item->add_field( 'html', array( 'id' => 'default', 'value' => '<div id="mc_embed_signup">
		<form action="http://velocitypage.us3.list-manage2.com/subscribe/post?u=09a77cd3bd557143099c452ae&amp;id=ccf863aaf8" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			<h2>Delete me and add your signup form here</h2>
		<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
		<div class="mc-field-group">
			<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
		</label>
			<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
		</div>
		<div class="mc-field-group">
			<label for="mce-FNAME">First Name </label>
			<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
		</div>
			<div id="mce-responses" class="clear">
				<div class="response" id="mce-error-response" style="display:none"></div>
				<div class="response" id="mce-success-response" style="display:none"></div>
			</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
		    <div style="position: absolute; left: -5000px;"><input type="text" name="b_09a77cd3bd557143099c452ae_ccf863aaf8" tabindex="-1" value=""></div>
		    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
		</form>
		</div>' ) );

		// Footer
		$p->add_field( 'p', array( 'id' => 'footer', 'value' => '© ' . date('Y') . '  Online Course,  All rights reserved.' ) );
	}
}

$this->init_theme( new AdLabs_VP_Theme_Online_Course );
