<?if (!is_front_page()):?>
    <div class="breadcrumbs hide-for-small-only">
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
                    <from class="subscribe float-left hide-for-small-only">
                        <input type="text" placeholder="Iscriviti alla newsletter">
                        <input type="submit" value="Invia">
                    </from><a href="#" class="acreditation float-right">Accedi all’Area riservata</a>
                </div>
            </div>
        </div>
        <?if (have_rows("footer",pll_current_language('slug'))) : the_row()?>
        <div class="row hide-for-small-only">
            <?if (have_rows("column",pll_current_language('slug'))) : $i = 0; while(have_rows("column",pll_current_language('slug'))) : the_row()?>
                <div class="medium-4 columns">
                    <?if ($i == 0) : ?>
                    <a href="<?=pll_home_url(pll_current_language('slug'));?>" class="logo"></a>
                    <?endif?>
                    <div class="contact-info">
                        <?the_sub_field("text")?>
                    </div>
                </div>
            <?$i++;endwhile;endif?>
        </div>
        <div class="row show-for-small-only">
            <ul class="footer-menu clearfix">
                <li>
                    <a href="#">Privacy policy</a>
                </li>
                <li>
                    <a href="#">Cookie policy</a>
                </li>
                <li>
                    <a href="">Società trasparente</a>
                </li>
            </ul>
        </div> 
        <div class="row show-for-small-only">
            <div class="small-4 columns">
                <a href="<?=pll_home_url(pll_current_language('slug'));?>" class="logo"></a>
            </div>
            <div class="small-8 columns">
                <?if (have_rows("column",pll_current_language('slug'))) : $i = 0; while(have_rows("column",pll_current_language('slug'))) : the_row()?>
                    <div class="contact-info">
                        <?the_sub_field("text")?>
                    </div>
                <?$i++;endwhile;endif?>
            </div>
        </div>
        <?endif?>
        <div class="row footer-top">
            <a href="#" class="go-top show-for-small-only">Torna su</a>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=get_template_directory_uri()?>/js/functions.js"></script>
<?wp_footer()?>
</body>