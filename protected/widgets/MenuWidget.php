<?php

class MenuWidget extends CWidget
{
    public $model = 'CatalogCategory';//for example "CatalogCategory"
    public $type = 'main'; //'local' - for menu of current page as parent
    public $view = 'mainMenu'; // filename like 'mainMenu' - in folder /themes/default/views/Menu
    public $rootId = 1;
    public $conditions1 = array('pid'=>1);
    public $conditions2 = array('order'=>'id');
    
    public function run()
    {
        if($this->type == 'local'){
            $id = isset($_GET['pid']) ? $_GET['pid'] : 0; 
            $parent = CActiveRecord::model($this->model)->findByAttributes(array('pid'=>$id));
            if(!$parent)
                return;
            
            $this->conditions1['pid'] = $this->rootId = $parent->id;
        } 

        $items = CActiveRecord::model($this->model)->findAllByAttributes(
            $this->conditions1, $this->conditions2);
        
        if(!$items) return;

        $items = $this->toTree($items);
        $this->render($this->view, array('items'=>$items));
    }

    private function toTree($items)
    {
        $result = array();
        $list = array();
      
        foreach($items as $item){
            $thisref = &$result[$item->id];
        
            $thisref = $item;
        
            if($item->pid == $this->rootId){
                $list[$item->id] = &$thisref;
            }else{
                $result[$item->pid]['children'][ $item->id ] = &$thisref;
            }
        }
        return $result;
    }    
}
