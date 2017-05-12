<?php

/**
 * Вывод flash сообщений
 */
class FlashMessages extends CWidget
{
    const TYPE_ERROR = 'error';
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';

    public $defaultType = self::TYPE_INFO;

    public function run()
    {
        $flashes = Yii::app()->user->getFlashes();
        foreach ($flashes as $key => $message) {
            $type = $this->defaultType;
            if (is_array($message) && isset($message['message'])) {
                if (isset($message['type'])) $type = $message['type'];
                $message = $message['message'];
            } else {
                $type = $key;
            }

            switch ($type) {
                case 'error':
                    $class = 'alert-error';
                    break;
                case 'success':
                    $class = 'alert-success';
                    break;
                //case 'info':
                default:
                    $class = 'alert-info';
                    break;
            }

            echo '<div class="alert '.$class.'">'.$message.'</div>';
        }
    }
}
