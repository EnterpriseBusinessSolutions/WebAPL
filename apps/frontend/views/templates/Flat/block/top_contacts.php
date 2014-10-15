<p class="tel"><?= varlang('nr-phone'); ?></p>
<a class="mini_contacte" href="#"></a>
<a class="mini_contacte1" href="#"></a>
<div class="cont">
    <div class="contact_us_btn">
        <button class="contact_us"><?= varlang('contact-us'); ?></button>
        <div class="cont_form hidden">
            <div class="relative">
                <p></p>
            </div>
            <p class="title"><?= varlang('date-contact'); ?></p>
            <div class="d_hr"></div>
            <ul>
                <li>
                    <p><?= varlang('email'); ?> : <span><a href="mailto:<?= varlang('email-address'); ?>"> <?= varlang('email-address'); ?></a></span></p>
                    <p><?= varlang('relatii'); ?> : <span><?= varlang('nr-relatii'); ?></span></p>
                    <p><?= varlang('fax'); ?> : <span><?= varlang('nr-fax'); ?></span></p>
                </li>
            </ul>
            <div class="clearfix"></div>
            <?php if (isset($phone_page) && $phone_page) { ?>
                <div class="anp">
                    <a href="<?= Core\APL\Language::url('topost/' . $phone_page->id); ?>"><?= varlang('all-nr-phone'); ?></a>
                </div>   
                <div class="anp">
                    <a href="<?= varlang('orar-link'); ?>"><?= varlang('orar-autobus'); ?></a>
                </div>
            <?php } ?>
            <p class="title"><?= varlang('viziteaza'); ?></p>
            <div class="d_hr"></div>
            <div class="left" onclick="window.open('https://www.google.ro/maps/dir//' + loc_lat + ',' + loc_long + '/@' + loc_lat + ',' + loc_long + ',14z');">
                <div class="c_info">
                    <p class="city"><?= varlang('address'); ?></p>            
                    <p class="street2"><?= varlang('street'); ?></p>
                    <p class="street2"><?= varlang('city'); ?></p>
                </div>
            </div>
            <div class="left map">
                <center>
                    <a class="mini_contacte1 maplink" href="javascript:window.open('https://www.google.ro/maps/dir//' + loc_lat + ',' + loc_long + '/@' + loc_lat + ',' + loc_long + ',14z');"></a>
                </center>
            </div>        
            <div class="clearfix10"></div>

            <p class="title"><?= varlang('scrieti-direct'); ?></p>
            <div class="d_hr"></div>
            <div class="contact_top_notif adv" style="display: none;"><?= varlang('success'); ?> </div>
            <form id="contact_top_form" action="<?= url(); ?>" method="post">
                <div class="form_error"></div>
                <input type="text" name="name" placeholder="<?= varlang('name-last-name'); ?>">
                <input type="text" name="email" placeholder="<?= varlang('email'); ?>">
                <textarea name="message" placeholder="<?= varlang('message'); ?>"></textarea>
                <input name="capcha" class="code" type="text">
                <img src="<?= SimpleCapcha::make('contact_top'); ?>" height="31">
                <input type="submit" value="<?= varlang('submit'); ?>">
            </form>
        </div>
    </div>


    <div class="currency">
        <span class="s_c">
            <img src="<?= res('assets/img/line_dot.png'); ?>">
            <span><?= Core\APL\Language::ext(); ?></span>
            <img src="<?= res('assets/img/line_dot.png'); ?>">
        </span>
        <div class="lang hidden">
            <div class="relative">
                <p></p>
            </div>
            <?php
            foreach (Core\APL\Language::getList() as $lang) {
                if (Core\APL\Language::ext() != $lang->ext && $lang->enabled == 1) {
                    ?>
                    <p><a href="<?= url('language/' . $lang->ext . '/' . (isset($active_page_id) ? $active_page_id : '')); ?>"><?= $lang->name; ?></a></p>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>