<div class="blog">
    <?= empty($data['posts']) ? '<p>Không có bài viết nào :(...</p>' : '' ?>
    <?php foreach ($data['posts'] as $key => $val) {?>
        <article class="blog-box" itemscope itemtype="http://schema.org/BlogPosting">
            <div class="blog-box-img">
                <img src="<?=$val['image']?>" alt="<?=$val['name']?>">
            </div>
            <div class="blog-box-text">
                <a href="<?=$val['canonicalCatalogue']?>" class="btn-tag"><?=$val['nameCatalogue']?></a>
                <a href="blog/<?=$val['canonical']?>">
                    <h3 class="mt-10" itemprop="headline">
                        <?=$val['name']?>
                    </h3>
                </a>
                <p itemprop="description">
                    <?=$val['description']?>
                </p>
                <p class="time-blog"><?=date('H:i d-m-Y', strtotime($val['updated_at']))?> | (0)</p>
            </div>
        </article>
    <?php }?>
</div>