<?php

namespace app\controllers;

use app\models\ParseForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use serhatozles\simplehtmldom\SimpleHTMLDom;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow'   => true,
                        'roles'   => ['admin'],
                    ],
                    [
                        'allow' => true,
                    ]
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new ParseForm();
        if ($model->load(Yii::$app->request->post())) {
            $parse = parse_url($model->url);
            if (isset($parse['scheme'])) {
                $url = $parse['scheme'] . '://';
            } else {
                $url = 'http://';
            }
            $url .= $parse['host'];
            if (isset($parse['port'])) {
                $url .= $parse['port'];
            }
            $html = new SimpleHTMLDom();
            $out = @$html->file_get_html($url);
            if (!$out) {
                $model->addError('url', 'Невозможно получить страницу');
                return $this->render(
                    'index',
                    [
                        'model' => $model,
                    ]
                );
            } else {
                $hrefs = array();
                $collection = $out->find('a');
                foreach ($collection as $item) {
                    if (isset($item->attr) && isset($item->attr['href'])) {
                        $href = $item->attr['href'];
                        if (stripos($href, 'mailto:') === 0) {
                            continue;
                        }
                        if (stripos($href, '/') === 0) {
                            $href = $url . $href;
                        }
                        $hrefs[] = $href;
                    }
                }
                $model->url = $url;
                return $this->render(
                    'index',
                    [
                        'model' => $model,
                        'hrefs' => $hrefs,
                    ]
                );
            }
        } else {
            return $this->render(
                'index',
                [
                    'model' => $model,
                ]
            );
        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render(
                'login',
                [
                    'model' => $model,
                ]
            );
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
