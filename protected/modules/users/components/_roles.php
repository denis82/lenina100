<?php
return array (
  'guest' => 
  array (
    'type' => 2,
    'description' => 'Гость',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
    ),
  ),
  'user' => 
  array (
    'type' => 2,
    'description' => 'Зарегистрированный пользователь',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
    ),
  ),
  'admin' => 
  array (
    'type' => 2,
    'description' => 'Администратор',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'pages.admin',
      1 => 'news.admin',
      2 => 'faq.admin',
      3 => 'expert.admin',
      4 => 'banner.admin',
      5 => 'users.admin',
      6 => 'filemanager.admin',
      7 => 'configs.admin',
      8 => 'info.admin',
      9 => 'reviews.admin',
    ),
  ),
  'root' => 
  array (
    'type' => 2,
    'description' => 'Суперпользователь',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
    ),
  ),
);
