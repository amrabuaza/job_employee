<?php

use yii\db\Migration;

/**
 * Class m200904_173003_init_rbac
 */
class m200904_173003_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $create = $auth->createPermission('createEntities');
        $create->description = 'Create Entities';
        $auth->add($create);

        $create = $auth->createPermission('fullAdmin');
        $create->description = 'Crud Admin';
        $auth->add($create);

        $update = $auth->createPermission('updateEntities');
        $update->description = 'Update Entities';
        $auth->add($update);

        $delete = $auth->createPermission('deleteEntities');
        $delete->description = 'Delete Entities';
        $auth->add($delete);

        $view = $auth->createPermission('viewEntities');
        $view->description = 'view Entities';
        $auth->add($view);

        $mangeAdmins = $auth->createPermission('mangeAdmins');
        $mangeAdmins->description = 'Mange Admins';
        $auth->add($mangeAdmins);

        $managePermission = $auth->createPermission('managePermission');
        $managePermission->description = 'Manage Permission';
        $auth->add($managePermission);


        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $Admin = $auth->createRole('Admin');
        $auth->add($Admin);
        $auth->addChild($Admin, $mangeAdmins);
        $auth->addChild($Admin, $managePermission);
        $auth->addChild($Admin, $update);
        $auth->addChild($Admin, $delete);
        $auth->addChild($Admin, $view);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($Admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200904_173003_init_rbac cannot be reverted.\n";

        return false;
    }

}
