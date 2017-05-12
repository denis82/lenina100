<?php

/**
 * AdminController
 *
 * Backend controller for Pages module
 *
 * @property string $layout Название макета в папке layouts
 *
 * @author Студия 3 Цвета <3@3colors.ru>
 */
class AdminController extends EAdminController
{
    public $pageDescription = '';
    public $layout = 'admin';

    /**
     * Выводит пустое представление
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Страницы сайта';

        $this->clips['title'] = 'Страницы сайта';

        $this->render('index');
    }

    /**
     *
     * Создание дочерней страницы
     *
     * @param integer $id id страницы
     */
    public function actionChild($id)
    {
        $parent = $this->loadModel($id);
        $child = new Page;

        if (isset($_POST['Page']) && isset($_POST['Page']['type']) && (int) $_POST['Page']['type'] == 1) {
            $child->scenario = Page::SCENARIO_LINK;
        } else {
            $child->scenario = Page::SCENARIO_PAGE;
        }

        if ($parent && isset($_POST['Page'])) {
            $child->attributes = $_POST['Page'];

            if ($child->scenario == Page::SCENARIO_PAGE) {
                $child->url = $parent->url . ($parent->name == '/' ? '' : '/') . $child->name;
            }

            if ($parent->append($child, true)) {
                Yii::app()->user->setFlash('success', 'Страница создана успешно.');
                $this->redirect(array('index'));
            }
        }

        $this->pageTitle = 'Создание дочерней страницы';
        $this->clips['title'] = 'Создание дочерней страницы';

        $this->breadcrumbs = array(
            'Создание страницы',
        );

        $this->render('forms/form', array(
            'parent' => $parent,
            'model' => $child
        ));
    }

    /**
     * Редактированеи страницы
     *
     * @param integer $id id страницы
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $model->scenario = Page::SCENARIO_PAGE;

        if (isset($_POST['Page']) && isset($_POST['Page']['type']) && (int)$_POST['Page']['type'] == 1) {
            $model->scenario = Page::SCENARIO_LINK;
        }

        if ($model && isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];

            if ($model->saveNode(true)) {
                Yii::app()->user->setFlash('success', 'Изменения успешно сохранены.');
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('error', 'Не удалось сохранить изменения.');
            }
        }

        $this->pageTitle = 'Редактирование страницы';
        $this->clips['title'] = 'Редактирование страницы';

        $this->breadcrumbs = array(
            'Редактирование страницы',
        );

        if ($model) {
            $this->render('forms/form', array(
                'model' => $model
            ));
        }
    }

    /**
     * Сортировка страницы
     */
    public function actionTree()
    {
        $target = $this->loadModel($_POST['dropTarget']);
        $item = $this->loadModel($_POST['dragTarget']);
        switch ($_POST['position']){
            case 'before':
                $r = $item->moveBefore($target);
                break;
            case 'after':
                $r = $item->moveAfter($target);
                break;
            case 'first':
                $r = $item->moveAsFirt($target);
                break;
            case 'last':
                $r = $item->moveAsLast($target);
                break;
        }
        if (isset($r) && !$r)
            throw new CHttpException (500, 'Ошибка изменения порядка сортировки страниц.');
        else $item->saveNode(true);
    }


    /**
     * Удаление страницы по id
     *
     * @param string $id id страницы
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model) {
            $model->deleteNode();
            Yii::app()->user->setFlash('success', 'Страница удалена успешно.');
            $this->redirect(array('index'));
        } else {
            throw new CHttpException(404);
        }
    }

    /**
     * Load and returns page model by id
     *
     * @param integer $id id страницы
     *
     * @return object Page model
     */
    protected function loadModel($id)
    {
        if (!isset($id) || empty($id)) {
            throw new CHttpException (404);
        }
        $model = Page::model()->find("id = :id", array(":id" => $id));
        if (!$model) {
            throw new CHttpException (404);
        }

        return $model;
    }
}
