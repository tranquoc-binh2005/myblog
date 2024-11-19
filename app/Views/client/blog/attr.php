<section class="container mb-10">
    <h1 class="mt-10" headline>Bài viết liên quan</h1>
    <div class="blog">
        <?php foreach ($data['postAttr'] as $val) {?>
        <article class="blog-box" itemscope itemtype="http://schema.org/BlogPosting">
            <div class="blog-box-img">
                <img src="<?=$val['image']?>" loading="lazy" alt="<?=$val['name']?>">
            </div>
            <div class="blog-box-text">
                <a href="catagories/<?=$val['catalogues']['post_catalogue_id']?>" class="btn-tag"><?=$val['nameCatalogue']?></a>
                <h3 class="mt-10" itemprop="headline">
                    <a href="blog/<?=$val['canonical']?>"><?=$val['name']?></a>
                </h3>
                <p itemprop="description">
                    <?=$val['description']?>
                </p>
                <p class="time-blog"><?=date('H:i d-m-Y', strtotime($val['updated_at']))?></p>
            </div>
        </article>
        <?php }?>
    </div>
</section>