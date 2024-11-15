<div class="form-group col-md-12">
    <label for="" class="col-form-label">Cấu hình nâng cao
        <span class="text-danger">*</span> <br>
    </label>
    <select name="publish" class="form-control mb-2">
        <?php
        foreach ($general['publish'] as $key => $publish) {?>
            <option <?php echo ($data['post']['publish'] == $key) ? 'selected' : ''?> value="<?=$key?>">
                <?=$publish?>
            </option>
        <?php }?>
    </select>

    <select name="follow" class="form-control">
        <?php
        foreach ($general['follow'] as $key => $follow) {?>
            <option <?php echo ($data['post']['follow'] == $key) ? 'selected' : ''?> value="<?=$key?>">
                <?=$follow?>
            </option>
        <?php }?>
    </select>
</div>