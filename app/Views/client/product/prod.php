<section class="source-3 source-container-item">
    <?= empty($data['products']) ? '<p>Không có source code nào...</p>' : '' ?>
    <?php foreach ($data['products'] as $product) {?>
    <article class="source-box">
        <div class="source-box-img">
            <img src="<?=$product['image']?>" loading="lazy" alt="<?=$product['name']?>">
        </div>
        <div class="soure-box-text">
            <h3 class="">
            <a href="source-code/<?=$product['canonical']?>">
                <?=$product['name']?>
            </a>
            </h3>
            <span class="pl-20 price-new">500,000d</span>&nbsp;
            <span class="mt-10 price-old">1,500,000d</span>&nbsp; &nbsp;
            <span class="btn-sale">50%</span>
        </div>
    </article>
    <?php }?>
</section>