<?php

namespace GlpiPlugin\Favorite;

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

class Favorit extends \CommonDBTM
{
    public static $rightname = 'plugin_favorite';

    static function getTypeName($nb = 0)
    {
        return _n('Favorit', 'Favorites', $nb, 'favorites');
    }

    /**
     * @return string
     */
    static function getIcon()
    {
        return "ti ti-heart";
    }
}
