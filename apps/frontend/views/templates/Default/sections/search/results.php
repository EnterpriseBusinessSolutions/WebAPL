<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <div class='left'>
            <p class='c_title'><?= varlang('rezultatul-cautarii'); ?></p>
            <div class="search_r">
                <p class="search_t"><?= varlang('rezultatele-cautarii-pentru-'); ?><span>"<?= $words; ?>"</span></p>
                <p class="search_p"><?= varlang('afisate-'); ?> <span><?= $results->getFrom() . " - " . $results->getTo(); ?></span><?= varlang('-din-'); ?><?= number_format($results->getTotal()); ?></p>
                <div class="clearfix"></div>

                <ul class="search_li">
                    <?php foreach ($results as $item) { ?>
                        <li>
                            <a href="<?= Language::url('topost/' . $item->id); ?>">
                                <!--<div class="search_img"><img src="<?= res('assets/img/edu2.png'); ?>"></div>-->
                                <p>
                                    <span><?= $item->title; ?></span>
                                    <?= Str::words(strip_tags(Core\APL\Shortcodes::strip($item->text)), 20); ?>
                                </p>
                                <div class="more"></div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="clearfix50"></div>
            <?= $results->appends(array('words' => $words))->links(); ?>
        </div>
        <div class="right">
            <ul class='detail'>
                <li class='email'>
                    <a href='<?= varlang('email-address'); ?>'><?= varlang('email-address'); ?></a>
                </li>
                <li class='fax'>
                    <a href='<?= varlang('nr-fax'); ?>'><?= varlang('nr-fax'); ?></a>
                </li>
                <li class='chat'>
                    <a href='javascript:;'><?= varlang('chat-online'); ?></a>
                </li>
                <li class='location'>
                    <a href='contacte.php'><?= varlang('cum-ne-gasiti'); ?></a>
                </li>
            </ul>
        </div>
        <div class='clearfix50'></div>
    </div>
</section>