<?php
// TODO: Сделать чтобы эта информация собиралась динамически из модулей

// Пользователи
$result['users.admin'] = array(
    'type' => CAuthItem::TYPE_TASK,
    'description' => 'Управление пользователями',
    'bizRule' => null,
    'data' => null,
);
// Страниц
$result['pages.admin'] = array(
    'type' => CAuthItem::TYPE_TASK,
    'description' => 'Управление страницам',
    'bizRule' => null,
    'data' => null,
);
// Новости
$result['news.admin'] = array(
    'type' => CAuthItem::TYPE_TASK,
    'description' => 'Управление новостями',
    'bizRule' => null,
    'data' => null,
);

// Вопрос-ответ
$result['faq.admin'] = array(
    'type' => CAuthItem::TYPE_TASK,
    'description' => 'Управление Вопрос-ответом',
    'bizRule' => null,
    'data' => null,
);

// Каталог
$result['catalog.admin'] = array(
    'type' => CAuthItem::TYPE_TASK,
    'description' => 'Управление каталогом',
    'bizRule' => null,
    'data' => null,
);

// Магазин
$result['shop.admin'] = array(
    'type' => CAuthItem::TYPE_TASK,
    'description' => 'Управление магазином',
    'bizRule' => null,
    'data' => null,
);

// Опросы
$result['vote.admin'] = array(
    'type' => CAuthItem::TYPE_TASK,
    'description' => 'Управление опросами',
    'bizRule' => null,
    'data' => null,
);

// Файлы
$result['filemanager.admin'] = array(
    'type' => CAuthItem::TYPE_TASK,
    'description' => 'Управление файлами',
    'bizRule' => null,
    'data' => null,
);

// Настройки
$result['configs.admin'] = array(
    'type' => CAuthItem::TYPE_TASK,
    'description' => 'Управление настройками',
    'bizRule' => null,
    'data' => null,
);


return $result;
