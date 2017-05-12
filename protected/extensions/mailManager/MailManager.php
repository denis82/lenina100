<?php

class MailManager extends CApplicationComponent
{
    public $fromName = null;
    public $fromEmail = null;

    public function init()
    {
        parent::init();

        if ($this->fromName === null) {
            $this->fromName = Yii::app()->name;
        }

        if ($this->fromEmail === null) {
            $this->fromEmail = Yii::app()->config->get('adminEmail');
        }
    }

    /**
     * Создаем тело письма из модели по заданному шаблону
     * @param object $model - модель данных
     * @param string $pattern - наименование шаблона преобразования полей модели в тело письма (обычно редактируется в админке модуля)
     * @param string $contentClips - дополнительное поле "content" для шаблона - которое не может быть взято из модели
     * (например, в случае с товарами заказа, свойства которых не описаны в самом заказе)  
     */

    public function getContentPattern($model, $pattern, $contentClips = false)
    {
        $pattern = Yii::app()->config->get($pattern);
        $body = array();
        
        foreach($model->getSafeAttributeNames() as $attribute){
            $body['{{'.$attribute.'}}'] = $model->$attribute;
            if(isset($model->create_time))
                $body['{{create_time}}'] = date('d.m.Y', $model->create_time);
            if(isset($model->update_time))
                $body['{{update_time}}'] = date('d.m.Y', $model->update_time);
        }
        if(isset($model->id))
            $body['{{id}}'] = $model->id;
        
        if(!isset($body['{{content}}']) && $contentClips){
            $body['{{content}}'] = $contentClips;
        }
        $content = strtr($pattern,$body);
        return $content;
        // for HTML mail
        //$parser = new CMarkdownParser();
        //return $parser->safeTransform($content);
    }

    /**
     * Рассылаем письма 
     * @param array $options Различные опциональные параметры
     *  - object model - Можно использовать модель данных для создания полей письма
     *  - string pattern - название шаблона для преобразования модели
     *  - string subject - тема сообщения
     *  - boolean sendApart Рассылать письма раздельно (если в $to указано несколько адресов)
     *  - array   data    Список парметров для рендеринга шаблона
     *  - string  fromEmail Email адрес от кого 
     *  - string  fromName  Имя от кого
     */
    public function send($options=array())
    {
        $mailer = Yii::createComponent('ext.mailer.EMailer');
        
        if(!isset($options['method']))
            $options['method'] = 'mail';
        switch($options['method']){
            case 'html': $mailer->isHTML(); break;
            default: $mailer->IsMail();
        }

        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = "Уведомление с сайта " . Yii::app()->name;
        $mailer->From = isset($options['fromEmail']) ? $options['fromEmail'] : $this->fromEmail;
        $mailer->FromName = isset($options['fromName']) ? $options['fromName'] : $this->fromName;
        $to = isset($options['to']) ? $options['to'] : $this->fromEmail;
            
        // конвертируем модель в тело письма по шаблону из админки модуля    
        if(isset($options['model']) && isset($options['pattern'])){
            $contentClips = isset($options['contentClips']) ? $options['contentClips'] : false;  
            $mailer->Body = $this->getContentPattern($options['model'], $options['pattern'], $contentClips);
        // или преобразуем заданное тело письма через Mustache
        }else if (isset($options['message'])){
            
            if (!$options['message']) return false;
            Yii::import('application.vendors.*');
            require_once 'mustache.php/Mustache.php';
            $m = new Mustache();
            // если не задан массив параметров, передаваемых в Mustache, пытаемся взять их из иодели
            if(!isset($options['data']) && isset($options['model'])){
                $options['data'] = $options['model']->getSafeAttributeNames();
            }
            
            $mailer->Body = $m->render($options['message'], $options['data']);
        }
        // создаем тему сообщения
        if(isset($options['subject'])){
            $mailer->Subject = $options['subject'];
        }else if(isset($options['model']) && isset($options['model']->subject) && $options['model']->subject){
            $mailer->Subject = $options['model']->subject;
        }
        // создаем массив емайлов адресата 
        if(is_array($to)){
            $emails = $to;
        }else{
            $emails = preg_split('/[\s,]+/', $to, -1, PREG_SPLIT_NO_EMPTY);
        }
        // валидация емайлов
        $count = 0;
        $ev = new CEmailValidator(); 
        foreach ($emails as $email) {
            if ($ev->validateValue($email)) {
                $mailer->AddAddress(trim($email));
                if (isset($options['sendApart']) && $options['sendApart'] = true) {
                    $mailer->Send();
                    $mailer->ClearAddresses();
                } else {
                    $count += 1;
                }
            }
        }
        //отправляем письма
        if ($count > 0) {
            return $mailer->Send();
        } else {
            return true;
        }
    }
}
