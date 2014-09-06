<div class="cda">
    <p class="ul_title">
        <span class="left">denumire / link</span>
        <span class="right">Actualizat</span>
    </p>
    <ul>
        <?php foreach ($posts as $item) { ?>
        <li>
            <div class="left">
                <p><?=$item->title;?></p>
                <p class="green"><a href="<?=$item->website;?>" target="_blank"><?=$item->website;?></a> </p>
            </div>
            <div class="right"><?=date("d/m/Y", strtotime($item->created_at));?></div>
        </li>
        <?php } ?>
    </ul>
</div>
