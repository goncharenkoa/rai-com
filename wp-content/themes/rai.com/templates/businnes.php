<?php
/*
Template Name: Business
*/
?>
<?get_header("external")?>
    <main role="main" class="main">
        <?if(have_rows("two_column")) : the_row()?>
            <section id="two-columns">
                <div class="container">
                    <div class="icon hide-for-small-only"></div>
                    <h2><?the_sub_field("title")?></h2>
                    <div class="row">
                        <?if (have_rows("column")) : while (have_rows("column")) : the_row()?>
                            <div class="medium-6 large-6 columns">
                                <div class="text">
                                    <?the_sub_field("text")?>
                                </div>
                            </div>
                        <?endwhile;endif?>
                    </div>
                </div>
            </section>
        <?endif?>
        <?if (have_rows("graph_one")) : the_row()?>
            <section id="convention_first" class="simple">
                <div class="container">
                    <h2><?the_sub_field("title")?></h2>
                    <div class="text">
                        <?the_sub_field("description")?>
                    </div>
                    <img src="<?=get_sub_field("image")["url"]?>">
                </div>
            </section>
        <?endif;?>
        <?if (have_rows("graph_two")) : the_row()?>
            <section  class="simple">
                <div class="container">
                    <h2><?the_sub_field("title")?></h2>
                    <div class="text">
                        <?the_sub_field("description")?>
                    </div>
                    <img src="<?=get_sub_field("image")["url"]?>">
                </div>
            </section>
        <?endif;?>
        <?if (get_field("gallery")) :?>
            <section id="gallery">
                <div class="container">
                    <h2>Case history</h2>
                    <div class="owl-carousel">
                        <?foreach(get_field("gallery") as $item) :?>
                            <img src="<?=$item["url"]?>">
                        <?endforeach;?>
                    </div>
                </div>
            </section>
        <?endif;?>
    </main>
<?get_footer()?>
