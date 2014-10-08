<h3>Cerinte tehnice</h3>

<p>bla bla bla bla bla bla bla blabla bla bla blabla bla bla blabla bla bla bla</p>

<table class="table table-bordered">
    <tr>
        <td>PHP 5.4+</td>
        <td>
            <?php if ($req['php_version']) { ?>
                <label class="label label-success">PHP <?= phpversion(); ?></label>
            <?php } else { ?>
                <label class="label label-danger">PHP <?= phpversion(); ?></label>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>MCrypt PHP Extension</td>
        <td>
            <?php if ($req['mcrypt']) { ?>
                <label class="label label-success">Accesibil</label>
            <?php } else { ?>
                <label class="label label-danger">Inaccesibil</label>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>PDO MySQL PHP Extension</td>
        <td>
            <?php if ($req['pdo']) { ?>
                <label class="label label-success">Accesibil</label>
            <?php } else { ?>
                <label class="label label-danger">Inaccesibil</label>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>Apache Rewrite Mod</td>
        <td>
            <?php if ($req['rewrite']) { ?>
                <label class="label label-success">Accesibil</label>
            <?php } else { ?>
                <label class="label label-danger">Inaccesibil</label>
            <?php } ?>
        </td>
    </tr>
    
</table>

<?php if ($valid_step) { ?>
    <a href="<?= url('install/step3'); ?>" class="btn btn-info btn-lg">Urmatorul pas</a>
<?php } else { ?>
    <a href="#" class="btn btn-default btn-lg">Urmatorul pas</a>
<?php } ?>