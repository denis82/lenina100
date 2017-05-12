<?php
/**
 * Class pages.controllers.DefaultController
 *
 * Frontend controller for pages module
 * All requests that doesn't matches any other module/controller/action
 * are processed here
 */
class DefaultController extends Controller
{
	public $page;
    /**
     * Renders current page, if page exists
     */
    public function actionView()
    {
        $model = Page::getCurrentPage();
        if(!$model)
            throw new CHttpException(404);
        
        $this->pageTitle = $model['page_title'];
        $this->clips['content_title'] = $model['content_title'];
        $this->clips['keywords'] = $model['keywords'];
        $this->clips['description'] = $model['description'];

        $this->layout = empty($model['layout']) ? "main" : $model['layout'];
        $breadcrumbs = array();
		$this->page = $model;
        $parent = $model;
        while (($parent = $parent->parent) !== null) {
            if ($parent['url'] == '/') {
                continue;
            }
            $breadcrumbs[$parent->label.' '] = !empty($parent->params) ? $parent->param : $parent->url;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        if ($model['url'] != '/') {
            $breadcrumbs[] = $model->label;
        }

        $this->breadcrumbs = $breadcrumbs;

        $this->render('view', array(
            'model' => $model,
        ));
    }
}
