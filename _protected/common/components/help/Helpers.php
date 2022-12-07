<?php
namespace common\components\help;
use yii\helpers\Html;
use kartik\popover\PopoverX;
use common\models\Labels;

class Helpers {

	/*
	* Labels::renderPopUpHelp('current,'danger','left')
	*/
	public static function renderPopUpHelp($name , $cssclass , $align ,$abbrv_label){
		return  PopoverX::widget([
        'header'       => 'Definition',
        'placement'    => ($align == 'left') ? PopoverX::ALIGN_LEFT : PopoverX::ALIGN_RIGHT ,
        'content'      => Labels::definition($name),
        'footer'       => '',
        'toggleButton' => ['label'=>$abbrv_label, 'class'=>'btn btn-sm btn-'.$cssclass],
    ]);
	}


	public static function helper($model,$attribute_name,$align = 'right',$text='?',$cssclass=''){
		$label = '<label class="control-label" for="order-pay_status">'.$model->getAttributeLabel($attribute_name).'</label>';
        $label.= '&nbsp;<sup><span style="color:red">'.self::renderPopUpHelp($attribute_name, $cssclass, $align , $text).'</span></sup>';

        return $label;
	}
}
?>