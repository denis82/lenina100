<?php

return array(
    'initial' => 'new',
    'node' => array(
        array(
            'id' => 'new',
            'label' => 'Новый',
            'transition' => 'payed',
        ),
        array(
            'id' => 'payed',
            'label' => 'Оплаченный',
            'transition' => 'ready',
            'constraint' => '!$this->isNewRecord',
        ),
        array(
            'id' => 'ready',
            'label' => 'Выполненый',
        ),
    ),
);
