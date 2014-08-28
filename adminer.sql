-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `acl_resourse`;
CREATE TABLE `acl_resourse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resourse` char(100) NOT NULL,
  `group` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `acl_resourse` (`id`, `resourse`, `group`) VALUES
(1, 'Front_login_index_index',  'guest'),
(2, 'Front_login_check_index',  'guest'),
(3, 'Front_index_index_index',  'user'),
(4, 'admin_index_index_index',  'moderator'),
(5, 'Front_login_logout_index', 'guest'),
(13,  'Front_login_register_index', 'guest'),
(12,  'Front_user_profile_index', 'user'),
(50,  'admin_concept_comment_new',  'moderator'),
(15,  'admin_user_index_index', 'admin'),
(16,  'admin_user_index_one', 'admin'),
(17,  'Front_concept_index_index',  'user'),
(18,  'Front_concept_discussed_index',  'user'),
(19,  'Front_concept_new_index',  'user'),
(20,  'Front_concept_add_index',  'user'),
(21,  'Front_concept_index_one',  'user'),
(22,  'Front_error_404_index',  'guest'),
(23,  'ajax_file_upload_index', 'guest'),
(24,  'ajax_file_imageViever_index',  'guest'),
(25,  'ajax_file_fileDowloader_index',  'guest'),
(26,  'admin_concept_index_index',  'moderator'),
(27,  'admin_concept_index_one',  'moderator'),
(28,  'admin_concept_concept_moderating_index', 'moderator'),
(29,  'admin_concept_concept_delete_index', 'moderator'),
(30,  'admin_concept_comment_index',  'moderator'),
(31,  'admin_concept_comment_one',  'moderator'),
(32,  'admin_concept_comment_moderating_index', 'moderator'),
(33,  'admin_concept_comment_delete_index', 'admin'),
(34,  'admin_mailTemplate_index_index', 'admin'),
(35,  'admin_mailTemplate_edit_index',  'admin'),
(36,  'admin_user_import_index',  'admin'),
(37,  'admin_user_new_index', 'admin'),
(38,  'admin_mailTemplate_delete_index',  'admin'),
(39,  'admin_user_progressuser_index',  'admin'),
(40,  'admin_user_progressidea_index',  'admin'),
(41,  'Front_concept_selectvid_index',  'user'),
(42,  'Front_text_index_one', 'user'),
(43,  'ajax_concept_likeadd_index', 'user'),
(44,  'ajax_concept_sponsoradd_index',  'sponsor'),
(45,  'Front_tags_index_one', 'user'),
(46,  'Front_concept_deletecomment_index',  'user'),
(47,  'Front_user_index_one', 'user'),
(48,  'Front_search_index_index', 'user');

