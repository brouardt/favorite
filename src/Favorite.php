<?php

/**
 * -------------------------------------------------------------------------
 * favorites plugin for GLPI
 * -------------------------------------------------------------------------
 *
 * GPLv3 License
 *
 * Copyright (C) 2026  Thierry Brouard
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * -------------------------------------------------------------------------
 * @copyright Copyright (C) 2026 by the favorites plugin team.
 * @license   GPL-3.0 https://opensource.org/license/gpl-3.0
 * @link      https://github.com/brouardt/glpi-plugin-favorite
 * -------------------------------------------------------------------------
 */

namespace GlpiPlugin\Favorites;

use CommonDBTM;
use Html;
use Location;
use phpDocumentor\Reflection\Type;

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

class Favorite extends CommonDBTM
{
    public static $rightname = 'plugin_favorites';

    /**
     * @param $nb
     * @return string
     */
    public static function getTypeName($nb = 0)
    {
        return _n('Favorite', 'Favorites', $nb, PLUGIN_FAVORITES);
    }

    /**
     * @return string
     */
    public static function getMenuName()
    {
        return __s('Favorites', PLUGIN_FAVORITES);
    }

    /**
     * @return string
     */
    public static function getIcon()
    {
        return "ti ti-heart";
    }


    /**
     * @param $menus
     * @return array|array[]
     */
    public static function redefineMenus($menus)
    {
        if (self::canView()) {
            $collection = Preference::getFavoritesTypes();

            $favorites_menu = [PLUGIN_FAVORITES =>
                [
                    'title' => self::getMenuName(),
                    'types' => array_keys($collection),
                    'links' => [
                        'search' => '',
                        'lists' => ''
                    ],
                    'icon' => self::getIcon(),
                    'content' => [],
                    'page' => null,
                    'default' => null
                ]
            ];
            if (self::canCreate()) {
                $favorites_menu[PLUGIN_FAVORITES]['links']['add'] = self::getFormURL(false);
            }

            $content = [];
            if (!empty($collection)) {
                foreach ($collection as $key => $val) {
                    $content[strtolower($key)] = $val;
                }
            }

            $favorites_menu[PLUGIN_FAVORITES]['content'] = $content;

            // return favorites menu always in first
            $menus = $favorites_menu + $menus;
        }

        return $menus;
    }

    /**
     * @return array
     */
    public function getDropDown()
    {
        $list = [];

        $menus = $_SESSION['glpimenu'];


        return $list;
    }

    /**
     * @param $ID
     * @param array $options
     * @return void
     */
    public function showForm($ID, array $options = [])
    {
        $this->getFromDB($ID);

        echo "<div class='center'>";
        echo "<form name='form' method='post' action='" . $this->getFormURL() . "'>";

        echo Html::hidden('id', ['value' => 1]);

        echo "<table class='tab_cadre_fixe'>";

        echo "</table>";
        Html::closeForm();
        echo "</div>";
    }

    /**
     * @return array
     */
    function rawSearchOptions()
    {
        $tab = [];

        $tab[] = [
            'id' => 'common',
            'name' => self::getTypeName(2)
        ];

        $tab[] = [
            'id' => '1',
            'table' => $this->getTable(),
            'field' => 'type',
            'name' => __('type'),
            'datatype' => 'dropdown'
        ];

        return $tab;
    }
}
