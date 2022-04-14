<?php

namespace Canbez\DcatTheme;

class Menu
{
    /**
     * 获取当前菜单下第一条子菜单的 uri
     *
     * @param $menu
     * @return string
     */
    public function getFirstChildrenUrl($menu): string
    {
        if (! empty($menu['children'])) {
            return 'javascript:void(0);';
        }

        return admin_url($menu['uri']);
    }
}
