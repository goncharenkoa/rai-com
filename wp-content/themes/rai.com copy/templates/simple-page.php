<?php
/*
Template Name: Simple Page
*/
?>
<?get_header("external-no-logo")?>
<main role="main" class="main">
    <div class="container">
        <div class="row">
            <div class="large-12 columns">
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