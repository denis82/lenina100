<?php
/**
 * Description of AdminBannerWidget
 * @author V
 */
class AdminBannerWidget extends CWidget {

    public function run() {
        $items = BannerCategory::model()->findAll();
        $this->render('adminBannerWidget', array('items'=>$items));
    }

}
