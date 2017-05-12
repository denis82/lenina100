<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminExpertWidget
 *
 * @author V
 */
class AdminExpertWidget extends CWidget {

    public function run() {
        $items = ExpertCategory::model()->findAll();
        $this->render('adminExpertWidget', array('items'=>$items));
    }

}
