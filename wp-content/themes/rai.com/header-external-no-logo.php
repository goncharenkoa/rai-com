<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Default title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.0/foundation.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=get_template_directory_uri()?>/css/main.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=get_template_directory_uri()?>/bower_components/owl/owl-carousel/owl.carousel.css" media="screen" title="no title" charset="utf-8">
    <script type="text/javascript" src="<?=get_template_directory_uri()?>/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?=get_template_directory_uri()?>/bower_components/foundation/js/foundation.js"></script>
    <script type="text/javascript" src="<?=get_template_directory_uri()?>/bower_components/owl/owl-carousel/owl.carousel.min.js"></script>
    <?wp_head()?>
</head>
<body <?php body_class("external page"); ?>>

        <div id="header" style="background: none">

    <div class="top-bar">
        <div class="container">
            <div class="top-bar-left">
                <ul data-dropdown-menu class="dropdown menu">
                    <li class="logo"><a href="#"></a></li>
                </ul>
            </div>
            <div class="top-bar-right hide-for-small-only hide-for-medium-only">
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
        </div>
        <?if (get_field("link_to_project")) : ?>
            <a href="<?the_field("link_to_project")?>" class="visit-site float-right">Vai al sito</a>
        <?endif?>
    </div>
</div>