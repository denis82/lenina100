<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    public $layout = 'main';
    public $pageTitle = '';
    public $title = '';
    public $keywords = '';
    public $description = '';
    private $_pageCaption = null;
    private $_pageDescription = null;

    public function init()
    {
        Yii::import('pages.models.*');
        $page = Page::getCurrentLink();
        if(!$page) return true;
        
        $this->pageTitle = $page['page_title'];
        $this->clips['content_title'] = $page['page_title'];
        $this->clips['description'] = $page['description'];
        $this->clips['keywords'] = $page['keywords'];
    }
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * @return string the page heading (or caption). Defaults to the controller name and the action name,
     * without the application name.
     */
    //public function getPageCaption() {
        //if ($this -> _pageCaption !== null)
            //return $this -> _pageCaption;
        //else {
            //$name = ucfirst(basename($this -> getId()));
            //if ($this -> getAction() !== null && strcasecmp($this -> getAction() -> getId(), $this -> defaultAction))
                //return $this -> _pageCaption = $name . ' ' . ucfirst($this -> getAction() -> getId());
            //else
                //return $this -> _pageCaption = $name;
        //}
    //}

    /**
     * @param string $value the page heading (or caption)
     */
    //public function setPageCaption($value) {
        //$this -> _pageCaption = $value;
    //}

    /**
     * @return string the page description (or subtitle). Defaults to the page title + 'page' suffix.
     */
    //public function getPageDescription() {
        //if ($this -> _pageDescription !== null)
            //return $this -> _pageDescription;
        //else {
            //return Yii::app() -> name . ' ' . $this -> getPageCaption() . ' page';
        //}
    //}

    /**
     * @param string $value the page description (or subtitle)
     */
    //public function setPageDescription($value) {
        //$this -> _pageDescription = $value;
    //}

    /**
     * sets flash to the user
     * @param string $name �������� flash
     * @param mixed @flash ���� ���������, ����� ���� �������,
     * ���� ��������, ���� ������ �� ������ �������������� �����
     * type � message
     */
    public function setFlash($name = null, $flash) {
        if ($name !== null && !empty($flash)) {
            Yii::app() -> user -> setFlash($name, $flash);
        }
    }

}
