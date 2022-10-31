<?phpnamespace backend\modules\translationmanager\models;use Yii;use yii\behaviors\TimestampBehavior;/** * This is the model class for table "message". * * @property integer $id * @property string $language * @property string $translation * @property int $created_at [int(11)] * @property int $updated_at [int(11)] */class Message extends \yii\db\ActiveRecord{//    public function behaviors()//    {//        return [//            TimestampBehavior::class,//        ];//    }    /**     * @inheritdoc     */    public static function tableName()    {        return 'message';    }    /**     * @inheritdoc     */    public function rules()    {        return [            [['id', 'language'], 'required'],            [['id'], 'integer'],            [['translation'], 'string'],            [['language'], 'string', 'max' => 16],            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => SourceMessage::className(), 'targetAttribute' => ['id' => 'id']],        ];    }    /**     * @inheritdoc     */    public function attributeLabels()    {        return [            'id' => 'ID',            'language' => 'Language',            'translation' => 'Translation',        ];    }}