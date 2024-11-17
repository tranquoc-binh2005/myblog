<div class="col-4 pr-5">
    <select name="cat" id="categories">
        <!-- <option value="">Tất cả</option> -->
        <?php foreach ($data['postCatalogue'] as $key => $val) {?>
        <option <?=($data['cat'] == $val['id']) ? 'selected' : ''?> value="<?=$val['id']?>"><?=$val['name']?></option>
        <?php }?>
    </select>
</div>