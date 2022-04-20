<?php

namespace Canbez\DcatTheme;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Support\Helper;

class DcatThemeServiceProvider extends ServiceProvider
{
    protected $type = self::TYPE_THEME;

    protected $css = [
        'css/index.min.css?ev=1.0.2',
    ];
    protected $js = [
        'js/index.js?ev=1.0.2',
    ];

    public function register()
    {
    }

    public function init()
    {
        parent::init();
        $this->setLeftSidebar();
        Admin::requireAssets('@canbez.dcat-theme');
    }

    public function setLeftSidebar()
    {
        admin_inject_section(Admin::SECTION['LEFT_SIDEBAR_MENU'], function () {
            $helperMenus = [
                [
                    'id' => -1,
                    'title' => 'Helpers',
                    'icon' => 'fa fa-keyboard-o',
                    'uri' => '',
                    'parent_id' => 0,
                ],
                [
                    'id' => 7,
                    'title' => 'Extensions',
                    'icon' => '',
                    'uri' => 'auth/extensions',
                    'parent_id' => -1,
                ],
                [
                    'id' => -3,
                    'title' => 'Scaffold',
                    'icon' => '',
                    'uri' => 'helpers/scaffold',
                    'parent_id' => -1,
                ],
                [
                    'id' => -4,
                    'title' => 'Icons',
                    'icon' => '',
                    'uri' => 'helpers/icons',
                    'parent_id' => -1,
                ],
            ];
            $builder = Admin::menu();
            $menuModel = config('admin.database.menu_model');
            $allNodes = (new $menuModel())->allNodes()->filter(function ($item) {
                return $item['id'] != 7;
            })->toArray();
            if (config('app.debug') && config('admin.helpers.enable', true)) {
                $allNodes = array_merge($allNodes, $helperMenus);
            }
            $menus = Helper::buildNestedArray($allNodes);
            $tool = new Menu();
            return view('canbez.dcat-theme::menu', ['builder' => $builder, 'menus' => $menus, 'tool' => $tool]);
        }, false);
    }
}
