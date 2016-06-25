<?php
/*
Template Name: Sub-project
*/
?>
<?get_header("external")?>
<main role="main" class="main">
    <section id="two-columns">
        <div class="container">
            <div class="icon" style='background: url("<?=get_field("icon")["url"]?>")'></div>
            <?if (have_rows("two_columns")) : the_row()?>
                <h2><?the_title()?></h2>
                <div class="row">
                    <?if (have_rows("column")) : while(have_rows("column")) : the_row()?>
                        <div class="large-6 columns">
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
        <div class="browser"><img src="<?=get_field("screenshot")["url"]?>"></div>
    </section>
    <?endif?>
    <section id="two-columns">
        <div class="container">
            <?if (have_rows("two_columns_second")) : the_row()?>
                <h2><?the_title()?></h2>
                <div class="row">
                    <?if (have_rows("column")) : while(have_rows("column")) : the_row()?>
                        <div class="large-6 columns">
                            <div class="text">
                                <?the_sub_field("text")?>
                            </div>
                        </div>
                    <?endwhile;endif?>
                </div>
            <?endif?>
        </div>
    </section>
    <section class="icon-list">
        <?if (have_rows("special_pages",pll_current_language('slug'))) : while(have_rows("special_pages",pll_current_language('slug'))) : the_row()?>
        <a href="<?the_sub_field("url")?>" class="item">
            <img src="<?=get_sub_field("icon")["url"]?>" alt="">
            <div><?the_sub_field("title")?></div>
        </a>
        <?endwhile;endif?>
    </section>
</main>
<?get_footer()?>
