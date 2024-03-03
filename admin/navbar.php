<header class="bg-second-color">
    <div class="container">
    <div class="navbar navbar-expand-md navbar-dark">
            <a href="index.php" class="navbar-brand"><h1 class="text-uppercase text-main-color mb-0">logo</h1></a>
            <button class="navbar-toggler bg-main-color" data-toggle="collapse" data-target="#main-navbar-content"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-between" id="main-navbar-content">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="categories.php" class="nav-link text-white text-capitalize"><?= lang('categories'); ?></a></li>
                    <li class="nav-item"><a href="items.php" class="nav-link text-white text-capitalize"><?= lang('items'); ?></a></li>
                    <li class="nav-item"><a href="members.php" class="nav-link text-white text-capitalize"><?= lang('members'); ?></a></li>
                    <li class="nav-item"><a href="comments.php" class="nav-link text-white text-capitalize"><?= lang('comments'); ?></a></li>
                </ul>
                <div class="sous-menu d-inline-block">
                    <h3 class="bg-main-color p-2 m-0 rounded sous-menu-name">mohammedamine</h3>
                    <ul class="links list-unstyled bg-main-color text-center py-3">
                        <li><a href="../index.php" class="text-second-color text-capitalize my-3 font-weight-bold"><?= lang('visit shop'); ?></a></li>
                        <li><a href="#" class="text-second-color text-capitalize my-3 font-weight-bold"><?= lang('settings'); ?></a></li>
                        <li><a href="#" class="text-second-color text-capitalize my-3 font-weight-bold"><?= lang('profile'); ?></a></li>
                        <li><a href="logout.php" class="text-second-color text-capitalize my-3 font-weight-bold"><?= lang('log out'); ?></a></li>
                    </ul>
                </div>
            </div>   
        </div>
    </div>
</header>