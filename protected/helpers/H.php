<?php

class H
{
    /**
     * Переводим в транслит русские названия, убираем пробелы
     */
    public static function translit($str)
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

    /**
     * Choost russion word declension based on numeric.
     * Example for $expressions: array("ответ", "ответа", "ответов")
     */ 
    public static function declension($int, $expressions) 
    { 
        if (count($expressions) < 3) $expressions[2] = $expressions[1];
        settype($int, "integer"); 
        $count = $int % 100; 
        if ($count >= 5 && $count <= 20) { 
            $result = $expressions['2']; 
        } else { 
            $count = $count % 10; 
            if ($count == 1) { 
                $result = $expressions['0']; 
            } elseif ($count >= 2 && $count <= 4) { 
                $result = $expressions['1']; 
            } else { 
                $result = $expressions['2']; 
            }
        } 
        return $result; 
    }


    public static function pageTitle($value)
    {
        $template = Yii::app()->config->get('pageTitleTemplate');
        if (empty($template)) {
            $template = Yii::app()->name . ' - {pageTitle}';
        }

        return strtr($tempate, array('pageTitle' => $value));
    }


    public static function error($model,$attribute,$htmlOptions=array())
    {
        CHtml::resolveName($model,$attribute); // turn [a][b]attr into attr
        $error=$model->getError($attribute);
        if($error!='')
        {
            if(!isset($htmlOptions['class']))
                $htmlOptions['class'] = 'warning';
            return CHtml::tag('div',$htmlOptions,$error.'<div class="tail"></div>');
        }
        else
            return '';
    }


    public static function semantic($i, &$words, &$fem, $f)
    { 
        $_1_2[1]="одна "; 
        $_1_2[2]="две "; 

        $_1_19[1]="один "; 
        $_1_19[2]="два "; 
        $_1_19[3]="три "; 
        $_1_19[4]="четыре "; 
        $_1_19[5]="пять "; 
        $_1_19[6]="шесть "; 
        $_1_19[7]="семь "; 
        $_1_19[8]="восемь "; 
        $_1_19[9]="девять "; 
        $_1_19[10]="десять "; 

        $_1_19[11]="одиннацать "; 
        $_1_19[12]="двенадцать "; 
        $_1_19[13]="тринадцать "; 
        $_1_19[14]="четырнадцать "; 
        $_1_19[15]="пятнадцать "; 
        $_1_19[16]="шестнадцать "; 
        $_1_19[17]="семнадцать "; 
        $_1_19[18]="восемнадцать "; 
        $_1_19[19]="девятнадцать "; 

        $des[2]="двадцать "; 
        $des[3]="тридцать "; 
        $des[4]="сорок "; 
        $des[5]="пятьдесят "; 
        $des[6]="шестьдесят "; 
        $des[7]="семьдесят "; 
        $des[8]="восемдесят "; 
        $des[9]="девяносто "; 

        $hang[1]="сто "; 
        $hang[2]="двести "; 
        $hang[3]="триста "; 
        $hang[4]="четыреста "; 
        $hang[5]="пятьсот "; 
        $hang[6]="шестьсот "; 
        $hang[7]="семьсот "; 
        $hang[8]="восемьсот "; 
        $hang[9]="девятьсот "; 

        $namerub[1]="рубль "; 
        $namerub[2]="рубля "; 
        $namerub[3]="рублей "; 

        $nametho[1]="тысяча "; 
        $nametho[2]="тысячи "; 
        $nametho[3]="тысяч "; 

        $namemil[1]="миллион "; 
        $namemil[2]="миллиона "; 
        $namemil[3]="миллионов "; 

        $namemrd[1]="миллиард "; 
        $namemrd[2]="миллиарда "; 
        $namemrd[3]="миллиардов "; 

        $kopeek[1]="копейка "; 
        $kopeek[2]="копейки "; 
        $kopeek[3]="копеек "; 
        
        $words=""; 
        $fl=0; 

        if($i >= 100) { 
            $jkl = intval($i / 100); 
            $words .= $hang[$jkl]; 
            $i%=100; 
        }

        if($i >= 20) {
            $jkl = intval($i / 10); 
            $words.=$des[$jkl]; 
            $i%=10;
            $fl=1;
        }

        switch($i) {
            case 1:
                $fem=1;
                break; 
            case 2: 
            case 3: 
            case 4:
                $fem=2;
                break; 
            default:
                $fem=3;
                break; 
        }

        if( $i ) {
            if( $i < 3 && $f > 0 ) {
                if ( $f >= 2 ) { 
                    $words .= $_1_19[$i]; 
                } else { 
                    $words .= $_1_2[$i]; 
                }
            } else {
                $words .= $_1_19[$i]; 
            }
        }
    }