DROP TABLE IF EXISTS `concept`;
CREATE TABLE `concept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `anonimus` enum('n','y') NOT NULL COMMENT 'В режиме анонимно',
  `name` char(70) NOT NULL,
  `problem` char(70) NOT NULL,
  `solution` char(70) NOT NULL COMMENT 'Решение проблемы',
  `result` char(70) NOT NULL,
  `foto` char(37) NOT NULL,
  `date` int(11) NOT NULL,
  `comment_count` int(11) NOT NULL DEFAULT '0',
  `moderating` enum('n','y') NOT NULL DEFAULT 'n' COMMENT 'Проверено или нет',
  `moderating_data` int(11) NOT NULL COMMENT 'Когда проверино',
  `moderating_id` int(11) NOT NULL COMMENT 'Кто проверил',
  `file_1_name` char(50) NOT NULL,
  `file_1` char(37) NOT NULL,
  `file_2_name` char(50) NOT NULL,
  `file_2` char(37) NOT NULL,
  `file_3_name` char(50) NOT NULL,
  `file_3` char(37) NOT NULL,
  `points` int(11) NOT NULL COMMENT 'Начисленные баллы для этой идеи',
  `post_like` int(11) NOT NULL COMMENT 'Количество лайков (понравилось)',
  `implemented` enum('n','y') NOT NULL COMMENT 'Реализована идея или нет',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `concept` (`id`, `user_id`, `anonimus`, `name`, `problem`, `solution`, `result`, `foto`, `date`, `comment_count`, `moderating`, `moderating_data`, `moderating_id`, `file_1_name`, `file_1`, `file_2_name`, `file_2`, `file_3_name`, `file_3`, `points`, `post_like`, `implemented`) VALUES
(1, 1,  'n',  'Название идеи',  'Проблема', 'решение',  'результат',  '', 1406535239, 2,  'y',  1407140145, 1,  '', '', '', '', '', '', 17, 1,  'n'),
(3, 1,  'y',  'Название 233333',  'Название 12345', 'Решение решение решение',  'Результат, результат, результат',  '', 1406537607, 2,  'y',  1407140137, 1,  '', '', '', '', '', '', 0,  0,  'y'),
(4, 1,  'n',  'gggg', 'hhhhhhhhhhh',  'jjjjjjjjj',  'kkkkkkkkkkkkk',  '58618108b1ab678426458a45df3bd37c.jpg', 1406724001, 1,  'y',  1407140127, 1,  '', '', '', '', '', '', 5,  10, 'n'),
(5, 1,  'n',  'Проверка идеи',  'Проверка идеи',  'Проверка идеи',  'Проверка идеи',  '16e79c395dcd7a53d1482c8d843c7bdb.jpg', 1406791189, 4,  'y',  1407140660, 1,  'Это файл PDF', 'fc2061e4fdc468fae0f462e786a44171.pdf', '', '', '', '', 0,  1,  'n'),
(6, 1,  'n',  '1111111111111111', '22222222222222', '333333333333', '4444444444444',  'c45aea4079bd5aee6e9dddb4e3367018.jpg', 1406813575, 3,  'y',  1407140661, 1,  '13-sbornik-22-luchshix-form-vxoda.zip',  'dd8e49d091a808e987af9d4228350882.zip', '22-sbornik-22-luchshix-form-vxoda.zip',  'ad4ad39b26ed505994f8ae472d6c6813.zip', '22-sbornik-22-luchshix-form-vxoda.zip',  'ad4ad39b26ed505994f8ae472d6c6813.zip', 4,  2,  'n'),
(7, 159,  'n',  'йййй йййй',  'йййй йййй',  'йййй йййй',  'йййй йййй',  '7bea1cacedd1cbc672f3797ce9cedd36.jpg', 1409133853, 0,  'y',  1409224534, 161,  'кладовая идей.pdf',  'fc2061e4fdc468fae0f462e786a44171.pdf', '', '', '', '', 0,  0,  'n'),
(8, 159,  'y',  '222 222',  '222222222',  '2222222222', '2222222222222',  'c3e18c4f49e61793659e1e06cfd9803f.jpg', 1409134715, 0,  'y',  1409224533, 161,  'FGCS_medtronic_ideas_tz_v1.pdf', 'bd57efcada70d57bd2021db9d1a0de61.pdf', '', '', '', '', 0,  0,  'n'),
(9, 159,  'n',  '3333333333333',  '333333333333', '3333333333333',  '3333333333', 'd9ccb2491393f97bd281b5d0c043aa86.jpg', 1409135278, 0,  'y',  1409224532, 161,  '', '', '', '', '', '', 0,  0,  'n'),
(10,  159,  'y',  '4444444444', '44444444444',  '44444444444',  '4444444444444444444',  'b6fd1dad7edb3751e344d8b4b11fab22.jpg', 1409135500, 0,  'y',  1409224531, 161,  '', '', '', '', '', '', 0,  0,  'n'),
(11,  159,  'y',  '4444444444', '44444444444',  '44444444444',  '4444444444444444444',  'b6fd1dad7edb3751e344d8b4b11fab22.jpg', 1409135545, 0,  'y',  1409224530, 161,  '', '', '', '', '', '', 0,  0,  'n'),
(12,  159,  'y',  '4444444444', '44444444444',  '44444444444',  '4444444444444444444',  'b6fd1dad7edb3751e344d8b4b11fab22.jpg', 1409135603, 0,  'y',  1409224459, 161,  '', '', '', '', '', '', 0,  0,  'n'),
(13,  159,  'y',  '55555555555',  '55555555555',  '555555555',  '55555555555555', '6128efe24df823a088e8ec168bac480d.jpg', 1409136028, 0,  'y',  1409224457, 161,  '13-sbornik-22-luchshix-form-vxoda.zip',  'dd8e49d091a808e987af9d4228350882.zip', '', '', '', '', 8,  0,  'n');

DROP TABLE IF EXISTS `concept_comment`;
CREATE TABLE `concept_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `concept_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_avatar` char(36) NOT NULL,
  `title` char(70) NOT NULL,
  `body` char(200) NOT NULL,
  `date` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `moderating` enum('n','y') NOT NULL DEFAULT 'n',
  `moderating_data` int(11) NOT NULL,
  `moderating_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `concept_comment` (`id`, `concept_id`, `user_id`, `user_avatar`, `title`, `body`, `date`, `parent_id`, `moderating`, `moderating_data`, `moderating_id`) VALUES
(1, 3,  1,  '', '', 'Проверочный комментарий к этому сообщению....',  1406549511, 0,  'y',  1407149178, 1),
(2, 5,  1,  '', '', 'Проверка комментирования Проверка комментирования Проверка комментирования Проверка комментирования Проверка комментирования Проверка комментирования Проверка комментирования Проверка комментирования',  1406792332, 0,  'y',  1407149164, 1),
(3, 5,  1,  '', '', 'if you delete this the sky will fall on your head if you delete this the sky will fall on your head if you delete this the sky will fall on your head if you delete this the sky will fall on your head',  1406794203, 0,  'y',  1407149112, 1),
(4, 5,  1,  '', '', 'А теперь со счетчиком!!!!!!! А теперь со счетчиком!!!!!!! А теперь со счетчиком!!!!!!! А теперь со счетчиком!!!!!!! А теперь со счетчиком!!!!!!!', 1406794314, 0,  'y',  1407148875, 1),
(5, 1,  1,  '', '', 'А теперь со счетчиком!!!!!!! А теперь со счетчиком!!!!!!! А теперь со счетчиком!!!!!!! А теперь со счетчиком!!!!!!! А теперь со счетчиком!!!!!!! А теперь со счетчиком!!!!!!! А теперь со счетчиком!!!!!', 1406794330, 0,  'y',  1407150091, 1),
(6, 4,  1,  '', '', ' c.id as id, c.name as name, c.comment_count as comment_count, c.foto as foto, c.anonimus as anonimus  c.id as id, c.name as name, c.comment_count as comment_count, c.foto as foto, c.anonimus as anoni', 1406794397, 0,  'y',  1407150094, 1),
(7, 3,  1,  '', '', ' c.id as id, c.name as name, c.comment_count as comment_count, c.foto as foto, c.anonimus as anonimus  c.id as id, c.name as name, c.comment_count as comment_count, c.foto as foto, c.anonimus as anoni', 1406794413, 0,  'y',  1407150096, 1),
(8, 6,  1,  '', '', 'Добавляем комментарий Добавляем комментарий Добавляем комментарий Добавляем комментарий Добавляем комментарий Добавляем комментарий Добавляем комментарий Добавляем комментарий Добавляем комментарий До', 1409048588, 0,  'y',  1409224516, 161),
(9, 5,  159,  '', '', 'Проверка комментария от пользователя! простого пользователя с правами User.',  1409120452, 0,  'y',  1409224515, 161),
(19,  1,  159,  '', '', 'уууууууууууууууууууууууууууу', 1409127530, 0,  'y',  1409224505, 161),
(18,  6,  159,  '', '', 'Еще один комментарий юзера', 1409123416, 0,  'y',  1409224510, 161),
(17,  6,  159,  '', '', 'Это юзер комментировал))))', 1409123167, 0,  'y',  1409224514, 161);

DROP TABLE IF EXISTS `concept_events`;
CREATE TABLE `concept_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` char(50) NOT NULL,
  `name` char(200) NOT NULL,
  `Credits` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `concept_events` (`id`, `key`, `name`, `Credits`) VALUES
(1, 'implementation_idea',  'реализация идеи',  1000),
(2, 'add_image',  'Добавление изображения в идею',  3),
(3, 'ad_file',  'Добавление файла в идею',  5),
(4, 'comments', 'Комментарий',  2),
(5, 'idea_supported_sponsor', 'идею поддержал спонсор', 15);

DROP TABLE IF EXISTS `concept_licke`;
CREATE TABLE `concept_licke` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `concept_id` int(11) NOT NULL,
  `datetime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `concept_licke` (`id`, `user_id`, `concept_id`, `datetime`) VALUES
