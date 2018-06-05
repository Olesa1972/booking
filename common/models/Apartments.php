<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%apartments}}".
 *
 * @property int $id
 * @property string $name
 * @property string $cover
 * @property int $type_id
 * @property int $amount [int(11)]
 */
class Apartments extends \yii\db\ActiveRecord
{

    // Константы типов номеров
    const LUX = 10;
    const HALF_LUX = 20;
    const PENTHOUSE = 30;

    // Сотнесетие номеров типов с названиями
    const TYPES = [
        self::LUX => 'Люкс',
        self::HALF_LUX => 'Полулюкс',
        self::PENTHOUSE => 'Пентхаус',
    ];

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apartments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'name', 'type_id'], 'required'],
            [['type_id'], 'integer'],
            [['name', 'cover'], 'string', 'max' => 255],
            [['amount'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Название'),
            'cover' => Yii::t('app', 'Обложка'),
            'amount' => Yii::t('app', 'Цена за сутки'),
            'type_id' => Yii::t('app', 'Тип номера'),
            'type' => Yii::t('app', 'Тип номера'),
        ];
    }

    // Метод загрузки файлов
    // https://yiiframework.com.ua/ru/doc/guide/2/input-file-upload/
    public function upload()
    {
        if ($this->validate()) {
            $name = $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs(
                Yii::getAlias('@frontend/web/') . 'uploads/' . $name
            );
            $this->cover = $name;
            return true;
        } else {
            return false;
        }
    }

    // Метод получения ссылки на обложку
    public function getCover()
    {
        // Если файл существует, то возвращаем ссылку
        if (file_exists(Yii::getAlias('@frontend/web/uploads/' . $this->cover))) {
            return '/uploads/' . $this->cover;
        }
        return '';
    }

    // Метод получения типа по его id
    public function getType()
    {
        return self::TYPES[$this->type_id];
    }
}
