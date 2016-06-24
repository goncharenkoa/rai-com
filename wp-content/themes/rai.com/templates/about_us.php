<?php
/*
Template Name: About-us
*/
?>
<?get_header("external")?>
    <main role="main" class="main">
        <?if(have_rows("two_columns")) : the_row()?>
            <section id="two-columns">
                <div class="container">
                    <h2>
                        <?the_sub_field("title")?>
                    </h2>
                    <div class="row">
                        <?if (have_rows("column")) : while(have_rows("column")) : the_row()?>
                            <div class="large-6 columns">
                                <div class="text">
                                    <?the_sub_field("text")?>
                                </div>
                            </div>
                        <?endwhile;endif;?>
                    </div>
                </div>
            </section>
        <?endif;?>
        <?if(get_field("video")):?>
            <section id="video">
                <div class="container">
                    <iframe src="<?the_field("video")?>"></iframe>
                </div>
            </section>
        <?endif?>
        <?if (get_field("history")) :?>
            <section id="history" class="hide-for-small-only" style='background: url("<?=get_field("history")["url"]?>") 50% 0 no-repeat'></section>
        <?endif?>
        <section id="history-mobile" class="show-for-small-only">
            <h2>Storia</h2>
            <p>Non hai più limiti di tempo e spazio. E le possibilità sono infinite. Scopri come sfruttare tutti i vantaggi di PlayRai</p>
            <div class="history-mobile-carousel">
                <div>
                    <h3>2006</h3>
                    <p>Donec dapibus lacinia ipsum et pellentesque. Suspendisse fermentum vestibulum eros vel porta...</p>
                </div>
                <div>
                    <h3>Oggi</h3>
                    <p>Donec dapibus lacinia ipsum et pellentesque. Suspendisse fermentum vestibulum eros vel porta. Cras interdum finibus porttitor...</p>
                </div>
            </div>
        </section>

        <?if(have_rows("staff")) : the_row()?>
            <section id="staff">
                <div class="container">
                    <div class="icon hide-for-small-only"></div>
                    <h2><?the_sub_field("title")?></h2>
                        <div class="staff-list">
                                <div class="group-slider">
                                    <?if (have_rows("staff_group")) : while(have_rows("staff_group")) : the_row()?>
                                        <div class="staff_group">
                                            <div class="title group-title"><?the_sub_field("title")?></div>
                                            <?if (have_rows("People")) :  while(have_rows("People")) : the_row();global $post; $post = get_sub_field("person");setup_postdata($post);?>
                                                <a href="#" class="person">
                                                    <div class="user-photo">
                                                        <?if (get_field("image")["sizes"]["person-thumb"]) :?>
                                                            <img src="<?=get_field("image")["sizes"]["person-thumb"]?>" class="avatar">
                                                        <?else:?>
                                                            <img src="<?=get_template_directory_uri()?>/img/external/person.png" class="avatar">
                                                        <?endif;?>
                                                    </div>
                                                    <div class="user-info">
                                                        <div class="name"><?the_title()?></div>
                                                        <div class="position"><?the_field("role")?></div>
                                                    </div>
                                                </a>
                                            <?wp_reset_postdata();endwhile;endif?>
                                        </div>
                                    <?endwhile;endif?>
                                </div>
                            <div class="title hide-for-small-only"><?the_sub_field("sub-title")?></div>
                        </div>
                </div>
            </section>
        <?endif?>
        <?if(have_rows("statuts")) : the_row()?>
            <section id="statuts">
                <div class="container">
                    <div class="icon hide-for-small-only"></div>
                    <h2><?the_sub_field("title")?></h2>
                    <div class="owl-carousel">
                        <?if(have_rows("statut")) : while(have_rows("statut")) : the_row(); global $post; $post = get_sub_field("statut_object");setup_postdata($post)?>
                            <div class="statut">
                                <?the_content()?>
                            </div>
                        <?wp_reset_postdata();endwhile;endif?>
                    </div>
                </div>
            </section>
        <?endif?>
        <?if(have_rows("documents")) : the_row()?>
            <section id="rules">
                <div class="container">
                    <div class="icon hide-for-small-only"></div>
                    <h2><?the_sub_field("title")?></h2>
                    <div class="document-list">

                            <div class="rules-carousel">
                                <?if (have_rows("document_gorup")) : while(have_rows("document_gorup")) : the_row()?>
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <div class="title"><?the_sub_field("title")?></div>
                                            <?if (have_rows("document")) : while(have_rows("document")) : the_row()?>
                                                <a href="<?=get_sub_field("file")["url"]?>">Modello Parte Generale</a>
                                            <?endwhile;endif;?>
                                        </div>
                                    </div>
                                <?endwhile;endif;?>
                            </div>

                    </div>
                </div>
            </section>
        <?endif?>
    </main>
<?get_footer()?>
