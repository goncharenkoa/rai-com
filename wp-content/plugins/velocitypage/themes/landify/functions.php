<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Theme_Landify extends AdLabs_VP_Theme {
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
		$p->add_field( 'h1', array( 'id' => 'h1', 'value' => 'Landify' ) );
		$row_area = $p->add_row_area( 'default', array( 'id' => 'header' ) );

		// Row 1
		$row = $row_area->add_row( 'full-width', array( 'id' => 'header' ) );

		$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
		$h2_item = $item_area->add_item( 'h2', array( 'id' => 'h2' ) );
		$h2_item->add_field( 'h2', array( 'id' => 'default', 'value' => 'A Great Landing Page Layout' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'We are excited to launch our new company and product Ooooh
			Browse our site and see for yourself why you need Ooooh' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/background-header.png' ) );

		// .rows
		$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );

		// Row 2
		$row2 = $row_area->add_row( 'full-width', array( 'id' => 'second' ) );

		$item_area = $row2->add_item_area( '100-percent', array( 'id' => 'default' ) );
		$h2_item = $item_area->add_item( 'h2', array( 'id' => 'h2' ) );
		$h2_item->add_field( 'h2', array( 'id' => 'default', 'value' => 'Landing Pages Like No Other' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'You may have seen us in the Dinosaurs’ Den where we were we told that we
		didn’t need them because we were already doing it so well ourselves.' ) );

		// Row 3
		$row3 = $row_area->add_row( 'split-13-13-13', array( 'id' => 'third' ) );

		// Row 3 / Col 1
		$item_area = $row3->add_item_area( '33-percent', array( 'id' => 'default' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-box.png' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Out Of The Box' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Quisque ultricies, ante at luctus imperdiet.' ) );

		// Row 3 / Col 2
		$item_area = $row3->add_item_area( '33-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-lightning.png' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Lightning Fast' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Quisque ultricies, ante at luctus imperdiet.' ) );

		// Row 3 / Col 3
		$item_area = $row3->add_item_area( '33-percent', array( 'id' => 'third' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-arrow.png' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Extremely Intuitive' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Quisque ultricies, ante at luctus imperdiet.' ) );

		// Row 4
		$row4 = $row_area->add_row( 'full-width', array( 'id' => 'fourth' ) );

		$item_area = $row4->add_item_area( '100-percent', array( 'id' => 'default' ) );
		$h2_item = $item_area->add_item( 'h2', array( 'id' => 'h2' ) );
		$h2_item->add_field( 'h2', array( 'id' => 'default', 'value' => 'What Our Customers Think Of Us' ) );

		// Row 5
		$row5 = $row_area->add_row( 'split-13-13-13', array( 'id' => 'fifth' ) );

		// Row 5 / Col 1
		$item_area = $row5->add_item_area( '33-percent', array( 'id' => 'default' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-person-1-crop.png' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => '“It’s just brilliant. I will recommend Ooooh to everyone I know!” A. Girl.' ) );

		// Row 5 / Col 2
		$item_area = $row5->add_item_area( '33-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-person-2-crop.png' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => '“Ooooh. That says it all really. Jim.' ) );

		// Row 5 / Col 3
		$item_area = $row5->add_item_area( '33-percent', array( 'id' => 'third' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-person-3-crop.png' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => '“What a product. Why didn’t someone think of it sooner?” Red.' ) );

		// .footer
		$p->add_field( 'p', array( 'id' => 'footer', 'value' => '© 2013–' . date('Y') . '  Landify' ) );
	}
}

$this->init_theme( new AdLabs_VP_Theme_Landify );
