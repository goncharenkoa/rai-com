<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'rai.com');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '56565454123');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'UM-&&BrO<*r]iUn$:-Dc<!6u !$GF6VCa#,_oy`jarm7b)FAR;4,IAd#M;q`[/8!');
define('SECURE_AUTH_KEY',  'No; n|rW&fYkQnIQYwr1rNd]b-8W^Muy=$60h~nC#Qxa.1^X@|wShZ_Kahi|ib1d');
define('LOGGED_IN_KEY',    'LU-J-s,0[q0-lrqGv#2J+O6!.P>7+E|3U%acR9+WJ,]gZH` lNxbr64*zI>Ww|E?');
define('NONCE_KEY',        'EA@;@kR%c_S=JF0kFC@+s#l#bj; |cv^85)i0I!e</ujWZ7=lk.LyKDnfMSw+4cd');
define('AUTH_SALT',        'Jb+Y=KC{5l>yq-n -a]b8fo=tJX0#oS6@*H@BJ1$C>IB!&t)):]-RdIX]D2&1%3i');
define('SECURE_AUTH_SALT', '0Au$U<OGr[6NC atq>@L_^MMmB2>o{yig0ee-HFY |GAAT2^@`m^X7tJc$bV>|M4');
define('LOGGED_IN_SALT',   'gWZWk^=Cn|]?zL~+& `3$,XrA@_3w2mbky-md)>a=muRxpFx/h8GvRY;KiOJ+N}0');
define('NONCE_SALT',       '0{h@)9<(A$Qv&2HJhkg5jb%s+_ed{C9@uwWMoE_s]]Yhdob(u!x~ThpAk#ex0kXk');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define('FS_METHOD', 'direct');
/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
