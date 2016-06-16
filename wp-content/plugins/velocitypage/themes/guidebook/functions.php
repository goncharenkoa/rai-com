<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Theme_Guidebook extends AdLabs_VP_Theme {
	public function __construct() {
	}

	public function ensure_data( &$page ) {
		$page->add_field( 'h1', array( 'id' => 'h1' ) );
		$page->add_field( 'h4', array( 'id' => 'h4' ) );
		$page->add_field( 'p', array( 'id' => 'description' ) );
		$page->add_field( 'p', array( 'id' => 'footer' ) );
		$page->add_row_area( 'default', array( 'id' => 'default' ) );
		$page->add_row_area( 'default', array( 'id' => 'header' ) );
	}

	public function bootstrap_data( &$p, $post ) {
		// .header
		$p->add_field( 'h1', array( 'id' => 'h1', 'value' => 'GUIDEBOOK' ) );
		$p->add_field( 'p', array( 'id' => 'description', 'value' => 'Everything you need to know' ) );

		// .rows
		$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );

		// Row 1
		$row = $row_area->add_row( 'full-width', array( 'id' => 'default' ) );

		// // Row 1 / Row A
		$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
		$h2_item = $item_area->add_item( 'h2', array( 'id' => 'h2' ) );
		$h2_item->add_field( 'h2', array( 'id' => 'default', 'value' => 'Selling your ebook has never been easier!' ) );

		// Row 1 / Row B
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Download the FREE 65 page ebook and start building beautiful landing pages today.' ) );

		// Row 2
		$row2 = $row_area->add_row( 'split-13-13-13', array( 'id' => 'second' ) );

		// Row 2 / Col 1
		$item_area = $row2->add_item_area( '33-percent', array( 'id' => 'default' ) );
		$h4_item = $item_area->add_item( 'h4', array( 'id' => 'h4' ) );
		$h4_item->add_field( 'h4', array( 'id' => 'default', 'value' => 'Why you should get our book' ) );

		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => '
			<p style="text-align: left;" data-mce-style="text-align: left;"><strong>Step-by-step Guide</strong><br>Easy to follow and immediately take action on!</p><p style="text-align: left;" data-mce-style="text-align: left;"><strong>Awesome Landing Pages</strong><br>Learn to layout landing pages in 3 easy steps</p><p style="text-align: left;" data-mce-style="text-align: left;"><strong>Fully Actionable</strong><br>Every lesson has action steps to complete</p><p style="text-align: left;" data-mce-style="text-align: left;"><strong>Want Landing Pages The Convert?</strong><br>Learn the secret to achieving double-digit conversions</p>' ) );

		// Row 2 / Col 2
		$item_area = $row2->add_item_area( '33-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-book.png' ) );

		// Row 2 / Col 3
		$item_area = $row2->add_item_area( '33-percent', array( 'id' => 'third' ) );
		$text_item = $item_area->add_item( 'mailchimp', array( 'id' => 'mailchimp' ) );
		$text_item->add_field( 'html', array( 'id' => 'default', 'value' => '<div id="mc_embed_signup">
		<form action="http://velocitypage.us3.list-manage2.com/subscribe/post?u=09a77cd3bd557143099c452ae&amp;id=ccf863aaf8" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			<h2>Add your form here</h2>
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

		// Row 3
		$row3 = $row_area->add_row( 'split-23-13', array( 'id' => 'third' ) );

		// Row 3 / Col 1
		$item_area = $row3->add_item_area( '67-percent', array( 'id' => 'default' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => '<p style="text-align: left;" data-mce-style="text-align: left;">“Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla condimentum mollis justo. Quisque consectetur justo nec turpis elementum consequat. Vestibulum eu mauris interdum<br><em><strong>John Doe</strong></em></p>' ) );

		// Row 3 / Col 2
		$item_area = $row3->add_item_area( '33-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-testimonial.png' ) );

		// .footer
		$p->add_field( 'p', array( 'id' => 'footer', 'value' => '© ' . date('Y') . '  Guidebook,  All rights reserved.' ) );
		$p->add_field( 'h4', array( 'id' => 'h4', 'value' => 'GUIDEBOOK' ) );
	}
}

$this->init_theme( new AdLabs_VP_Theme_Guidebook );
