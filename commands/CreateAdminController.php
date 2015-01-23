<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;

/**
 * Grant user with admin rights
 *
 *
 * @package app\commands
 */
class CreateAdminController extends Controller
{
    /**
     * This command creates user and grants it admin rights
     *
     * @param string $email email of user
     * @param string $password password of user
     */
    public function actionIndex($email, $password)
    {
        $user = User::findByEmail($email);
        if($user){
            echo "User ".$email." already exists. Aborting.".PHP_EOL;
            Yii::$app->end();
        } else {
            $user = new User();
            $user->email = $email;
            $user->password = $password;
            if(!$user->save()){
                echo "Error, while creating user".implode('. ',$user->getErrors()).PHP_EOL;
            } else {
                echo "User ".$email." successfully created.".PHP_EOL;
                $authManager = Yii::$app->getAuthManager();
                $role = $authManager->getRole('user');
                $assignment = $authManager->assign($role, $user->getId());
                if(!$assignment){
                    echo "Error while granting user role to user ".$email.PHP_EOL;
                    Yii::$app->end();
                }
                $permission = $authManager->getPermission('admin');
                $assignment = $authManager->assign($permission, $user->getId());
                if(!$assignment){
                    echo "Error while granting admin permission to user ".$email.PHP_EOL;
                    Yii::$app->end();
                } else {
                    echo "Admin permission to user " . $email . " granted" . PHP_EOL;
                }
            }
        }
    }
}
