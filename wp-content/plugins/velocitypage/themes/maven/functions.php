<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Theme_Maven extends AdLabs_VP_Theme {
	public function __construct() {
	}

	public function ensure_data( &$page ) {
		$page->add_field( 'h1', array( 'id' => 'h1' ) );
		$page->add_field( 'h2', array( 'id' => 'h2' ) );
		$page->add_field( 'p', array( 'id' => 'footer' ) );
		$page->add_row_area( 'default', array( 'id' => 'default' ) );
		$page->add_row_area( 'default', array( 'id' => 'header' ) );
	}

	public function bootstrap_data( &$p, $post ) {
		// .header
		$p->add_field( 'h1', array( 'id' => 'h1', 'value' => 'Maven' ) );
		$p->add_field( 'h2', array( 'id' => 'h2', 'value' => 'A really simple<br />landing page design' ) );
		$row_area = $p->add_row_area( 'default', array( 'id' => 'header' ) );

		// .rows
		$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );

		// Row 1
		$row = $row_area->add_row( 'split-13-23', array( 'id' => 'default' ) );

		// Row 1 / Col 1
		$item_area = $row->add_item_area( '33-percent', array( 'id' => 'default' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'What is Maven' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'With Maven you can quickly and easily create  landing page types, control fonts, colors, and styles without code, included custom graphics, and copywriting advice from the WordPress interface. Its amazing!' ) );
		$html_item = $item_area->add_item( 'html', array( 'id' => 'html' ) );
		$html_item->add_field( 'html', array( 'id' => 'default', 'value' => '<a href="http://velocitypage.com" class="button">Get The Plugin Now</a>' ) );

		// Row 1 / Col 2
		$item_area = $row->add_item_area( '67-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-book.png' ) );

		// Row 2
		$row2 = $row_area->add_row( 'split-13-13-13', array( 'id' => 'second' ) );

		// Row 2 / Col 1
		$item_area = $row2->add_item_area( '33-percent', array( 'id' => 'default' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-people-circle.png' ) );
		$h4_item = $item_area->add_item( 'h4', array( 'id' => 'h4' ) );
		$h4_item->add_field( 'h4', array( 'id' => 'default', 'value' => 'Get Connected') );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'With Maven you can quickly and easily create landing page types, control fonts, colors, and styles without code, included custom graphics, and copywriting advice from the WordPress interface. Its Amazing!' ) );

		// Row 2 / Col 2
		$item_area = $row2->add_item_area( '33-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-tick-circle.png' ) );
		$h4_item = $item_area->add_item( 'h4', array( 'id' => 'h4' ) );
		$h4_item->add_field( 'h4', array( 'id' => 'default', 'value' => 'Browser Compatible' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'That’s a big claim, does it really work? Yes it does and has been given 5 out of 5 stars on all the reviews we’ve seen so far, so download it now and let us know what you think.' ) );

		// Row 2 / Col 3
		$item_area = $row2->add_item_area( '33-percent', array( 'id' => 'third' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-brush-pen-circle.png' ) );
		$h4_item = $item_area->add_item( 'h4', array( 'id' => 'h4' ) );
		$h4_item->add_field( 'h4', array( 'id' => 'default', 'value' => 'Customizable' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'Who is this app aimed at?
			Everyone who could possibly need to do anything! It really is the full experience. This app does everything you could possibly want it to do and not only that, it is beautifully designed.' ) );

		// Row 3
		$row3 = $row_area->add_row( 'full-width', array( 'id' => 'third' ) );

		$item_area = $row3->add_item_area( '100-percent', array( 'id' => 'default' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'What our customers are saying' ) );

		// Row 4
		$row4 = $row_area->add_row( 'split-13-13-13', array( 'id' => 'fourth' ) );

		// Row 4 / Col 1
		$item_area = $row4->add_item_area( '33-percent', array( 'id' => 'default' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-person-1.png' ) );
		$h4_item = $item_area->add_item( 'h4', array( 'id' => 'h4' ) );
		$h4_item->add_field( 'h4', array( 'id' => 'default', 'value' => 'Annie Adams' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'We bought the plugin for our website and I must say I’m happy with the team handling my numerous requests. Keep up the good work.' ) );

		// Row 4 / Col 2
		$item_area = $row4->add_item_area( '33-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-person-2.png' ) );
		$h4_item = $item_area->add_item( 'h4', array( 'id' => 'h4' ) );
		$h4_item->add_field( 'h4', array( 'id' => 'default', 'value' => 'Bob Brydon' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'The experience with this plugin has been great. I had a few support questions that got quick attention. We really liked the flow of the plugin and with a few tweaks we made it are own.' ) );

		// Row 4 / Col 3
		$item_area = $row4->add_item_area( '33-percent', array( 'id' => 'third' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-person-3.png' ) );
		$h4_item = $item_area->add_item( 'h4', array( 'id' => 'h4' ) );
		$h4_item->add_field( 'h4', array( 'id' => 'default', 'value' => 'Claire Campbell' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'The plugin is able to balance impressive web design with well thought out features, backed with great support.' ) );

		// Footer
		$p->add_field( 'p', array( 'id' => 'footer', 'value' => '© 2013–' . date('Y') . '  Maven' ) );

	}
}

$this->init_theme( new AdLabs_VP_Theme_Maven );
