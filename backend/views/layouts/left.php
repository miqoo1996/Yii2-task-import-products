<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?php

        echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/']],
                    [
                        'label' => 'Store',
                        'icon' => 'home',
                        'url' => 'store',
                        'items' => [
                            [
                                'label' => 'List',
                                'icon' => 'list',
                                'url' => ['store/index'],
                            ],
                            [
                                'label' => 'Create',
                                'icon' => 'plus',
                                'url' => ['store/create'],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Store Product',
                        'icon' => 'gift',
                        'url' => 'store',
                        'items' => [
                            [
                                'label' => 'List',
                                'icon' => 'list',
                                'url' => ['store-product/index'],
                            ],
                            [
                                'label' => 'Create',
                                'icon' => 'plus',
                                'url' => ['store-product/create'],
                            ],
                        ],
                    ],
                    ['label' => 'Imported Product Jobs', 'icon' => 'bell', 'url' => ['/import-product-job']],
                    ['label' => 'Queue', 'icon' => 'bell', 'url' => ['/queue'], 'visible' => YII_ENV_DEV],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'], 'visible' => YII_ENV_DEV],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'], 'visible' => YII_ENV_DEV],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

    </section>

</aside>
