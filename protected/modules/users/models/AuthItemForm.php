<?php

class AuthItemForm extends CFormModel
{
    public $id;
    public $description;
    public $children;

    public $_authItem;
    public function __construct($authItem=null)
    {
        $this->_authItem = $authItem;

        if ($this->_authItem !== null) {
            $this->id = $this->_authItem->getName();
            $this->description = $this->_authItem->getDescription();
            $this->children = array_keys($this->_authItem->getChildren());
        }
    }

    public static function getById($id)
    {
        $authItem = Yii::app()->authManager->getAuthItem($id);
        $model = new self($authItem);

        return $model;
    }

    public function rules()
    {
        return array(
            array('id', 'length', 'max' => 255),
            array('description', 'length', 'max' => 255),
            array('children', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'Идентификатор',
            'description' => 'Описание',
            'children' => 'Задачи',
        );
    }

    public function getChildrenOptions()
    {
        $options = array();

        $items = Yii::app()->authManager->getTasks();
        foreach ($items as $name => $item) {
            $options[$name] = $item->getDescription();
        }
        
        return $options;
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->_authItem === null) {
            $this->_authItem = Yii::app()->authManager->createRole($this->id);
        }

        $this->_authItem->setDescription($this->description);
        // Сначала удаляем
        foreach ($this->getChildrenOptions() as $child => $label) {
            if ($this->_authItem->hasChild($child)) {
                $this->_authItem->removeChild($child);
            }
        }
        // Потом добавляем
        if (is_array($this->children)) {
            foreach ($this->children as $child) {
                $this->_authItem->addChild($child);
            }
        }

        $this->saveRolesToFile();

        return true;
    }

    public function delete()
    {
        Yii::app()->authManager->removeAuthItem($this->id);
        $this->saveRolesToFile();

        return true;
    }

    protected function saveRolesToFile()
    {
        $rolesFile = Yii::getPathOfAlias('application.modules.users.components').'/_roles.php';
        $roles = Yii::app()->authManager->getRoles();

        $items=array();
        foreach($roles as $name=>$item)
        {
            $items[$name]=array(
                'type'=>$item->getType(),
                'description' => $item->getDescription(),
                'bizRule' => $item->getBizRule(),
                'data' => $item->getData(),
                'children' => array_keys($item->getChildren()),
            );
        }

        $content = "<?php\nreturn ".var_export($items, true).";\n";
        file_put_contents($rolesFile, $content);
    }

}
