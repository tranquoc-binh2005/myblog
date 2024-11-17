<head>
    <base href="http://localhost/myblog/public/">
    <title><?=$data['title']?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Tên tác giả">
    <meta name="description" content="SourceCode chất lượng, dễ sử dụng, bảo trì, sửa chữa. Các dự án Laravel 10 được giảm giá lên đến 50%. Xem ngay!">
    <meta name="keywords" content="SourceCode, Laravel 10, Project Laravel, mã nguồn chất lượng, giảm giá, code bảo trì">
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= htmlspecialchars($data['seo']['name']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($data['seo']['description']) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($data['seo']['image']) ?>">
    <meta property="og:url" content="blog/<?= htmlspecialchars($data['seo']['canonical']) ?>">
    <meta property="og:site_name" content="Tên website">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:updated_time" content="<?= date('Y-m-d', strtotime($data['seo']['updated_at'])) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($data['seo']['name']) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($data['seo']['description']) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($data['seo']['image']) ?>">
    <link rel="canonical" href="http://localhost/myblog/public/blog/<?= htmlspecialchars($data['seo']['canonical']) ?>">
    <link rel="icon" type="image/png" href="client/assets/image/logo.png" sizes="32x32">
    <link rel="apple-touch-icon" href="client/assets/image/logo.png">
    <link rel="stylesheet" href="client/assets/css/style.css">
    <link rel="stylesheet" href="client/assets/css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "headline": "<?= htmlspecialchars($data['seo']['name']) ?>",
        "description": "<?= htmlspecialchars($data['seo']['description']) ?>",
        "image": "<?= htmlspecialchars($data['seo']['image']) ?>",
        "url": "http://localhost/myblog/public/blog/<?= htmlspecialchars($data['seo']['canonical']) ?>",
        "author": {
            "@type": "Person",
            "name": "Tên tác giả"
        },
        "datePublished": "<?= date('Y-m-d', strtotime($data['seo']['created_at'])) ?>",
        "dateModified": "<?= date('Y-m-d', strtotime($data['seo']['updated_at'])) ?>"
    }
    </script>
</head>