(1, 1,  6,  123456789),
(2, 1,  4,  1409038664),
(3, 1,  1,  1409038885),
(4, 1,  5,  1409048790),
(5, 159,  6,  1409123430);

DROP TABLE IF EXISTS `concept_sponsor`;
CREATE TABLE `concept_sponsor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `concept_id` int(11) NOT NULL,
  `datetime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `concept_sponsor` (`id`, `user_id`, `concept_id`, `datetime`) VALUES
(1, 1,  4,  1234567890),
(3, 1,  1,  1409047253);

DROP TABLE IF EXISTS `events_log`;
CREATE TABLE `events_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `concept_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `mail_templates`;
CREATE TABLE `mail_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `description` char(255) NOT NULL,
  `title` char(100) NOT NULL,
  `body` text NOT NULL,
  `subject` char(255) NOT NULL,
  `info` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `mail_templates` (`id`, `name`, `description`, `title`, `body`, `subject`, `info`) VALUES
(2, 'invitation', 'Приглашение на сайт',  'Приглашение на сайт',  'Вы приглашены на сайт))))\r\nПерейдите по ссылке <a href=\"http://blog.test/login/?url={url}\">http://blog.test/login/?url={url}</a>', 'Приглашение на сайт',  ''),
(3, 'access_information', 'Первый вход на сайт отправка доступа', 'Первый вход пользователя', 'Поздравляю Вас Вы вошли на сайт www.site.ru\r\nВащ логин {Login}\r\nВаш пароль {Pass}',  'Поздравляю с первым сбитым!)', '');

DROP TABLE IF EXISTS `mail_template_values`;
CREATE TABLE `mail_template_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `key` char(50) NOT NULL,
  `value` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` char(100) NOT NULL,
  `name` char(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `tags` (`id`, `url`, `name`) VALUES
(1, 'test', 'проверка'),
(2, 'test1',  'Проверка1'),
(3, '1111111111', '1111111111'),
(4, '222222222222', '222222222222'),
(5, 'eto_teg',  'Это тег'),
(6, 'eto_eshe_teg', 'Это еще тег');

DROP TABLE IF EXISTS `tags_to_concept`;
CREATE TABLE `tags_to_concept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tags_id` int(11) NOT NULL,
  `concept_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `tags_to_concept` (`id`, `tags_id`, `concept_id`) VALUES
