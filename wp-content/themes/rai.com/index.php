//first anna commit
<?get_header()?>
<main role="main">
    <?if(have_rows('video') ) : the_row();?>
        <section id="video">
            <div class="container">
                <div class="row">
                    <div class="large-6 columns">
                        <div class="video-link"><a href="<?the_sub_field("video_url")?>" class="various fancybox.iframe go-to-video"></a></div>
                    </div>
                    <div class="large-6 columns">
                        <div class="video-description">
                            <h2><?the_sub_field("video_title")?></h2>
                            <div class="description">
                                <?the_sub_field("video_description")?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?endif;?>
    <?if(have_rows('types_of_business') ) : the_row();?>
        <section id="business">
        <div class="container">
            <div class="shadow left"></div>
            <div class="shadow right"></div>
            <div class="shadow bot-left"></div>
            <div class="shadow bot-right"></div>
            <div class="wrap">
                <div class="row">
                    <div class="large-6 columns">
                        <div class="about">
                            <h2><?the_sub_field("title")?></h2>
                            <div class="description">
                                <?the_sub_field("description")?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?if(have_rows('business') ) :?>
                        <?while ( have_rows('business') ) : the_row();?>
                            <div class="large-3 columns specification">
                                <a href="<?the_sub_field("link")?>" onmouseover="$(this).find('.icon').css('background-image','url(' + <?=get_sub_field("icon-hover")["url"]?> + ')')">
                                    <div class="icon" style="background: url('<?=get_sub_field("icon")["url"]?>');width:<?=get_sub_field("icon")["width"];?>;height:<?=get_sub_field("icon")["height"]?>"></div>
                                    <div class="title"><?=get_sub_field("page")->post_title?></div>
                                    <div class="description"><?the_sub_field("description")?></div>
                                </a>
                            </div>
                        <?endwhile;?>
                    <?endif;?>
                </div>
            </div>
        </div>
    </section>
    <?endif;?>
    <?if(have_rows('international_sales') ) : the_row();?>
        <section id="sales">
            <div class="container">
                <div class="about">
                    <h2 class="float-left"><?the_sub_field("title")?></h2><a href="<?the_sub_field("link_to_site")?>" class="float-right">Visita il sito <strong>International Sales</strong></a>
                    <div class="clearfix"></div>
                    <div class="description">
                        <?the_sub_field("description")?>
                    </div>
                </div>
                <div class="mosaicflow">
                    <?$postI = 0;if (have_rows("post")) : while(have_rows("post")) : the_row();$postI++?>
                    <a href="<?the_sub_field("url")?>" class="mosaic-item item-<?=$postI?>">
                        <img  src="<?=get_sub_field("cover")?>">
                        <div class="info">
                            <?if (get_sub_field("title")):?>
                            <h3><?the_sub_field("title")?></h3>
                            <?endif;?>
                            <?if(get_sub_field("sub_title")):?>
                            <div class="sub-title"><?the_sub_field("sub_title")?></div>
                            <?endif;?>
                            <?if (have_rows("partners")):?>
                            <div class="partners">
                                <?while(have_rows("partners")):the_row()?>
                                <div class="img"><img  src="<?=get_sub_field("partner")["url"]?>"></div>
                                <?endwhile;?>
                            </div>
                            <?endif;?>
                        </div>
                    </a>
                    <?endwhile;endif;?>

                </div>

            </div>
        </section>
    <?endif;?>
    <?if(have_rows('italiano') ) : the_row();?>
        <section id="italian">
            <div class="container">
                <div class="about">
                    <h2><?=get_sub_field("page")->post_title?></h2>
                    <div class="sub-title"><?the_sub_field("sub_title")?></div>
                    <div class="description">
                        <?the_sub_field("description")?>
                    </div><a href="<?the_permalink(get_sub_field("page")) ?>" class="more">Sfoglia online</a>
                </div>
            </div>
        </section>
    <?endif;?>
    <section id="shop" ng-app="raiEri">
        <div class="container" ng-controller="LastItemsController" repeat-end="onEnd()">
            <h2 class="float-left">rai eri<br> Libri e magazine</h2><a class="go-to float-right">Visita il sito RaiEri</a>
            <div class="clearfix"></div>
            <div class="owl-carousel" style="display: block">
                <div ng-repeat="book in books" class="book" ><img width="175" height="280"  ng-src="{{book.cover}}">
                    <div class="author">{{book.author}}</div>
                    <div class="title">{{book.title}}</div><a href="{{book.url}}" class="buy">Apri</a>
                </div>

            </div>
        </div>
    </section>
    <?
        $news = new WP_Query(["post_type" => "post"]);
        if ($news->have_posts()) :
    ?>
        <section id="news">
            <div class="container">
                <h2>Eventi & news</h2>
                <div class="owl-carousel">
                    <?while ($news->have_posts()) : $news->the_post();?>
                        <?if (get_field("show_on_slider")) : ?>
                            <a href="<?the_permalink()?>" class="news">
                                <?if (get_field("announce_img")):?>
                                    <img title="<?=get_field("announce_img")["title"]?>" src="<?=get_field("announce_img")["sizes"]["news-announce"]?>" width="<?=get_field("announce_img")["sizes"]["news-announce-width"]?>" height="<?=get_field("announce_img")["sizes"]["news-announce-height"]?>">
                                <?else :?>
                                    <img src="<?=get_template_directory_uri()?>/img/home/news.jpg">
                                <?endif;?>
                                <div class="title"><?the_title()?></div>
                                <div class="date"><?the_time("d M Y")?></div>
                                <div class="description">
                                    <?the_field("announce")?>
                                </div>
                            </a>
                        <?endif;?>
                    <?endwhile;?>
                </div>
            </div>
        </section>
    <?endif;wp_reset_postdata();?>
</main>
<?get_footer()?>