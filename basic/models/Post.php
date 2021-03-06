<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%tbl_post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $author_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TblUser $author
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['content'], 'string'],
            [['author_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(TblUser::className(), ['id' => 'author_id']);
    }


	

	public function beforeSave($insert)
	{
	    if (parent::beforeSave($insert)) {
		$this->author_id=Yii::$app->user->identity->id;

		return true;
	    } else {
		return false;
	    }
	}



    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
               'timestamp' => [
                     'class' => 'yii\behaviors\TimestampBehavior',
                     'attributes' => [
                         ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                         ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                     ],
                 ],
        ];
      
    }
}
