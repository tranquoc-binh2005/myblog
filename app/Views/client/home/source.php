<div>
    <div class="container mt-20 mb-20">
        <div class="container box-sizing">
            <div class="title mg"> <br>
                <h1 class="text-uppercase"><span class="text-gradient-primary-2 mt-10">SourceCode</span> Chất lượng</h1>
            </div>
            <section class="source">
                <?php 
                foreach ($data['products'] as $product) { 
                ?>
                <article class="source-box">
                    <div class="source-box-img">
                        <img src="<?= htmlspecialchars($product['image']) ?>" loading="lazy"
                            alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                    <div class="soure-box-text">
                        <h3 class="mb-10">
                            <a href="source-code/<?= htmlspecialchars($product['canonical']) ?>">
                                <?= htmlspecialchars($product['name']) ?>
                            </a>
                        </h3>
                        <span class="pl-20 price-new">
                            <?php
                            echo (intval($product['sale']) > 0) ? number_format(intval($product['price']), 0, ',', '.') :  number_format(intval($product['price']), 0, ',', '.') .'đ'
                            ?>
                        </span>&nbsp;

                        <?php if (intval($product['sale']) > 0): ?>
                        <span class="mt-10 price-old"><?=number_format(intval($product['price']), 0, ',', '.').'đ'?></span>&nbsp;&nbsp;
                        <span class="btn-sale">-<?= htmlspecialchars(intval($product['sale'])) ?>%</span>
                        <?php endif;?>
                    </div>
                </article>
                <?php } ?>
            </section>
        </div>
    </div>
</div> <!--end section 3-->
