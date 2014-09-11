<p class="adv">Raspunsurile dumneavoastra au fost inregistrate cu succes! Va multumim! Puteti urmari rezultatele curente ale sondajului:</p>
<p class="snd_title"><?=$poll->title;?></p>

<table class="sondaje">
    <tbody>
        <?php foreach ($poll->answers as $answer) { ?>
        <tr>
            <td><?=$answer->title;?></td>
            <td>
                <progress value="<?=(int)($total_votes ? $answer->count / $total_votes * 100 : 0);?>" max="100"></progress>
                <span><?=(int)($total_votes ? $answer->count / $total_votes * 100 : 0);?>%</span>
            </td><td><?=$answer->count;?> raspunsuri</td>
        </tr>
        <?php } ?>
    </tbody>
</table>