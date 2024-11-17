<div class="mb-4">
    <ul class="select-source">
        <h3 class="h5">Tags</h3>
        <input type="radio" id="catalogue" value="" name="cat">
        <label for="catalogue">Tất cả</label>
        <?php foreach ($data['catalogues'] as $key => $catalogue) {
            if($key > 0){
        ?>
        <li class="">
            <div>
                <input type="radio" id="catalogue-<?=$key?>" <?=($data['cat'] == $catalogue['id']) ? 'checked' : ''?> value="<?=$catalogue['id']?>" name="cat">
                <label for="catalogue-<?=$key?>">
                    <?=$catalogue['name']?> <span class="">(<?=$catalogue['count']?>)</span>
                </label>
            </div>
        </li>
        <?php }} ?>
    </ul>
</div>