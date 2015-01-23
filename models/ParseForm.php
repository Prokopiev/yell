<?php

namespace app\models;

use Yii;
use yii\base\Model;


class ParseForm extends Model
{
    public $url;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['url', 'required'],
            ['url', 'url'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'url' => 'Url сайта',
        ];
    }

}
