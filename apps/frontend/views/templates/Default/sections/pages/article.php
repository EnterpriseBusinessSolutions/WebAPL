<?php
$months = array(
    1 => varlang('ianuarie'),
    2 => varlang('februarie'),
    3 => varlang('martie'),
    4 => varlang('aprilie'),
    5 => varlang('mai'),
    6 => varlang('iunie'),
    7 => varlang('iulie'),
    8 => varlang('august'),
    9 => varlang('septembrie'),
    10 => varlang('octombrie'),
    11 => varlang('noiembrie'),
    12 => varlang('decembrie')
);
?>

<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">        
        <p class="c_title"><?= $top_title; ?></p>
        <?php if (isset($years_list) && count($years_list)) { ?>
            <div class="right m_a">                
                <p class='n_title'><?= varlang('arhiva'); ?></p>
                <ul class="right_menu">
                    <?php foreach ($years_list as $year) { ?>
                        <li class='<?= isset($current_year) && $current_year == $year->year ? 'active' : ''; ?>'>
                            <a href="javascript:;//<?= url($page_url . "?year=" . $year->year . "&month=1"); ?>"><?= $year->year; ?></a>
                            <ul class="months">
                                <li>
                                    <a href="javascript:;">Ianuarie</a>
                                    <a href="javascript:;">Februarie</a>
                                    <a href="javascript:;">Martie</a>
                                    <a href="javascript:;">Aprilie</a>
                                    <a href="javascript:;">Mai</a>
                                    <a href="javascript:;">Iunie</a>
                                    <a href="javascript:;">August</a>
                                    <a href="javascript:;">Septembrie</a>
                                    <a href="javascript:;">Octombrie</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="resp_menu"></div>
        <?php } ?>
        <div class="left">
            <?php if (isset($current_month) && $current_month) { ?>
                <div class="m_criteria">
                    <?php if (isset($months[intval($current_month) - 1])) { ?>
                        <a href="<?= $page_url; ?>?year=<?= $current_year; ?>&month=<?= intval($current_month) - 1; ?>" class="left"></a>
                    <?php } ?>
                    <span><?= $months[intval($current_month)]; ?> <?= $current_year; ?></span>
                    <?php if (isset($months[intval($current_month) + 1])) { ?>
                        <a href="<?= $page_url; ?>?year=<?= $current_year; ?>&month=<?= intval($current_month) + 1; ?>" class="right"></a>
                    <?php } ?>
                </div> 
            <?php } ?>

            <?php Event::fire('page_top_container', $page); ?>

            <?= $page->text; ?>

            <?php Event::fire('page_bottom_container', $page); ?>

            <div class="clearfix50"></div>
            <?php if ($page->have_socials) { ?>
                <?= View::make('sections.elements.socials', array('url' => $page_url)); ?>
            <?php } ?>
            <div class="hr_grey"></div>
        </div>
    </div>
    <div class="clearfix"> </div>
</section>
