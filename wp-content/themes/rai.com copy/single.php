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
                        the_content();
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?get_footer()?>