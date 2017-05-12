<?php

class ARTreeBehavior extends CActiveRecordBehavior
{
    public $id = 'id';
    public $parent_id = 'pid';
    public $rootId = 1;
    public $title = 'title';
    public $rank = 'rank';
    public $level = 'level';
    public $url = 'url';
    public $name = 'name';
    public $actionPath = '/page/admin/';
    
    private $parent;
    private $children;
    private $list = array();
    private $menu = array();
    
    public function getList()
    {
        extract(get_object_vars($this));
        $result = array();
        $items = $this->getOwner()->findAll();
        $tree = $this->toTree($items);
        $this->reduceArray($tree);
        return $this->list;
    }

    public function getAllDescendants()
    {
        extract(get_object_vars($this));
        $model = $this->getOwner();
        $this->rootId = $model->$id;
        return $this->toTree($model->findAll());
    }
    
    public function getDescendantsList($items=array())
    {
        $result = array();
        $items = !empty($items) ? $items : $this->allDescendants;
        foreach($items as $item){
            $result[] = $item['model'];
            if($item['children']){
                $result = array_merge($result, $this->getDescendantsList($item['children']));
            }
        }
        return $result;
    }
    
    public function getAdminMenu()
    {
        extract(get_object_vars($this));
        include(dirname(__FILE__).DIRECTORY_SEPARATOR.'AdminMenuWidget.php');
        $this->rootId = 0;
        $items = $this->toTree($this->getOwner()->findAll());
        $widget = new AdminMenuWidget;
        return $widget->run(compact('items', 'actionPath', 'id', 'parent_id', 'title'));
    }
    
    public function beforeSave()
    {
        extract(get_object_vars($this));
        $model = $this->getOwner();
        $parent = $this->getParent($model);
        if($model->isNewRecord && $parent){
            if(isset($model->$rank)){
                $model->$rank = $this->getNewRank();                
            }

            if(isset($model->$level))
                $model->$level = $parent->$level+1;
        }
        if(isset($model->$url) && isset($model->$name)){
            $model->$url = $model->$name;
            if($parent && isset($model->$url) && isset($model->$name)){
                $model->$url = $parent->$url . (substr($parent->$url, -1) == '/' ? '' : '/') . $model->$name;
            }            
        }

        return true;
    }

    public function afterSave() {
        foreach ($this->getChildren() as $child)
            $child->save();
    }
    
    public function afterDelete()
    {
        foreach ($this->getChildren() as $child)
            $child->delete();        
    }
    
    public function getNewRank()
    {
        extract(get_object_vars($this));
        $model = $this->getOwner();
        $result = $model->findByAttributes(
            array($parent_id => $model->$parent_id), 
            array('order' => "$rank DESC")
        );
        return $result ? $result->$rank + 1 : 0;
    }
    
    public function move($target, $position)
    {
        extract(get_object_vars($this));
        $model = $this->getOwner();
        switch($position){
            case 'before':
                $parent = $this->getParent($target);
                $model->$rank = $target->$rank;
                break;
            case 'after':
                $parent = $this->getParent($target);
                $model->$rank = $target->$rank+1;
                break;
            case 'first':
                $parent = $target;
                $model->$rank = 1;
                break;
            default:
                $parent = $target;
                $model->$rank = $this->getNewRank();
        }
        
        $model->$parent_id = $parent->$id;
        $this->setLevel($model);
        $children = $this->getChildren($parent);
        if($children){
            foreach($children as $child){
                if($child->$rank < $model->$rank) 
                    continue;
                $child->$rank++;
        //        $this->setLevel($child);
                $child->save();
            };            
        }

        $model->save();
        return $model->$rank;
    }
    
    public function getParent($model=false)
    {
        extract(get_object_vars($this));
        $model = $model ? $model : $this->getOwner();
        return $model->findByAttributes(array($id => $model->$parent_id));
    }
    
    public function getLevel($model=false, $forced=false)
    {
        extract(get_object_vars($this));
        $level = 0;
        $model = $model ? $model : $this->owner;
        if(!$forced && isset($model->$level) && $model->$level)
            return $model->$level;
        
        $parent = $this->getParent($model);
        while($parent){
            $level++;
            $parent = $this->getParent($parent);
        }
        return $level;
    }
    
    private function setLevel($model=false)
    {
        extract(get_object_vars($this));
        $model = $model ? $model : $this->getOwner();
        if(!isset($model->$level))
            return;
        $model->$level = $this->getLevel($model, true);
    }
    
    public function getChildren($model=false)
    {
        extract(get_object_vars($this));
        $model = $model ? $model : $this->getOwner();
        return $model->findAllByAttributes(array($parent_id => $model->$id));
    }
    
    private function toTree($items, $range=true)
    {
        extract(get_object_vars($this));
        $result = array();
        $list = array();
        $rank = ($range && isset($rank) && isset($items[0][$rank])) ? $rank : false;

        foreach($items as $item){
            $thisref = &$result[$item[$id]];
            $children = isset($result[$item[$id]]['children']) 
                ? $result[$item[$id]]['children'] : array();
            $thisref = array('model'=>$item, 'children'=>$children);
            if($item->$parent_id == $rootId){
                $list[$item[$id]] = &$thisref;
            }else{
                $result[$item[$parent_id]]['children'][$item[$id]] = &$thisref;
            }
        }

        return $rank ? $this->rangeTree($list, $rank) : $list;
    }
    
    private function rangeTree($items, $rank)
    {
        $result = array();
        foreach($items as $item){
            if($item['children'])
                $item['children'] = $this->rangeTree($item['children'], $rank);
            $result[$item['model'][$rank]] = $item;
        }
        ksort($result);
        return $result;
    }
    
    public function getActive()
    {
        extract(get_object_vars($this));
        return $this->getOwner()->$url == $_SERVER['REQUEST_URI'];
    }
    
    private function reduceArray($items)
    {
        extract(get_object_vars($this));
        foreach($items as $item){
            $children = $item['children'];
            $item = $item['model'];
            
            $level = $this->getLevel($item);
            $str = str_repeat('--', $level-1);
            $this->list[$item->$id] = $str. $item->$title;
            if($children){
                $this->reduceArray($children);
            }
        }
    }
}