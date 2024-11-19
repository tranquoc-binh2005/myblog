<?php $config = $GLOBALS['config'] ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'component/head.php';?>

<body id="<?=$data['home']?>">
    <button id="backToTop" title="Lên đầu trang">↑</button>

    <?php include 'component/header.php';?>

   <?php include ''.$data['template'].'.php';?>

    <?php include 'component/footer.php';?>

    <?php include 'component/script.php';?>

</body>

</html>