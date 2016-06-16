<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Theme_Paper_Plane extends AdLabs_VP_Theme {
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
		$p->add_field( 'h1', array( 'id' => 'h1', 'value' => 'PAPER PLANE' ) );
		$p->add_field( 'h2', array( 'id' => 'h2', 'value' => 'Everything You Need to Create<br />a Successful Landing Page') );
		$row_area = $p->add_row_area( 'default', array( 'id' => 'header' ) );

		// .rows
		$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );

		// Row 1
		$row = $row_area->add_row( 'split-13-13-13', array( 'id' => 'default' ) );

		// Row 1 / Col 1
		$item_area = $row->add_item_area( '33-percent', array( 'id' => 'default' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-chart-blue.png' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Get The Stats' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'Since, in the long run, every planetary civilization will be endangered by impacts from space, every surviving civilization is obliged to become spacefaring–not because of exploratory or romantic zeal.' ) );

		// Row 1 / Col 2
		$item_area = $row->add_item_area( '33-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-gear-yellow.png' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Control Everything' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'The powered flight took a total of about eight and a half minutes. It seemed to me it had gone by in a lash. We had gone from sitting still on the launch pad at the Kennedy Space Center to traveling at 17,500.' ) );

		// Row 1 / Col 3
		$item_area = $row->add_item_area( '33-percent', array( 'id' => 'third' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-tick-green.png' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Team Management' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'If our long-term survival is at stake, we have a basic responsibility to our species to venture to other worlds. That’s one small step for [a] man; one giant leap for mankind. The powered flight took a total of about eight.' ) );

		// Row 2
		$row2 = $row_area->add_row( 'split-23-13', array( 'id' => 'second' ) );

		// Row 2 / Col 1
		$item_area = $row2->add_item_area( '67-percent', array( 'id' => 'default' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'First Call To Action' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'The powered flight took a total of about eight and a half minutes. It seemed to me it had gone by in a lash. We had gone from sitting still on the launch pad at the Kennedy Space Center to traveling at 17,500 miles an hour in that eight and a half minutes.

			It is still mind-boggling to me. I recall making some statement on the air-to-ground radio for the benefit of my fellow astronauts, who had also been in the program a long time, that it was well worth the wait.' ) );

		// Row 2 / Col 2
		$item_area = $row2->add_item_area( '33-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/image-iphone-white.png' ) );

		// Row 3
		$row3 = $row_area->add_row( 'split-13-23', array( 'id' => 'third' ) );

		// Row 3 / Col 1
		$item_area = $row3->add_item_area( '33-percent', array( 'id' => 'default' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-shield-blue.png' ) );

		// Row 3 / Col 2
		$item_area = $row3->add_item_area( '67-percent', array( 'id' => 'second' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'Security Enhanced Application' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'The powered flight took a total of about eight and a half minutes. It seemed to me it had gone by in a lash. We had gone from sitting still on the launch pad at the Kennedy Space Center to traveling at 17,500 miles an hour in that eight and a half minutes.

			It is still mind-boggling to me. I recall making some statement on the air-to-ground radio for the benefit of my fellow astronauts.' ) );

		// Row 4
		$row4 = $row_area->add_row( 'split-23-13', array( 'id' => 'fourth' ) );

		// Row 4 / Col 1
		$item_area = $row4->add_item_area( '67-percent', array( 'id' => 'default' ) );
		$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3' ) );
		$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'High Converting Landing Pages' ) );
		$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
		$text_item->add_field( 'p', array( 'id' => 'default', 'value' => 'The powered flight took a total of about eight and a half minutes. It seemed to me it had gone by in a lash. We had gone from sitting still on the launch pad at the Kennedy Space Center to traveling at 17,500 miles an hour in that eight and a half minutes.

			It is still mind-boggling to me. I recall making some statement on the air-to-ground radio for the benefit of my fellow astronauts.' ) );

		// Row 4 / Col 2
		$item_area = $row4->add_item_area( '33-percent', array( 'id' => 'second' ) );
		$image_item = $item_area->add_item( 'image', array( 'id' => 'image' ) );
		$image_item->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->theme->url . 'images/icon-dollar-green.png' ) );

		// Row 5 (Button)
		$row5 = $row_area->add_row( 'full-width', array( 'id' => 'fifth' ) );
		$item_area = $row5->add_item_area( '100-percent', array( 'id' => 'default' ) );

		$html_item = $item_area->add_item( 'html', array( 'id' => 'html' ) );
		$html_item->add_field( 'html', array( 'id' => 'default', 'value' => '<a href="http://velocitypage.com" class="button">Sign Up Now</a>' ) );

		// Footer
		$p->add_field( 'p', array( 'id' => 'footer', 'value' => '© 2013–' . date('Y') . '  Paper Plane' ) );
	}
}

$this->init_theme( new AdLabs_VP_Theme_Paper_Plane );
