<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language file.
 *
 * @package   theme_aurora
 * @copyright 2016 Frédéric Massart
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// A description shown in the admin theme selector.
$string['choosereadme'] = 'Тема aurora является дочерней темой Boost. Она добавляет возможность загрузки фоновых фотографий.';
// The name of our plugin.
$string['pluginname'] = 'aurora';
// We need to include a lang string for each block region.
$string['region-side-pre'] = 'Справа';

$string['advancedsettings'] = 'Расширенные настройки';
$string['backgroundimage'] = 'Фоновое изображение';
$string['backgroundimage_desc'] = 'Изображение для отображения в качестве фона сайта. Загруженное здесь фоновое изображение будет переопределять фоновое изображение в файлах предустановок темы.';
$string['brandcolor'] = 'Основной цвет';
$string['brandcolor_desc'] = 'Цвет акцента.';
$string['configtitle'] = 'Новые настройки Aurora';
$string['generalsettings'] = 'Общие настройки';
$string['loginbackgroundimage'] = 'Фоновое изображение страницы входа';
$string['loginbackgroundimage_desc'] = 'Изображение для отображения в качестве фона страницы входа.';
$string['preset'] = 'Предустановка темы';
$string['preset_desc'] = 'Выберите предустановку для кардинального изменения внешнего вида темы.';
$string['presetfiles'] = 'Дополнительные файлы предустановок темы';
$string['presetfiles_desc'] = 'Файлы предустановок могут быть использованы для кардинального изменения внешнего вида темы. См. <a href=https://docs.moodle.org/dev/Boost_Presets>предустановки Boost</a> для получения информации о создании и распространении собственных файлов предустановок, а также <a href=http://moodle.net/boost>репозиторий предустановок</a> для получения предустановок, которыми поделились другие пользователи.';
$string['rawscss'] = 'Необработанный SCSS';
$string['rawscss_desc'] = 'Используйте это поле для предоставления кода SCSS или CSS, который будет внедряться в конец таблицы стилей.';
$string['rawscsspre'] = 'Необработанный начальный SCSS';
$string['rawscsspre_desc'] = 'В этом поле вы можете предоставить начальный код SCSS, он будет внедряться перед всем остальным. В большинстве случаев вы будете использовать эту настройку для определения переменных.';
$string['unaddableblocks'] = 'Ненужные блоки';
$string['unaddableblocks_desc'] = 'Указанные блоки не требуются при использовании этой темы и не будут отображаться в меню \'Добавить блок\'.';
$string['privacy:metadata'] = 'Тема Aurora New не хранит никаких персональных данных о пользователях.';
$string['privacy:metadata:preference:draweropenblock'] = 'Пользовательские настройки скрытия или отображения боковой панели с блоками.';
$string['privacy:metadata:preference:draweropenindex'] = 'Пользовательские настройки скрытия или отображения боковой панели с индексом курса.';
$string['privacy:drawerindexclosed'] = 'Текущая настройка для боковой панели индекса закрыта.';
$string['privacy:drawerindexopen'] = 'Текущая настройка для боковой панели индекса открыта.';
$string['privacy:drawerblockclosed'] = 'Текущая настройка для боковой панели блока закрыта.';
$string['privacy:drawerblockopen'] = 'Текущая настройка для боковой панели блока открыта.';

// Navbar settings.
$string['navbarsettings'] = 'Настройки панели навигации';
$string['auroranavprimary'] = 'Основной цвет панели навигации';
$string['auroranavprimarydesc'] = 'Установить основной цвет для панели навигации.';
$string['auroranavsecondary'] = 'Вторичный цвет панели навигации';
$string['auroranavsecondarydesc'] = 'Установить вторичный цвет для панели навигации.';
$string['auroranavtext'] = 'Цвет текста панели навигации';
$string['auroranavtextdesc'] = 'Установить цвет текста для панели навигации.';
$string['auroranavtexthover'] = 'Цвет текста при наведении на панели навигации';
$string['auroranavtexthoverdesc'] = 'Установить цвет текста при наведении для панели навигации.';
$string['auroranavborderradius'] = 'Радиус границы панели навигации';
$string['auroranavborderradiusdesc'] = 'Установить радиус границы для элементов панели навигации.';

