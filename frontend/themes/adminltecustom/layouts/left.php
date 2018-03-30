<aside class="main-sidebar">

    <section class="sidebar">
        <?=
        dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => [
                        ['label' => 'Menu', 'options' => ['class' => 'header']],
                        [
                            'label' => 'Manage Master Data',
                            'icon' => 'database',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Manage Data', 'icon' => 'circle-o', 'url' => ['/ndd-output-master/index'],],
                            ],
                        ],
                    ],
                ]
        )
        ?>

    </section>

</aside>
