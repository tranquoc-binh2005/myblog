<section class="container mb-10">
    <h1 headline class="mb-10 mt-10">Source code liên quan</h1>
    <section class="source">
        <?php foreach ($data['productAttr'] as $product) { ?>
        <article class="source-box" itemscope itemtype="http://schema.org/BlogPosting">
            <div class="source-box-img">
                <img src="<?= htmlspecialchars($product['image']) ?>" loading="lazy"
                    alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
            <div class="soure-box-text">
                <h3 itemprop="headline" class="mb-10">
                    <a href="source-code/<?= htmlspecialchars($product['canonical']) ?>">
                        <?= htmlspecialchars($product['name']) ?>
                    </a>
                </h3>
                <span class="pl-20 price-new">
                    <?php
                    echo intval($product['sale']) > 0 ? number_format(intval($product['price']), 0, ',', '.') : number_format(intval($product['price']), 0, ',', '.') . 'đ';
                    ?>
                </span>&nbsp;

                <?php if (intval($product['sale']) > 0): ?>
                <span
                    class="mt-10 price-old"><?= number_format(intval($product['price']), 0, ',', '.') . 'đ' ?></span>&nbsp;&nbsp;
                <span class="btn-sale">-<?= htmlspecialchars(intval($product['sale'])) ?>%</span>
                <?php endif;?>
            </div>
        </article>
        <?php } ?>
    </section>
</section>
