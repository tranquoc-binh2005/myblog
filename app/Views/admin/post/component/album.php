<div class="ibox-content">
    <div class="album-wrapper">
        <div class="title">
            <p>ALBUM ẢNH</p>
            <p class="multipleUploadImage">Chọn ảnh</p>
        </div>
        <div class="contentmultipleUploadImage content">
            <p>
                <img class="multipleUploadImage" id="ckAlbum" src="serve/assets/images/noimage.png" alt="">
            </p>
            <p>Sử dụng nút chọn hình hoặc nhấn vào đây để chọn hình ảnh</p>
        </div>
        <div id="imageContainer" class="image-container">
            <?php
            if(isset($data['post']['album']) && is_array($data['post']['album'])){
                foreach ($data['post']['album'] as $key => $value) {
            ?>
            <span class="image-wrapper">
                <img class="multipleUploadImage uploaded-image" id="ckAlbum" src="<?=$value?>" alt="<?=$value?>">
                <input type="hidden" name="album[]" value="<?=$value?>">
                <span class="delete-icon">x</span>
            </span>
            <?php }}?>
        </div>
    </div>
</div>