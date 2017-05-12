<?php

/**
 * Class Menu
 * 
 * Renders menu based on {{pages}} table
 * Class able to render plain or tree menu, check activity 
 * of menu items, or render supplied view.
 */
Yii::import('pages.models.Page');

class Menu extends CWidget
{
    /**
     * @var integer number of nested levels to be rendered
     */
    public $level = 5;
    public $view;

    public function run()
    {
        $items = Page::model()->findAllByAttributes(array(), 
            array(
                'condition'=>'level < ' . ($this->level+2),
                'order'=>'lft'
            )
        );
        
        if (count($items) === 0)
            return;
        
        $items = self::removeInvisible($items);
        $tree = Page::model()->tree->hierarchical($items);
        $this->render($this->view, array('tree'=>$tree, 'view'=>$this->view));
    }
    
    public function isActive($url)
    {
        $path = $_SERVER['REQUEST_URI'];
        if($url == '/')
            return $url == $path;
        return strstr($path, $url);
    }

    /**
     * filters array, removing invisible items and their children
     * @var $items array of this model objects  
     * @author bariew
     * @return filtered array of visible menu items
     */
    protected static function removeInvisible($items)
    {
        $result = array();
        $level = 0; 
        $visible = TRUE;
        foreach($items as $item){
            // Добавляем в массив видимые эелементы и главную страницу, даже если она спрятана
            if($item->is_visible || $item->level == 1){
                //добавляем только если итем уровнем выше установленного ранее уровня или включена видимость итемов
                if($level >= $item->level || $visible){
                    array_push($result, $item);//
                    $visible = TRUE;
                }
            //не добавляем невидимых, а также устанавливаем уровень и режим невидимости, если включена видимость 
            //или данный итем уровнем выше прежнего установившего невидимость
            }else if($visible || $level > $item->level){
                $level = $item->level;
                $visible = FALSE;
            }
        }
        return $result;
    }
}
