<?php

class SearchController extends Controller
{
    public function actionSearch()
        {
                $search = new SiteSearchForm;
                
                if(isset($_POST['SiteSearchForm'])) {
                        $search->attributes = $_POST['SiteSearchForm'];
                        $_GET['searchString'] = $search->string;
                } else {
                        $search->string = $_GET['searchString'];
                }
                
                $criteria = new CDbCriteria(array(
                        'condition' => 'status='.Material::STATUS_PUBLISHED.' AND content LIKE :keyword',
                        'order' => 'create_time DESC',
                        'params' => array(
                                ':keyword' => '%'.$search->string.'%',
                        ),
                ));
                
                $materialCount = Material::model()->count($criteria);
                $pages = new CPagination($materialCount);
                $pages->pageSize = Yii::app()->params['materialsPerPage'];
                $pages->applyLimit($criteria);
                
                $materials = Material::model()->findAll($criteria);
                                                    
                $this->render('found',array(
                        'materials' => $materials,
                        'pages' => $pages,
                        'search' => $search,
                ));

        }
}