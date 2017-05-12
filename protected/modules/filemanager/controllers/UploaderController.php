<?php

class UploaderController extends Controller
{
    /**
     * Принимает фотографию
     */
    public function actionUpload($out=false)
    {
        $result = array(
        );
        
        $file = CUploadedFile::getInstanceByName('file');
        if ( $file !== null ) {
            
            $webroot = Yii::getPathOfAlias('webroot');
            
            $path = '/files/'.date('Y').'/'.date('m').'/'.date('j');
            $filename = $this->encode($file->name);
            if ( ! file_exists($webroot.$path) ) {
                mkdir($webroot.$path, 0777, true);
            }

            while ( file_exists($webroot.$path.'/'.$filename) ) {
                $filename = mt_rand(0, 10000).'_'.$filename;
            }
            $file->saveAs($webroot.$path.'/'.$filename);
            $result['file'] = $path.'/'.$filename;
            $result['thumb'] = CHtml::normalizeUrl(array(
                '/filemanager/uploader/show',
                'filename' => $path.'/'.$filename,
            ));
            
        } else {
            $result['error'] = 'Нет файла';
        }
        
        // return div for cleditor request
        if($out && isset($result['file'])){
            $string = $result['file'];
            echo "<div id='image'>$string</div>";
            return;
        }
        
        // HTTP headers for no cache etc
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        
        echo CJSON::encode($result);
    }
    
    /**
     * Показывает фотографию
     */
    public function actionShow($filename)
    {
        $webroot = Yii::getPathOfAlias('webroot');
        
        if ( ! file_exists($webroot.$filename) ) {
            throw new CHttpException(404);
        }
        
        Yii::import('application.vendors.*');
        require_once 'phpthumb/ThumbLib.inc.php';
        
        $thumb = PhpThumbFactory::create($webroot.$filename);
        $thumb->resize(126, 0);
        $thumb->show();
    }
    
    public function actionDelete()
    {
    }

    /**
     * Переводим в транслит русские названия, убираем пробелы
     */
    protected function encode($str)
    {
        $tr = array(
            "А" => "A", "Б" => "B",  "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E",  "Ж" => "J", "З" => "Z",  "И" => "I",
            "Й" => "Y", "К" => "K",  "Л" => "L", "М" => "M",  "Н" => "N",
            "О" => "O", "П" => "P",  "Р" => "R", "С" => "S",  "Т" => "T",
            "У" => "U", "Ф" => "F",  "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH","Щ" => "SCH","Ъ" => "",  "Ы" => "YI", "Ь" => "",
            "Э" => "E", "Ю" => "YU", "Я" => "YA","а" => "a",  "б" => "b",
            "в" => "v", "г" => "g",  "д" => "d", "е" => "e",  "ж" => "j",
            "з" => "z", "и" => "i",  "й" => "y", "к" => "k",  "л" => "l",
            "м" => "m", "н" => "n",  "о" => "o", "п" => "p",  "р" => "r",
            "с" => "s", "т" => "t",  "у" => "u", "ф" => "f",  "х" => "h",
            "ц" => "ts","ч" => "ch", "ш" => "sh","щ" => "sch","ъ" => "y",
            "ы" => "yi","ь" => "",   "э" => "e", "ю" => "yu", "я" => "ya",
            " " => "_",
        );
        
        return strtr($str,$tr);
    }
}
