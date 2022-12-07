<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[JsEducation]].
 *
 * @see JsEducation
 */
class JsEducationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JsEducation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JsEducation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\JsSummary|array|null
     */
    public function deleted(){
        $this->where(['<>', 'deleted_by', 0]);
        return $this;
    }
    public function educationPHD($educationQualification){
        return $this->where(['certificate_id' => 7 ]);
    }
    public function educationMasters($educationQualification){
        return $this->where(['certificate_id' => 6 ]);
    }
    public function educationBachelor($educationQualification){
        return $this->where(['certificate_id' => 5 ]);
    }
    public function educationDiploma($educationQualification){
        return $this->where(['certificate_id' => 4 ]);
    }
    public function educationALevel($educationQualification){
        return $this->where(['certificate_id' => 3 ]);
    }
    public function educationOLevel($educationQualification){
        return $this->where(['certificate_id' => 2 ]);
    }
    public function education6Years($educationQualification){
        return $this->where(['certificate_id' => 1 ]);
    }
    public function educationUknown($educationQualification){
        return $this->where(['certificate_id' => Null ]);
    }
}