    public static function num2str($L)
    {
        $_1_2[1]="одна "; 
        $_1_2[2]="две "; 

        $_1_19[1]="один "; 
        $_1_19[2]="два "; 
        $_1_19[3]="три "; 
        $_1_19[4]="четыре "; 
        $_1_19[5]="пять "; 
        $_1_19[6]="шесть "; 
        $_1_19[7]="семь "; 
        $_1_19[8]="восемь "; 
        $_1_19[9]="девять "; 
        $_1_19[10]="десять "; 

        $_1_19[11]="одиннацать "; 
        $_1_19[12]="двенадцать "; 
        $_1_19[13]="тринадцать "; 
        $_1_19[14]="четырнадцать "; 
        $_1_19[15]="пятнадцать "; 
        $_1_19[16]="шестнадцать "; 
        $_1_19[17]="семнадцать "; 
        $_1_19[18]="восемнадцать "; 
        $_1_19[19]="девятнадцать "; 

        $des[2]="двадцать "; 
        $des[3]="тридцать "; 
        $des[4]="сорок "; 
        $des[5]="пятьдесят "; 
        $des[6]="шестьдесят "; 
        $des[7]="семьдесят "; 
        $des[8]="восемдесят "; 
        $des[9]="девяносто "; 

        $hang[1]="сто "; 
        $hang[2]="двести "; 
        $hang[3]="триста "; 
        $hang[4]="четыреста "; 
        $hang[5]="пятьсот "; 
        $hang[6]="шестьсот "; 
        $hang[7]="семьсот "; 
        $hang[8]="восемьсот "; 
        $hang[9]="девятьсот "; 

        $namerub[1]="рубль "; 
        $namerub[2]="рубля "; 
        $namerub[3]="рублей "; 

        $nametho[1]="тысяча "; 
        $nametho[2]="тысячи "; 
        $nametho[3]="тысяч "; 

        $namemil[1]="миллион "; 
        $namemil[2]="миллиона "; 
        $namemil[3]="миллионов "; 

        $namemrd[1]="миллиард "; 
        $namemrd[2]="миллиарда "; 
        $namemrd[3]="миллиардов "; 

        $kopeek[1]="копейка "; 
        $kopeek[2]="копейки "; 
        $kopeek[3]="копеек "; 

        $s = " ";
        $s1 = " ";
        $s2 = " ";
        $kop = intval( ( $L*100 - intval( $L )*100 )); 
        $L = intval($L);
        
        if ($L>=1000000000) { 
            $many=0;
            self::semantic(intval($L / 1000000000),$s1,$many,3); 
            $s .= $s1.$namemrd[$many]; 
            $L %= 1000000000;
        } 

        if ($L >= 1000000) { 
            $many=0;
            self::semantic(intval($L / 1000000),$s1,$many,2); 
            $s .= $s1 . $namemil[$many]; 
            $L %= 1000000;
            if($L==0) {
                $s.="рублей "; 
            }
        }

        if ($L >= 1000) {
            $many=0;
            self::semantic(intval($L / 1000),$s1,$many,1); 
            $s .= $s1 . $nametho[$many]; 
            $L %= 1000;
            if($L==0) {
                $s .= "рублей "; 
            }
        }

        if($L != 0) { 
            $many=0; 
            self::semantic($L,$s1,$many,0); 
            $s .= $s1.$namerub[$many]; 
        } 

        if($kop > 0) {
            $many=0;
            self::semantic($kop,$s1,$many,1); 
            $s .= $s1.$kopeek[$many]; 
        } else {
            $s .= " 00 копеек"; 
        }

        return $s; 
    }

    /** Формат вывода денег на сайте **/
    public static function money($value)
    {
        $result = number_format($value, 0, ',', '%'); 
        $result = strtr($result, array('%' => '&nbsp;'));

        return $result;
    }

    /** Округление суммы для корзины и заказа **/
    public static function round($value)
    {
        $value = round($value, -1);

        return $value;
    }
}
