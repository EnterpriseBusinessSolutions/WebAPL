<h3>Gallery: <?= isset($gallery->name) ? $gallery->name : ''; ?></h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
    <li><a href="#gfiles" role="tab" data-toggle="tab">General</a></li>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="general">

        <form class="ajax-auto-submit" action='<?= url('gallery/save'); ?>' method='post'>
            <input type='hidden' name='id' value='<?= isset($gallery->id) ? $gallery->id : 0; ?>' />

            <table class="table table-bordered">
                <tr>
                    <th>Name: </th>
                    <td>
                        <input type="text" name="gallery[name]" class='form-control' value='<?= isset($gallery->name) ? $gallery->name : ''; ?>' />
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <div class="tab-pane" id="gfiles">
        <div class="c10"></div>
        <?= Files::widget('gallery', $gallery->id); ?>
    </div>
</div>