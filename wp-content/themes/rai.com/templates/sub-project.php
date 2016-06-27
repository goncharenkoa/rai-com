<?php
/*
Template Name: Sub-project
*/
?>
<?get_header("external")?>
<main role="main" class="main">
    <section id="two-columns" class="hide-for-small-only">
        <div class="container">
            <div class="icon hide-for-small-only" style='background: url("<?=get_field("icon")["url"]?>")'></div>
            <?if (have_rows("two_columns")) : the_row()?>
                <h2><?the_title()?></h2>
                <div class="row">
                    <?if (have_rows("column")) : while(have_rows("column")) : the_row()?>
                        <div class="medium-6 large-6 columns">
                            <div class="text">
                                <?the_sub_field("text")?>
                            </div>
                        </div>
                    <?endwhile;endif?>
                </div>
            <?endif?>
        </div>
    </section>
    <?if (get_field("screenshot")) : ?>
    <section id="preview">
        <div class="preview-mob-text show-for-small-only">
            <h2><?the_field("mobile_title_before_screenshot")?></h2>
            <p>
                <?the_field("mobile_text_before_screenshot")?>
            </p>
        </div>
        <div class="browser">
            <img src="<?=get_field("screenshot")["url"]?>">
        </div>
        <div class="preview-mob-text show-for-small-only">
        <p><?the_field("mobile_text_after_screenshot")?></p>
        </div>
        <?if (get_field("link_to_project")) : ?>
            <a href="<?the_field("link_to_project")?>" class="visit-site show-for-small-only">Vai al sito</a>
        <?endif?>
    </section>
    <?endif?>
    <section id="two-columns">
        <div class="container">
            <?if (have_rows("two_columns_second")) : the_row()?>
                <h2><?the_title()?></h2>
                <div class="row">
                    <?if (have_rows("column")) : while(have_rows("column")) : the_row()?>
                        <div class="medium-6 large-6 columns">
                            <div class="text">
                                <?the_sub_field("text")?>
                            </div>
                        </div>
                    <?endwhile;endif?>
                </div>
            <?endif?>
        </div>
    </section>
    <section class="icon-list clearfix">
        <?if (have_rows("special_pages",pll_current_language('slug'))) : while(have_rows("special_pages",pll_current_language('slug'))) : the_row()?>
        <a href="<?the_sub_field("url")?>" class="item">
            <div class="icon-wrapper">
                <img src="<?=get_sub_field("icon")["url"]?>" alt="">
            </div>
            <div><?the_sub_field("title")?></div>
        </a>
        <?endwhile;endif?>
    </section>
</main>
<?get_footer()?>
