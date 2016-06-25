<?if (!is_front_page()):?>
    <div class="breadcrumbs">
        <div class="container">
            <?php if(function_exists('bcn_display'))
            {
                bcn_display_list();
            }?>
        </div>
    </div>
<?endif;?>
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="large-12 columns">
                <div class="top">
                    <ul class="social-links float-left">
                        <li class="facebook"><a href="<?the_field("facebook",pll_current_language('slug'))?>"></a></li>
                        <li class="twitter"><a href="<?the_field("twitter",pll_current_language('slug'))?>"></a></li>
                        <li class="youtube"><a href="<?the_field("youtube",pll_current_language('slug'))?>"></a></li>
                    </ul>
                    <from class="subscribe float-left">
                        <input type="text" placeholder="Iscriviti alla newsletter">
                        <input type="submit" value="Invia">
                    </from><a href="#" class="acreditation float-right">Accedi all’Area riservata</a>
                </div>
            </div>
        </div>
        <?if (have_rows("footer",pll_current_language('slug'))) : the_row()?>
        <div class="row">
            <?if (have_rows("column",pll_current_language('slug'))) : $i = 0; while(have_rows("column",pll_current_language('slug'))) : the_row()?>
                <div class="large-4 columns">
                    <?if ($i == 0) : ?>
                    <a href="<?=pll_home_url(pll_current_language('slug'));?>" class="logo"></a>
                    <?endif?>
                    <div class="contact-info">
                        <?the_sub_field("text")?>
                    </div>
                </div>
            <?$i++;endwhile;endif?>
        </div>
        <?endif?>
    </div>
</div>
<script type="text/javascript" src="<?=get_template_directory_uri()?>/js/functions.js"></script>
<?wp_footer()?>
</body>