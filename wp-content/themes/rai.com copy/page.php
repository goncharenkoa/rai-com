<?get_header("external")?>
<main role="main" class="main">
    <div class="container">
        <div class="row">
            <div class="large-4 columns">
                <aside id="sidebar">
                    <h2 class="title">INFORMAZIONI GENERALI</h2>
                    <?wp_nav_menu(["location"=>"sidebar_menu","container"=>""])?>

                </aside>
            </div>
            <div class="large-8 columns">
                <div id="content">
                    <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();

                        // Include the page content template.
                        get_template_part( 'content', 'page');

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;

                        // End the loop.
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?get_footer()?>