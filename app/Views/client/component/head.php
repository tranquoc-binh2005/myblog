<head>
    <base href="<?=$config['rootPath']?>">
    <title><?=$data['title']?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Trần Quốc Bình | QUOCBINHORG">
    <meta name="description" content="<?= htmlspecialchars($data['seo']['meta_title']) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($data['seo']['meta_keyword']) ?>">
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= htmlspecialchars($data['seo']['meta_title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($data['seo']['meta_description']) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($data['seo']['image']) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($data['seo']['canonical']) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($data['seo']['nameWeb']) ?>">
    <meta property="og:locale" content="vi_VN">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($data['seo']['meta_title']) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($data['seo']['meta_description']) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($data['seo']['image']) ?>">
    <link rel="canonical" href="<?=$config['rootPath']?><?= htmlspecialchars($data['seo']['canonical']) ?>">
    <link rel="icon" type="image/png" href="client/assets/image/logo.png" sizes="32x32">
    <link rel="icon" type="image/png" sizes="16x16" href="client/assets/image/logo.png">
    <link rel="icon" type="image/png" sizes="48x48" href="client/assets/image/logo.png">
    <link rel="icon" type="image/png" sizes="64x64" href="client/assets/image/logo.png">

    <link rel="apple-touch-icon" href="client/assets/image/logo.png">
    <!-- <link rel="stylesheet" href="client/assets/css/style.css">
    <link rel="stylesheet" href="client/assets/css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> -->
    <?php 
        if(isset($data['config']['css']) && (is_array($data['config']['css']))){
            foreach ($data['config']['css'] as $val) {
                echo $val;
            }
        }
    ?>
    <script type="application/ld+json">

    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "headline": "<?= htmlspecialchars($data['seo']['name']) ?>",
        "description": "<?= htmlspecialchars($data['seo']['description']) ?>",
        "image": "<?= htmlspecialchars($data['seo']['image']) ?>",
        "url": "<?=$config['rootPath']?><?= htmlspecialchars($data['seo']['canonical']) ?>",
        "author": {
            "@type": "Person",
            "name": "Tran Quoc Binh"
        },
        "datePublished": "<?= date('Y-m-d', strtotime($data['seo']['created_at'])) ?>",
        "dateModified": "<?= date('Y-m-d', strtotime($data['seo']['updated_at'])) ?>",
    }

    </script>
</head>