(1, 1,  1),
(2, 1,  3),
(3, 1,  4),
(4, 2,  5),
(5, 2,  6),
(6, 2,  1),
(7, 0,  9),
(8, 0,  9),
(9, 0,  10),
(10,  0,  10),
(11,  0,  11),
(12,  0,  11),
(13,  3,  12),
(14,  4,  12),
(15,  5,  13),
(16,  6,  13);

DROP TABLE IF EXISTS `temp`;
CREATE TABLE `temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` char(50) NOT NULL,
  `value` text NOT NULL,
  `datetime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `temp` (`id`, `key`, `value`, `datetime`) VALUES
(1, 'tags_cloud', '<li class=\"tags-widget-item\"><a href=\"/tags/1111111111.html\" class=\"tags-widget-link\">1111111111</a></li><li class=\"tags-widget-item\"><a href=\"/tags/222222222222.html\" class=\"tags-widget-link\">222222222222</a></li><li class=\"tags-widget-item\"><a href=\"/tags/test.html\" class=\"tags-widget-link\">проверка</a></li><li class=\"tags-widget-item\"><a href=\"/tags/test1.html\" class=\"tags-widget-link\">Проверка1</a></li><li class=\"tags-widget-item\"><a href=\"/tags/eto_eshe_teg.html\" class=\"tags-widget-link\">Это еще тег</a></li><li class=\"tags-widget-item\"><a href=\"/tags/eto_teg.html\" class=\"tags-widget-link\">Это тег</a></li>',  1409227575);

DROP TABLE IF EXISTS `users_events`;
CREATE TABLE `users_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` char(50) NOT NULL,
  `name` char(200) NOT NULL,
  `Credits` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `users_events` (`id`, `key`, `name`, `Credits`) VALUES
(1, 'publication',  'Публикация идеи',  10),
(2, 'realization',  'Реализация идеи',  1000),
(3, 'add_image',  'Добавление изображения в идею',  3),
(4, 'ad_file',  'Добавление файла в идею',  5),
(5, 'evaluation_ideas_other_users', 'Оценка идеи другими пользователями', 10),
(6, 'уvaluation_others_ideas',  'Оценка чужих идей',  1),
(7, 'comments', 'Комментарий',  2),
(8, 'idea_supported_sponsor', 'идею поддержал спонсор', 15),
(9, 'become_sponsor_ideas', 'стал спонсором идеи',  5);

DROP TABLE IF EXISTS `users_login`;
CREATE TABLE `users_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` char(32) NOT NULL COMMENT 'md5 от логина',
  `pass` char(32) NOT NULL COMMENT 'Хеш пароля',
  `salt` char(32) NOT NULL COMMENT 'Соль',
  `email` char(32) NOT NULL COMMENT 'md5 от электронного адреса',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `users_login` (`id`, `login`, `pass`, `salt`, `email`) VALUES
(1, 'd41d8cd98f00b204e9800998ecf8427e', '374c96e83b90fbaf0c3463a01e3cdc2f', 'd41d8cd98f00b204e9800998ecf8427e', 'bdccaf1191202b461254443c6b81c598'),
(159, 'd8e0011aa8128d72f451df47d5558307', '1a627edf3460102ab98bbcdbbc78d28d', 'd51d32e83ffaf34bb1d6a4d7afdc9ab9', 'f63ff929612149b756c1881bcb31d257'),
(160, '08391c959fc8bd0b672c596c4d6bcdcd', '9682ffaf8b0f2972c2972c967f8d6fac', 'accdb5ad67b1449cf0c5f2b2dd0571f9', '9b9af189785c4abe9129485580b31f78'),
(161, '0408f3c997f309c03b08bf3a4bc7b730', '35755226e3c0a511494d93f2b0527ba1', 'e594e3a3299a0f38b3915e39603aaa26', '91f31f485b0ca5b571077968285c3c49'),
(162, '21232f297a57a5a743894a0e4a801fc3', 'd366c5cedc3dd1043cb8552ab6d6065a', '06856a0b99286f1711c089b91ad9aa4d', '2e64a65177d9b1008b2b7895e1090c8d');

DROP TABLE IF EXISTS `user_data`;
CREATE TABLE `user_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nick_name` char(50) NOT NULL COMMENT 'Никнейм',
  `name` char(50) NOT NULL COMMENT 'Имя',
  `surname` char(50) NOT NULL COMMENT 'Фамилия',
  `patronymic` char(50) NOT NULL COMMENT 'Отчество',
  `avatar` char(37) NOT NULL,
  `email` char(50) NOT NULL,
  `register_date` int(11) NOT NULL COMMENT 'Дата регистрации пользователя',
  `last_visit_date` int(11) NOT NULL COMMENT 'Дата последнего посещения',
  `user_role` char(20) NOT NULL COMMENT 'Роль пользователя в системе',
  `points` int(11) NOT NULL COMMENT 'Начисленные баллы для пользователя',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user_data` (`id`, `user_id`, `nick_name`, `name`, `surname`, `patronymic`, `avatar`, `email`, `register_date`, `last_visit_date`, `user_role`, `points`) VALUES
(1, 1,  'Владимир', 'Владимир', 'Камайкин', 'Анатольевич',  'a02d0017e5e9fcd2707c9f4427d0b9c9.jpg', 'kamaikin@gmail.com', 1405598414, 1409053525, 'admin',  56),
(159, 159,  'user', 'user', 'userovich',  '', 'bb691b057b9ff88319877be24b9cf8fa.jpg', 'user@user.ru', 0,  1409207597, 'user', 93),
(160, 160,  'sponsor',  'sponsor',  'sponsor',  '', '', 'sponsor@sponsor.ru', 0,  1409220223, 'sponsor',  0),
(161, 161,  'moderator',  'moderator',  'moderator',  '', '981a13f0820b03ebc97522eb2fffcd31.jpg', 'moderator@moderator.ru', 0,  1409224010, 'moderator',  0),
(162, 162,  'admin',  'admin',  'admin',  '', '', 'admin@admin.ru', 0,  1409055146, 'admin',  0);

-- 2014-08-28 11:17:32