$string['auroranavbortextweight'] = 'Толщина шрифта текста панели навигации';
$string['auroranavbortextweightdesc'] = 'Установить толщину шрифта для текста панели навигации.';
$string['auroranavlinksposition'] = 'Позиция ссылок навигации';
$string['auroranavlinkspositiondesc'] = 'Выберите, где располагать основную группу ссылок: слева, по центру или справа.';
$string['auroranavlinkspositionleft'] = 'Слева';
$string['auroranavlinkspositioncenter'] = 'По центру';
$string['auroranavlinkspositionright'] = 'Справа';
$string['nocourses'] = 'Курсов нет';

// Front page slider settings.
$string['frontpagesettings'] = 'Слайдер главной страницы';
$string['frontpagesliderenabled'] = 'Включить слайдер на главной';
$string['frontpagesliderenabled_desc'] = 'Показывать кастомный блок под навбаром на главной странице.';
$string['frontpagesliderenabledlabel'] = 'Включен';
$string['frontpageslidermanage'] = 'Управление слайдером главной';
$string['frontpageslidermanagelink'] = 'Открыть менеджер слайдера';
$string['frontpageslidermanagedesc'] = 'Управляйте элементами слайдера здесь: {$a}';
$string['frontpagesliderlist'] = 'Элементы слайдера';
$string['frontpagesliderpreview'] = 'Предпросмотр';
$string['frontpagesliderupdated'] = 'Слайд сохранен.';
$string['frontpagesliderdeleted'] = 'Слайд удален.';
$string['frontpageslideritems'] = 'Элементы слайдера';
$string['frontpageslideritems_desc'] = 'Добавляйте, редактируйте и удаляйте неограниченное число слайдов. Если список пустой, используются поля одиночного слайда ниже.';
$string['frontpagesliderempty'] = 'Слайдов пока нет. Добавьте первый.';
$string['frontpageslidernotitle'] = 'Слайд без названия';
$string['frontpagesliderdeleteconfirm'] = 'Удалить этот слайд?';
$string['frontpageslideradd'] = 'Добавить в список';
$string['frontpagesliderupdate'] = 'Обновить слайд';
$string['frontpageslidercancel'] = 'Отменить';
$string['frontpageslideredit'] = 'Редактировать';
$string['frontpagesliderdelete'] = 'Удалить';
$string['frontpageslideritemtitle'] = 'Заголовок';
$string['frontpageslideritemdescription'] = 'Описание';
$string['frontpageslideritemimage'] = 'URL изображения';
$string['frontpageslideritemimagealt'] = 'Alt-текст изображения';
$string['frontpageslideritembuttontext'] = 'Текст кнопки';
$string['frontpageslideritembuttonurl'] = 'URL кнопки';
$string['frontpageslideremptyitem'] = 'Заполните хотя бы одно поле, чтобы добавить слайд.';
$string['frontpagesliderinvalidjson'] = 'Некорректные данные списка слайдов. Они будут заменены при добавлении нового слайда.';
$string['frontpagesliderregion'] = 'Слайдер на главной';
$string['frontpagesliderindicator'] = 'Слайд {$a}';
$string['frontpagesliderimage'] = 'Изображение слайдера';
$string['frontpagesliderimage_desc'] = 'Загрузите изображение для слайдера на главной странице.';
$string['frontpageslidertitle'] = 'Заголовок слайдера';
$string['frontpageslidertitle_desc'] = 'Основной заголовок блока слайдера.';
$string['frontpagesliderdescription'] = 'Описание слайдера';
$string['frontpagesliderdescription_desc'] = 'Короткое описание для слайдера на главной странице.';
$string['frontpagesliderbuttontext'] = 'Текст кнопки';
$string['frontpagesliderbuttontext_desc'] = 'Подпись кнопки (например: Нанять нас).';
$string['frontpagesliderbuttonurl'] = 'Ссылка кнопки';
$string['frontpagesliderbuttonurl_desc'] = 'URL для кнопки слайдера.';
$string['frontpagesliderbuttondefault'] = 'Нанять нас';
$string['showfooter'] = 'Показать футер';
