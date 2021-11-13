<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%queue}}".
 *
 * @property int $id
 * @property string $channel
 * @property resource $job
 * @property int $pushed_at
 * @property int $ttr
 * @property int $delay
 * @property int $priority
 * @property int|null $reserved_at
 * @property int|null $attempt
 * @property int|null $done_at
 */
class AdminQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%queue}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['channel', 'job', 'pushed_at', 'ttr'], 'required'],
            [['job'], 'string'],
            [['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at'], 'integer'],
            [['channel'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'channel' => Yii::t('app', 'Channel'),
            'job' => Yii::t('app', 'Job'),
            'pushed_at' => Yii::t('app', 'Pushed At'),
            'ttr' => Yii::t('app', 'Ttr'),
            'delay' => Yii::t('app', 'Delay'),
            'priority' => Yii::t('app', 'Priority'),
            'reserved_at' => Yii::t('app', 'Reserved At'),
            'attempt' => Yii::t('app', 'Attempt'),
            'done_at' => Yii::t('app', 'Done At'),
        ];
    }
}
