<?php

return array(
    'initial' => 'pending',
    'node' => array(
        array(
            'id' => 'pending',
            'label' => 'Ожидает ответа',
            'letter' => false,
        ),
        array(
            'id' => 'draft',
            'label' => 'Черновик',
            'letter' => false,
            'constraint' => '!$this->isNewRecord',
        ),
        array(
            'id' => 'answered',
            'label' => 'Отвеченный',
            'letter' => true,
        ),
    ),
);
