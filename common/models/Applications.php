<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%applications}}".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $status [varchar(255)]
 * @property string $created_at [varchar(255)]
 * @property string $apartment_id [varchar(255)]
 * @property int $quantity [int(11)]
 */
class Applications extends \yii\db\ActiveRecord
{

    const DONE_STATUS = 10;
    const WAIT_STATUS = 20;
    public $products;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%applications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone', 'apartment_id', 'quantity'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['phone'], 'string'],
            [['apartment_id',], 'string'],
            [['quantity',], 'integer'],
            [['status', 'created_at'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'Имя'),
            'last_name' => Yii::t('app', 'Фамилия'),
            'apartment' => Yii::t('app', 'Номер'),
            'quantity' => Yii::t('app', 'Кол-во дней'),
            'phone' => Yii::t('app', 'Телефон'),
            'cost' => Yii::t('app', 'Стоимость'),
            'created_at' => Yii::t('app', 'Дата создания'),
        ];
    }

    public function beforeSave($insert)
    {
        $this->created_at = (new \DateTime('now'))->format('Y-m-d H:i');
        return true;
    }

    /**
     *
     */
    public function getApartment()
    {
        return $this->hasOne(Apartments::class, ['id' => 'apartment_id']);
    }

    // Метод получения суммы номера
    public function getCost()
    {
        return $this->quantity * $this->getApartment()->one()->amount . ' руб.';
    }
    
}
