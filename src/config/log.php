<?php

return [
    'middleware' => [
        'auth' => 'auth:api',
        'super_admin' => 'auth:api'
    ],
    'controllers' => [
        'enabled' => true
    ],
    'email_subject' => 'Email log.',
    'levels' => [
        // Тип логирования - admin_db, user_db, user_email, user_sms, номер телефона или email адрес.
        // Для user_db обязательный параметр user_id, для user_email - email, user_sms - phone.
        'admin_warning' => ['admin_db'],
        'admin_error' => ['admin_db', '+79131111111', 'example@test.com'],
        'user_log' => ['user_db'],
        'user_notification' => ['user_db', 'user_email', 'user_sms'],

        // Ниже можно добавить свои уровни логирования.

    ],
    'templates' => [
        'admin_log' => [
            'text' => 'Лог - :text',
            'level' => 'admin_warning',
            'enabled' => true,
        ],
        'admin_error' => [
            'text' => 'Ошибка - :text',
            'level' => 'admin_error',
            'enabled' => true,
        ],
        'user_notification' => [
            'text' => 'Уведомление - :text',
            'level' => 'user_log',
            'enabled' => true
        ],
        'user_notification_2' => [
            'text' => 'Уведомление - :text',
            'level' => 'user_notification',
            'enabled' => true
        ],

        // Ниже можно добавить свои шаблоны логов.

    ]
];
