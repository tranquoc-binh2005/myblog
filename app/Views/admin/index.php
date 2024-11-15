<?php $sub = $GLOBALS['sub'] ?>
<?php $general = $GLOBALS['general'] ?>
<?php $config = $GLOBALS['config'] ?>
<?php $app = $GLOBALS['app'] ?>
<?php
print_r($GLOBALS['app'])
?>
<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['userCatalogue_id'] != 2) {
    header('location: trang-chu');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'component/head.php';?>

    <body>
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Topbar Start -->
            <?php include 'component/topbar.php';?>
            <!-- end Topbar -->
            <!-- ========== Left Sidebar Start ========== -->
            <?php include 'component/sidebar.php';?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <?php include ''.$data['template'].'.php';?>

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include 'component/footer.php';?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <?php include 'component/rightbar.php';?>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <?php include 'component/script.php';?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                    var elems = Array.prototype.slice.call(document.querySelectorAll('input[data-plugin="switchery"]'));
                    elems.forEach(function (html) {
                        var color = html.getAttribute('data-color');
                        var size = html.getAttribute('data-size');
                        new Switchery(html, {
                            color: color,
                            size: size
                        });
                    });
                });
        </script>
    </body>
</html>