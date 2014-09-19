<section>
    <?= View::make('sections.elements.breadcrumbs'); ?>
    <div class="wrap">
        <p class='c_title'><?= $top_title; ?></p>
        <div class="right">
            <?=
            View::make('sections.pages.blocks.right-menu')->with(array(
                'colevels' => $colevels
            ));
            ?>
        </div>
        <div class='left'>
            <?= Core\APL\Actions::call('page_top_container', $page); ?>

            <?= $page->text; ?>

            <?= Core\APL\Actions::call('page_bottom_container', $page); ?>

            <?=
            View::make('sections.pages.blocks.files', array(
                'page' => $page
            ));
            ?>

            <?php if ($page->have_socials) { ?>
                <?= View::make('sections.elements.socials', array('url' => $page_url)); ?>
            <?php } ?>
            <?php
            if ($page->have_comments) {
                View::make('sections.elements.comments');
            }
            ?>
        </div>
        <div class='clearfix'></div>
        <div class='hr_grey'></div>
    </div>
</section>