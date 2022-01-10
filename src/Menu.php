<?php

namespace Canbez\DcatTheme;

class Menu
{
    /**
     * 获取当前菜单下第一条子菜单的 uri
     *
     * @param $menu
     * @return mixed
     */
    public function getFirstChildrenUrl($menu)
    {
        if (! empty($menu['children'])) {

            if (! empty($menu['children'][0]['children'])) {
                return $this->getFirstChildrenUrl($menu['children'][0]);
            }

            return $menu['children'][0]['uri'];
        }

        return $menu['uri'];
    }
}
