<h3>Settings</h3>

<form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

    <table class="table table-bordered">
        <tr>
            <th>Site name</th>
            <td>
                <input class="form-control" type="text" name="set[name]" value="<?= isset($setts['name']) ? $setts['name'] : ''; ?>" />
            </td>
        </tr>
    </table>

</form>

<h4>Home logo</h4>
<?=Files::widget('website_logo', 1, 1); ?>

<h4>Home logo (small)</h4>
<?=Files::widget('website_logo_sm', 1, 1); ?>