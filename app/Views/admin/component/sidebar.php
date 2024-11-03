<div class="left-side-menu">
    <div class="slimscroll-menu">
        <?php
            $modules = $GLOBALS['moduleConfig']['module'];
            // print_r($modules);
        ?>

        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <?php foreach ($modules as $module) {?>
                    <li>
                        <a href="javascript: void(0);">
                            <i class="<?= $module['icon'] ?>"></i>
                            <span> <?= htmlspecialchars($module['title']) ?> </span>
                        </a>
                        <?php if (!empty($module['subModule'])) { ?>
                            <ul class="nav-second-level">
                                <?php foreach ($module['subModule'] as $subModule) {?>
                                    <li>
                                        <a href="<?= htmlspecialchars($subModule['route']) ?>">
                                            <?= htmlspecialchars($subModule['title']) ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
