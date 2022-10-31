<?phpnamespace backend\modules\translationmanager\models;use Yii;use backend\modules\translationmanager\models\Message;use yii\behaviors\TimestampBehavior;use yii\helpers\ArrayHelper;/** * This is the model class for table "source_message". * * @property integer $id * @property string $category * @property string $message * @property-read mixed $translations * @property Message[] $messages * @property int $created_at [int(11)] * @property int $updated_at [int(11)] */class SourceMessage extends \soft\db\ActiveRecord{    public $languages;    /**     * @inheritdoc     */    public function __construct($config = [])    {        foreach (Yii::$app->getModule('translate-manager')->languages as $one){            $config['languages'][$one] = null;        }        parent::__construct($config);    }    public static function tableName()    {        return 'source_message';    }//    public function behaviors()//    {//        return [//            TimestampBehavior::class,//        ];//    }    /**     * @inheritdoc     */    public function rules()    {        return [            [['message'], 'required'],            [['message'], 'trim'],            ['message', 'string'],            ['category', 'string', 'max' => 255],            ['languages','safe'],            [['message' , 'category'], 'unique', 'targetAttribute' => ['message' , 'category'] ],        ];    }    /**     * @inheritdoc     */    public function attributeLabels()    {        return [            'id' => 'ID',            'category' => 'Category',            'message' => 'Key',        ];    }    public function setAttributeNames()    {        return [            'createdByAttribute' => false,            'createdAtAttribute' => false,            'updatedAtAttribute' => false,        ];    }    /**     * @return \yii\db\ActiveQuery     */    public function getMessages()    {        return $this->hasMany(Message::className(), ['id' => 'id']);    }    public function getTranslations()    {        return ArrayHelper::map($this->messages,'language','translation');    }    public function getTranslation($lang)    {        return (isset($this->translations[$lang])) ? $this->translations[$lang]:null;    }    public function afterFind()    {        foreach ($this->languages as $key=>$one){            $this->languages[$key] = $this->getTranslation($key);        }    }    public function beforeDelete()    {        if (parent::beforeDelete()) {            Message::deleteAll(['id'=>$this->id]);            return true;        } else {            return false;        }    }    public function afterSave($insert, $changedAttributes)    {        if ($insert) {            foreach ($this->languages as $key=>$one){                $model = new Message();                $model->id = $this->id;                $model->language = $key;                if(empty($one)){                    $model->translation = null;                }else{                    $model->translation = $one;                }                $model->save();            }        }else{            foreach ($this->languages as $key => $one){                $model = Message::findOne([                    'id' => $this->id,                    'language' => $key,                ]);                if ($model == null){                    $model = new Message();                    $model->id = $this->id;                    $model->language = $key;                }                if(empty($one)){                    $model->translation = null;                }else{                    $model->translation = $one;                }                $model->save();            }        }        parent::afterSave($insert, $changedAttributes);    }}