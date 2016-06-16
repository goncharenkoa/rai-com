<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Theme_Ronnia extends AdLabs_VP_Theme {
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
		$p->add_field( 'h1', array( 'id' => 'h1', 'value' => 'Ronnia' ) );
		$p->add_field( 'h2', array( 'id' => 'h2', 'value' => 'A video landing page' ) );
		$row_area = $p->add_row_area( 'default', array( 'id' => 'header' ) );

		// Row 1
		$row = $row_area->add_row( 'full-width', array( 'id' => 'header' ) );

		$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
		$h1_item = $item_area->add_item( 'media', array( 'id' => 'media' ) );
		$h1_item->add_field( 'media', array( 'id' => 'default', 'value' => 'http://vimeo.com/40548631' ) );

		// .rows
		$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );

		// Row 2
		$row2 = $row_area->add_row( 'full-width', array( 'id' => 'second' ) );

		$item_area = $row2->add_item_area( '100-percent', array( 'id' => 'default' ) );
		$h2_item = $item_area->add_item( 'h2', array( 'id' => 'h2' ) );
		$h2_item->add_field( 'h2', array( 'id' => 'default', 'value' => 'Discover & Be Discovered' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'Create & Discover Content You’re Passionate About' ) );

		// Row 3
		$row3 = $row_area->add_row( 'split-23-13', array( 'id' => 'third' ) );

		// Row 3 / Col 1
		$item_area = $row3->add_item_area( '33-percent', array( 'id' => 'default' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Access your life, wherever you are.' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'No need to be in the office to get work done. Just access your desktop files and applications on your tablet, wherever you feel like it.' ) );

		// Row 3 / Col 2
		$item_area = $row3->add_item_area( '67-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-people.png' ) );

		// Row 4
		$row4 = $row_area->add_row( 'split-13-23', array( 'id' => 'fourth' ) );

		// Row 4 / Col 1
		$item_area = $row4->add_item_area( '33-percent', array( 'id' => 'default' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-iphone.png' ) );

		// Row 4 / Col 2
		$item_area = $row4->add_item_area( '67-percent', array( 'id' => 'second' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Landing pages designed for you.' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'We are a fairly small, flexible design studio that designs for print and web. We work flexibly with clients to fulfil their design needs. Whether you need to create a brand from scratch.' ) );

		// .footer
		$p->add_field( 'p', array( 'id' => 'footer', 'value' => '© 2013–' . date('Y') . '  Ronnia' ) );
	}
}

$this->init_theme( new AdLabs_VP_Theme_Ronnia );
