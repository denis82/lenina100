<?php

class AdminPagesWidget extends CWidget {

    public function run() {
        $cs = Yii::app()->clientScript;

        $jsTreePath = Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR."jsTree");
        $cs->registerScriptFile($jsTreePath.'/_lib/jquery.cookie.js');
        $cs->registerScriptFile($jsTreePath.'/_lib/jquery.hotkeys.js');
        $cs->registerScriptFile($jsTreePath.'/jquery.jstree.js');

        $cs->registerScript('jsTree', '
            $(".tree").jstree({
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
            })

        ');

        $parentCriteria = new CDbCriteria();
        $parentCriteria->condition = 'url = :url';
        $parentCriteria->params = array(':url' => '/');
        $root = Page::model()->find($parentCriteria);

        $criteria = new CDbCriteria;
        $criteria->order = 'lft';

        $items = array($root);
        $items = array_merge($items, $root->descendants()->findAll($criteria));
        $this->render('adminWidget', array('items' => $items));
    }
}
