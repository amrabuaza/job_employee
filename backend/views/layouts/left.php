<?php


use common\helper\Constants;
use common\helper\HelperMethods;
use common\models\user\User;
use common\models\user\UserRoles;

$user = User::findOne(Yii::$app->user->id);
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php
                $imgSrc = Constants::USER_DEFAULT;
                ?>
                <img src="<?=$imgSrc?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=$user->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>


        <?=dmstr\widgets\Menu::widget(
            [

                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Dashboard', 'options' => ['class' => 'header']],
                    ['label' => 'Admins', 'icon' => 'users', 'url' => ['/user/index?type=' . HelperMethods::convertStringToUrlString(User::TYPE_ADMIN)],],
                    ['label' => 'Job Owners', 'icon' => 'users', 'url' => ['/user/index?type=' . HelperMethods::convertStringToUrlString(User::TYPE_JOB_OWNER)],],
                    ['label' => 'Employees', 'icon' => 'users', 'url' => ['/user/index?type=' . HelperMethods::convertStringToUrlString(User::TYPE_EMPLOYEE)],],
                    [
                        'label' => 'Job',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Jobs', 'icon' => 'list', 'url' => ['/job'],],
                            ['label' => 'Job offers', 'icon' => 'list', 'url' => ['/job-offer'],],
                        ],
                    ],
                    [
                        'label' => Yii::t('app', 'Permissions'),
                        'visible' => Yii::$app->user->can('managePermissions'),
                        'icon' => 'shield',
                        'url' => ['/permissions'],
                        'items' => [
                            ['label' => Yii::t('app', 'Assignment'), 'icon' => 'list', 'url' => ['/permissions/assignment']],
                            ['label' => Yii::t('app', 'Permission'), 'icon' => 'list', 'url' => ['/permissions/permission']],
                            ['label' => Yii::t('app', 'Role'), 'icon' => 'list', 'url' => ['/permissions/role']],
                        ]
                    ],
                ]
            ]
        )?>

    </section>

</aside>
