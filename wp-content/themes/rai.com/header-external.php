<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Default title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.0/foundation.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/main.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=get_template_directory_uri()?>/bower_components/owl/owl-carousel/owl.carousel.css" media="screen" title="no title" charset="utf-8">
    <script type="text/javascript" src="<?=get_template_directory_uri()?>/js/jquery-2.1.4.min.js"></script>
    <!--<script type="text/javascript" src="--><?//=get_template_directory_uri()?><!--/bower_components/foundation/js/foundation.js"></script>-->
    <script type="text/javascript" src="http://eri.balakshii.com/wp-content/themes/eri/dist/bower_components/foundation-sites/dist/foundation.min.js?ver=4.5.3"></script>
    <script type="text/javascript" src="<?=get_template_directory_uri()?>/bower_components/owl/owl-carousel/owl.carousel.min.js"></script>
    <?wp_head()?>
</head>
<body <?php body_class("external page"); ?>>
<div class="off-canvas-wrapper">

    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

        <div data-responsive-toggle="widemenu" data-hide-for="medium" class="title-bar" style="display: block;">
            <button type="button" data-toggle="offCanvasLeft" class="menu-icon" aria-expanded="false" aria-controls="offCanvasLeft"></button>
            <div class="title-bar-title">
                <div class="logo"><a href="<?=pll_home_url(pll_current_language('slug'));?>"></a></div>
            </div>
            <ul data-dropdown-menu class="dropdown menu float-right">
                <li class="search"><a href="#"></a>
                    <ul class="language menu vertical">
                        <li>
                            <form method="post" action="/">
                                <input type="text" name="s" placeholder="Search">
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>

            <!-- Close button -->
            <button class="close-button show-for-small-only" aria-label="Close menu" type="button" data-close>
                <span aria-hidden="true">&times;</span>
            </button>

            <!-- Menu -->
            <?wp_nav_menu(["location"=>"header_menu","container"=>"","menu_class" => "dropdown menu float-left"])?>

            <ul data-dropdown-menu class="dropdown menu float-left">
                <li><a href="#"><?=pll_current_language("name")?></a>
                    <ul class="language menu vertical">
                        <?php pll_the_languages(array('show_flags'=>0,'show_names'=>1,'hide_current' => 1)); ?>
                    </ul>
                </li>

            </ul>

        </div>

        <div class="off-canvas-content" data-off-canvas-content>
<?if (get_field("thematic_image")) :?>
    <div id="header" style='background: #093d86 url("<?=get_field("thematic_image")["url"]?>") 50% 0 no-repeat'>
<?else:?>
        <div id="header">
<?endif?>
    <div class="top-bar hide-for-small-only">
        <div class="container">
            <div class="top-bar-left">
                <ul data-dropdown-menu class="dropdown menu">
                    <li class="logo"><a href="#"></a></li>
                </ul>
            </div>
            <div class="top-bar-right hide-for-small-only">
                <?wp_nav_menu(["location"=>"header_menu","container"=>"","menu_class" => "dropdown menu float-left"])?>

                <ul data-dropdown-menu class="dropdown menu float-left">
                    <li><a href="#"><?=pll_current_language("name")?></a>
                        <ul class="language menu vertical">
                            <?php pll_the_languages(array('show_flags'=>0,'show_names'=>1,'hide_current' => 1)); ?>
                        </ul>
                    </li>
                    <li class="search"><a href="#"></a>
                        <ul class="language menu vertical">
                            <li>
                                <form method="post" action="/">
                                    <input type="text" name="s" placeholder="Search">
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="quote">
            <h1>
                <?if(get_field("sub_title")) : ?>
                    <div class="sub-title">
                        <?the_field("sub_title")?>
                    </div>
                <?endif?>
                <?the_title()?>
            </h1>
            <hr class="show-for-small-only">
        </div>
        <?if (get_field("link_to_project")) : ?>
            <a href="<?the_field("link_to_project")?>" class="visit-site float-right hide-for-small-only">Vai al sito</a>
        <?endif?>
    </div>
</div>