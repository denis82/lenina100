<?php

class AdminMenuWidget extends CWidget
{
    public $items;
    public $actionPath;
    public $id;
    public $parent_id;
    public $title;
    
    public function run($params=array())
    {
        foreach($params as $param => $value){
            $this->$param = $value;
        }
        
        Yii::app()->clientScript->registerScript('jsTree', $this->treeScript);
        $result = '';
        
        foreach($this->items as $item){
            $result .= $this->buildTree($item);
        }
        echo '<div class="tree"><ul>'.$result.'</ul></div>';
    }
    
    private function buildTree($item)
    {
        extract(get_object_vars($this));
        $children = $item['children'];
        $item = $item['model'];
        
        $active = (isset($_GET[$id]) && $_GET[$id] == $item[$id]) ? 'active' : '';
        $link = CHtml::link($item[$title], array($actionPath. 'updateCategory', $id=>$item[$id]), array(
            'data-child-url' => Yii::app()->createAbsoluteUrl($actionPath. 'createCategory', array ($parent_id => $item[$id])),
            'data-delete-url' => Yii::app()->createAbsoluteUrl($actionPath. 'deleteCategory', array ($id => $item[$id])),
            'data-id' => $item[$id],
            'class' => $active .' jstree-open'
        ));
        if(empty($children)){
            return '<li id="node-'.$item[$id].'">' . $link . '</li>';
        }
    
        $result = '';
        foreach($children as $child){
            $result .= self::buildTree($child);            
        }
        return '<li id="node-'.$item[$id].'">'.$link.'<ul>'.$result.'</ul></li>';

    }
    
    public function getTreeScript()
    {
        $cs = Yii::app()->clientScript;
        $jsTreePath = Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR."jsTree");
        $cs->registerScriptFile($jsTreePath.'/_lib/jquery.cookie.js');
        $cs->registerScriptFile($jsTreePath.'/_lib/jquery.hotkeys.js');
        $cs->registerScriptFile($jsTreePath.'/jquery.jstree.js');
      
        return 
        '$(".tree").jstree({
            plugins: [
                "themes",
                "cookies",
                "ui",
                "contextmenu",
                "html_data",
                "dnd",
                "crrm"
            ],
            core: {
                animation: 0
            },
            contextmenu: {
                items: {
                    create: {
                        label: "Создать дочернюю страницу",
                        icon: false,
                        action: function(obj){
                            var url = $($(obj).children("a")[0]).attr("data-child-url");
                            window.location = url;
                        }
                    },
                    remove: {
                        label: "Удалить страницу",
                        icon: false,
                        action: function(obj) {
                            var url = $($(obj).children("a")[0]).attr("data-delete-url");
                            if(confirm("Вы действительно хотите удалить страницу?")) {
                                window.location = url;
                            }
                        }
                    },
                    ccp: false,
                    rename: false
                }
            },
            themes: {
                theme: "classic",
                url: "'.$jsTreePath.'/themes/classic/style.css"
            },
            crrm: {
                move: {
                    check_move: function (m) {
                            var p = this._get_parent(m.o);
                            return !(m.np[0].nodeName.toLowerCase() == "div")

                            //if(!p) return false;
                            //p = p == -1 ? this.get_container() : p;
                            //if(p === m.np) return true;
                            //if(p[0] && m.np[0] && p[0] === m.np[0]) return true;
                            //return false;
                    }
                }
            },
            dnd: {
            }
        });

        // причем иконки или точки или и то и другое вместе
        $(".tree")
            //.jstree("hide_dots")
            //.jstree("hide_icons");

        $(".tree").bind("select_node.jstree", function(event,data){
            $(".tree a").removeClass("active");
            window.location = $($(data.rslt.obj).children("a")[0]).attr("href");
        });

        $(".tree").bind("move_node.jstree", function(event, data){
            var dragTargetId = $($(data.rslt.o).children("a")[0]).attr("data-id");
            var dropTargetId = $($(data.rslt.r).children("a")[0]).attr("data-id")
            var position = data.rslt.p;
            $.ajax({
                type: "POST",
                url: "'.$this->controller->createUrl('tree').'",
                data: {dropTarget: dropTargetId, dragTarget: dragTargetId, position: position},
                success: function(data){
                },
                error: function(xhr, status, error){
                    alert(status);
                }
            });
        })';
    } 
}

