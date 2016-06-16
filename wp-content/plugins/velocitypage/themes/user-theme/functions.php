<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Theme_User_Theme extends AdLabs_VP_Theme {
	public function __construct() {
	}

	public function bootstrap_data( &$p, $post ) {
		switch( $this->plugin()->layout ) {
			case 'contact':
				$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );

				// Start Here
				$row = $row_area->add_row( 'full-width', array( 'id' => 'default' ) );
					$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
						$h1_item = $item_area->add_item( 'h1', array( 'id' => 'h1' ) );
							$h1_item->add_field( 'h1', array( 'id' => 'default', 'value' => 'Contact' ) );

				// 67/33 Split with text/icon
				$row = $row_area->add_row( 'split-23-13', array( 'id' => 'split' ) );
					$left = $row->add_item_area( '67-percent', array( 'id' => 'default' ) );
						$text_item = $left->add_item( 'text', array( 'id' => 'text' ) );
							$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "Every site should have a contact page so that your visitors have a quick and easy way to send you an email.\n\nTo add your contact form, just select the custom HTML item and paste in email form code. Or, if you use GravityForms or a similar plugin, use the Shortcode item and paste in the shortcode that the plugin provides." ) );
					$right = $row->add_item_area( '33-percent', array( 'id' => 'second' ) );
						$logo = $right->add_item( 'image', array( 'id' => 'people', 'align' => 'center' ) );
							$logo->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->get_url() . 'img/layouts/assets/people.png' ) );

				// Contact form
				$row = $row_area->add_row( 'full-width', array( 'id' => 'contact' ) );
					$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
						$html_item = $item_area->add_item( 'html', array( 'id' => 'html', 'align' => 'center' ) );
							$html_item->add_field( 'html', array( 'id' => 'default', 'value' => '<form name="htmlform" method="post">
<table width="450px">
</tr>
<tr>
 <td valign="top">
  <label for="first_name">First Name</label>
 </td>
 <td valign="top">
  <input  type="text" name="first_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top"">
  <label for="last_name">Last Name</label>
 </td>
 <td valign="top">
  <input  type="text" name="last_name" maxlength="50" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="email">Email Address</label>
 </td>
 <td valign="top">
  <input  type="text" name="email" maxlength="80" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="telephone">Telephone Number</label>
 </td>
 <td valign="top">
  <input  type="text" name="telephone" maxlength="30" size="30">
 </td>
</tr>
<tr>
 <td valign="top">
  <label for="comments">Comments</label>
 </td>
 <td valign="top">
  <textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
 </td>
</tr>
<tr>
 <td colspan="2" style="text-align:center">
  <input type="submit" value="Submit">
 </td>
</tr>
</table>
</form>' ) );
				break;
			case 'start-here':
				$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );

				// Start Here
				$row = $row_area->add_row( 'full-width', array( 'id' => 'default' ) );
					$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
						$h1_item = $item_area->add_item( 'h1', array( 'id' => 'h1' ) );
							$h1_item->add_field( 'h1', array( 'id' => 'default', 'value' => 'Start Here' ) );

				// 50/50 Split with image/text
				$row = $row_area->add_row( 'split-12-12', array( 'id' => 'split' ) );
					$left = $row->add_item_area( '50-percent', array( 'id' => 'default' ) );
						$text_item = $left->add_item( 'text', array( 'id' => 'text' ) );
							$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "A 'Start Here' page is designed to help orient new visitors on your site. It could have a video explaining who you are and whate your page is about. Watch the video to see how to easily add a YouTube video to your page." ) );
					$right = $row->add_item_area( '50-percent', array( 'id' => 'second' ) );
						$text_item = $right->add_item( 'media', array( 'id' => 'youtube' ) );
							$text_item->add_field( 'media', array( 'id' => 'default', 'value' => "https://www.youtube.com/watch?v=HTUaxv1lJ3E" ) );

				// Full width text
				$row = $row_area->add_row( 'full-width', array( 'id' => 'full' ) );
					$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
						$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
							$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "Another great component to add to a 'Start Here' page is a list of the resources on your website that you think would help a new visitor most.\n\nYou can add a few categorized lists, or just one." ) );

				// 50/50 split link list
				$row = $row_area->add_row( 'split-12-12', array( 'id' => 'split2' ) );
					$left = $row->add_item_area( '50-percent', array( 'id' => 'default' ) );
						$h2_item = $left->add_item( 'h2', array( 'id' => 'h2' ) );
							$h2_item->add_field( 'h2', array( 'id' => 'default', 'value' => 'Business posts' ) );
						$text_item = $left->add_item( 'text', array( 'id' => 'text' ) );
							$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "<ul><li><a href='#started'>13 Business secrets</a></li><li><a href='#pricing'>Getting pricing right</a></li><li><a href='#features'>Feature planning tips</a></li></ul>" ) );
					$right = $row->add_item_area( '50-percent', array( 'id' => 'second' ) );
						$h2_item = $right->add_item( 'h2', array( 'id' => 'h2' ) );
							$h2_item->add_field( 'h2', array( 'id' => 'default', 'value' => 'Training resources' ) );
						$text_item = $right->add_item( 'text', array( 'id' => 'text' ) );
							$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "<ul><li><a href='#started'>Getting started</a></li><li><a href='#working'>Working with XYZ corp</a></li><li><a href='#balance'>Maintaining work/life balance</a></li></ul>" ) );

				break;
			case 'about':
				$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );

				// About
				$row = $row_area->add_row( 'full-width', array( 'id' => 'default' ) );
					$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
						$h1_item = $item_area->add_item( 'h1', array( 'id' => 'h1' ) );
							$h1_item->add_field( 'h1', array( 'id' => 'default', 'value' => 'About XYZ' ) );

				// 50/50 Split with image/text
				$row = $row_area->add_row( 'split-12-12', array( 'id' => 'split' ) );
					$left = $row->add_item_area( '50-percent', array( 'id' => 'default' ) );
						$logo = $left->add_item( 'image', array( 'id' => 'building', 'align' => 'center' ) );
							$logo->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->get_url() . 'img/layouts/assets/building.jpg' ) );
					$right = $row->add_item_area( '50-percent', array( 'id' => 'second' ) );
						$text_item = $right->add_item( 'text', array( 'id' => 'text' ) );
							$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "My name is {your name}, co-founder of XYZ. We created XYZ for reasons. Now we do things.\n\nXYZ enables you to do things, listed here: thing, another thing, and last thing.\n\n<em>It's great to start your About page with a 2-column row with an image and introductory text." ) );

				// My Story row
				$row = $row_area->add_row( 'full-width', array( 'id' => 'row2' ) );
					$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
						$h1_item = $item_area->add_item( 'h1', array( 'id' => 'h1' ) );
							$h1_item->add_field( 'h1', array( 'id' => 'default', 'value' => 'Our Story' ) );
						$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
							$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "The second component of a great About page is to share more information about who you are and your background in this business.\n\nThis story can be short or a bit longer — it's up to you. The idea is to be 100% honest and passionate about what you're doing.\n\nFor your story, a simple 1-column row like you see here should do the trick." ) );
				break;
			case 'signup':
				$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );
				$row = $row_area->add_row( 'full-width', array( 'id' => 'default' ) );
				$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
				$h1_item = $item_area->add_item( 'h1', array( 'id' => 'h1', 'align' => 'center' ) );
				$h1_item->add_field( 'h1', array( 'id' => 'default', 'value' => 'Subscribe to the XYZ newsletter today' ) );
				$row2 = $row_area->add_row( 'split-12-12', array( 'id' => 'signup' ) );
				$col1 = $row2->add_item_area( '50-percent', array( 'id' => 'default' ) );
				$col2 = $row2->add_item_area( '50-percent', array( 'id' => 'second' ) );
				$text_item = $col1->add_item( 'text', array( 'id' => 'text' ) );
				$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "If you have a newsletter or you are building an email list to be able to stay in touch with your audience, then you should have a sign up page like this one.\n\nTo add your sign up form, you can choose the MailChimp, AWeber, or Custom HTML items, and paste in the code from your newsletter provider." ) );
				$html_item = $col2->add_item( 'html', array( 'id' => 'html', 'align' => 'left' ) );
				$html_item->add_field( 'html', array( 'id' => 'default', 'value' => '<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="//velocitypage.us3.list-manage.com/subscribe/post?u=09a77cd3bd557143099c452ae&amp;id=ccf863aaf8" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	<h2>Sign up to get the goods</h2>
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
    </div>
</form>
</div>
<script src="//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js"></script><script>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]=\'EMAIL\';ftypes[0]=\'email\';fnames[1]=\'FNAME\';ftypes[1]=\'text\';}(jQuery));var $mcj = jQuery.noConflict(true);</script><!--End mc_embed_signup-->' ) );
				$row3 = $row_area->add_row( 'full-width', array( 'id' => 'row3' ) );
				$item_area = $row3->add_item_area( '100-percent', array( 'id' => 'default' ) );
				$h2_item = $item_area->add_item( 'h2', array( 'id' => 'h2', 'align' => 'center' ) );
				$h2_item->add_field( 'h2', array( 'id' => 'default', 'value' => 'What will you get when you sign up?' ) );
				$row4 = $row_area->add_row( 'split-13-23', array( 'id' => 'default' ) );
				$col4_1 = $row4->add_item_area( '33-percent', array( 'id' => 'default' ) );
				$col4_2 = $row4->add_item_area( '67-percent', array( 'id' => 'second' ) );
				$logo = $col4_1->add_item( 'image', array( 'id' => 'vp', 'align' => 'center' ) );
				$logo->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->get_url() . 'img/logo-128x128.png' ) );
				$text_item = $col4_2->add_item( 'text', array( 'id' => 'text' ) );
				$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "This is another example of a 2-column split row like the one above. However, in this one the left column is a little smaller than the right." ) );

				$row4 = $row_area->add_row( 'full-width', array( 'id' => 'row4' ) );
				$item_area = $row4->add_item_area( '100-percent', array( 'id' => 'default' ) );
				$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
				$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "So we didn’t do anything too extreme with this page. It just starts with a good headline, followed by 2 rows. You can fill in your content in each text box, and you can move the rows where you want by hovering over the right corner and drag-and-dropping the row.\n\nA good sign up page should focus on the following:\n\n<ul><li>Capture your audience’s attention</li><li>Clearly and concisely explain the value of signing up</li><li>Have a strong call to action</li><li>Build trust and establish credibility</li><li>(to add bullet points, just add your text, select it, and click the \"Bulleted List\" icon)" ) );
				break;
			case 'thank-you':
			 	$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );
				$row = $row_area->add_row( 'full-width', array( 'id' => 'default' ) );
				$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
				$h1_item = $item_area->add_item( 'h1', array( 'id' => 'h1', 'align' => 'center' ) );
				$h1_item->add_field( 'h1', array( 'id' => 'default', 'value' => 'Thank you for purchasing XYZ' ) );
				$h3_item = $item_area->add_item( 'h3', array( 'id' => 'h3', 'align' => 'center' ) );
				$h3_item->add_field( 'h3', array( 'id' => 'default', 'value' => 'To get started, just click below to download' ) );
				$html_item = $item_area->add_item( 'html', array( 'id' => 'html', 'align' => 'center' ) );
				$html_item->add_field( 'html', array( 'id' => 'default', 'value' => '<p><a href="#"><img src="' . $this->plugin()->get_url() . 'img/layouts/assets/download.png" /></a></p>' ) );
				$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
				$text_item->add_field( 'p', array( 'id' => 'default', 'value' => "Your thank you page is something that your visitor will see after they take an action: subscribe to your email list or make a purchase, for example.\n\nYou can also spruce up the page a bit by adding your social media buttons in a 3-column row. To add your links to an image, just hover over an image and choose the link option that will appear." ) );
				$row2 = $row_area->add_row( 'split-13-13-13', array( 'id' => 'social' ) );
				$col1 = $row2->add_item_area( '33-percent', array( 'id' => 'default' ) );
				$col2 = $row2->add_item_area( '33-percent', array( 'id' => 'second' ) );
				$col3 = $row2->add_item_area( '33-percent', array( 'id' => 'third' ) );

				$twitter = $col1->add_item( 'image', array( 'id' => 'twitter', 'align' => 'center' ) );
				$twitter->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->get_url() . 'img/layouts/assets/twitter.png', 'url' => 'https://twitter.com/' ) );
				$twitter_cap = $col1->add_item( 'h3', array( 'id' => 'twitter-h3', 'align' => 'center' ) );
				$twitter_cap->add_field( 'h3', array( 'id' => 'default', 'value' => 'Follow us on Twitter' ));

				$facebook = $col2->add_item( 'image', array( 'id' => 'facebook', 'align' => 'center' ) );
				$facebook->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->get_url() . 'img/layouts/assets/facebook.png', 'url' => 'https://facebook.com/' ) );
				$facebook_cap = $col2->add_item( 'h3', array( 'id' => 'facebook-h3', 'align' => 'center' ) );
				$facebook_cap->add_field( 'h3', array( 'id' => 'default', 'value' => 'Like us on Facebook' ));

				$email = $col3->add_item( 'image', array( 'id' => 'email', 'align' => 'center' ) );
				$email->add_field( 'img', array( 'id' => 'image', 'value' => $this->plugin()->get_url() . 'img/layouts/assets/email.png', 'url' => '#newsletter-page' ) );
				$email_cap = $col3->add_item( 'h3', array( 'id' => 'email-h3', 'align' => 'center' ) );
				$email_cap->add_field( 'h3', array( 'id' => 'default', 'value' => 'Newsletter sign up' ));
				break;
			default:
				$row_area = $p->add_row_area( 'default', array( 'id' => 'default' ) );
				$row = $row_area->add_row( 'full-width', array( 'id' => 'default' ) );
				$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
				$h1_item = $item_area->add_item( 'h1', array( 'id' => 'h1' ) );
				$h1_item->add_field( 'h1', array( 'id' => 'default', 'value' => $post->post_title ) );
				$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
				$text_item->add_field( 'p', array( 'id' => 'default', 'value' => $post->post_content ) );
		}
		if ( ! empty( $this->plugin()->layout ) && ! empty( $post->post_content ) ) {
			// Add the original content
			$row = $row_area->add_row( 'full-width', array( 'id' => 'original-content' ) );
			$item_area = $row->add_item_area( '100-percent', array( 'id' => 'default' ) );
			$h1_item = $item_area->add_item( 'h1', array( 'id' => 'h1' ) );
			$h1_item->add_field( 'h1', array( 'id' => 'default', 'value' => 'Your Content' ) );
			$text_item = $item_area->add_item( 'text', array( 'id' => 'text' ) );
			$text_item->add_field( 'p', array( 'id' => 'default', 'value' => $post->post_content ) );
		}
	}
}

$this->init_theme( new AdLabs_VP_Theme_User_Theme );
