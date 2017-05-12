<?php

class EHtml
{

    /**
     * type text
            textarea
            checkbox
            checkboxlist
            radiobuttonlist
            dropdownlist
            image
            datetime
            либо путь до какого нибудь виджета
     */
    public static function row($type, $model, $attribute, $options=array())
    {
        if ($model->isAttributeSafe($attribute)) {
            $error = $model->getError($attribute);

            echo '<div class="clearfix' . ($error!==null ? ' error' : '') . '">';
            echo CHtml::activeLabelEx($model, $attribute);
            echo '<div class="input">';

            switch (strtolower($type)) {
                case 'text':
                    $class = isset($options['class']) ? $options['class'] : '';
                    if (strpos($class, 'span')===false) {
                        if (empty($class)) {
                            $class = 'span8';
                        } else {
                            $class .= ' span8'; 
                        }
                    }
                    $options['class'] = $class;
                    echo CHtml::activeTextField($model, $attribute, $options);
                    break;
                case 'password':
                    $class = isset($options['class']) ? $options['class'] : '';
                    if (strpos($class, 'span')===false) {
                        if (empty($class)) {
                            $class = 'span8';
                        } else {
                            $class .= ' span8'; 
                        }
                    }
                    $options['class'] = $class;
                    echo CHtml::activePasswordField($model, $attribute, $options);
                    break;
                case 'textarea':
                    $class = isset($options['class']) ? $options['class'] : '';
                    if (strpos($class, 'span')===false) {
                        if (empty($class)) {
                            $class = 'span8';
                        } else {
                            $class .= ' span8'; 
                        }
                    }
                    $options['class'] = $class;
                    $options['style'] = 'height: 150px';
                    echo CHtml::activeTextArea($model, $attribute, $options);
                    break;
                case 'checkbox':
                    echo CHtml::activeCheckBox($model, $attribute, $options);
                    break;
                case 'checkboxlist':
                    if (isset($options['data'])) {
                        $data = $options['data'];
                        unset($options['data']);
                    } else {
                        $data = array();
                    }
                    echo CHtml::activeCheckBoxList($model, $attribute, $data, $options);
                    break;
                case 'radiobuttonlist':
                    if (isset($options['data'])) {
                        $data = $options['data'];
                        unset($options['data']);
                    } else {
                        $data = array();
                    }
                    echo CHtml::activeRadioButtonList($model, $attribute, $data);
                    break;
                case 'dropdownlist':
                    if (isset($options['data'])) {
                        $data = $options['data'];
                        unset($options['data']);
                    } else {
                        $data = array();
                    }
                    if (!isset($options['empty']))
                        $options['empty'] = 'Выбери что нибудь...';
                    echo CHtml::activeDropDownList($model, $attribute, $data, $options);
                    break;
                case 'image':
                    $img = '';
                    if (isset($options['image'])) {
                        if ($model->getAttribute($options['image'])) {
                            if (isset($options['remove'])) {
                                $img .= CHtml::activeHiddenField($model, $options['remove']);
                                unset($options['remove']);
                            }
                            $img .= CHtml::openTag('div', array('class'=>'form_image'));
                            $img .= CHtml::image($model->getAttribute($options['image']));
                            $img .= CHtml::link('Удалить', '', array('class'=>'remove'));
                            $img .= CHtml::closeTag('div');
                        }
                        unset($options['image']);
                    }
                    if (!isset($options['class'])) {
                        $options['class'] = 'image_preview';
                    }
                    echo Chtml::activeFileField($model, $attribute, $options);
                    echo $img;
                    break;
                case 'datetime':
                    if (isset($options['type'])) {
                        $type = $options['type'];
                        unset($options['type']);
                    } else {
                        $type = 'date';
                    }
                    $options['class'] = 'span5';
                    Yii::app()->controller->widget('CJuiDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>$attribute,
                        'language'=>'ru',
                        'mode'=>$type,
                        'htmlOptions'=>$options,
                    ));
                    break;
                case 'partial':
                    if (isset($options) && isset($options['path'])) {
                        $path = $options['path'];
                        unset($options['path']);
                    } else {
                        $path = 'forms/ext/' . $attribute;
                    }
                    Yii::app()->controller->renderPartial($path, array(
                        'model'=>$model,
                        'attribute'=>$attribute,
                        'options'=>$options,
                    ));
                    break;
                default:
                    $options['model'] = $model;
                    $options['attribute'] = $attribute;
                    echo Yii::app()->controller->widget($type, $options, true);
                    break;
            }

            echo '</div>';
            if (!empty($error)) {
                echo '<span class="help-inline">'.$error.'</span>';
            }
            echo '</div>';
        }
    }

}
