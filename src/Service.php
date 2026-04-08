<?php

declare(strict_types=1);

namespace plugin\mp\base;

use think\admin\Plugin;

/**
 * 通用基础插件服务注册
 * @class Service
 * @package plugin\mp\base
 */
class Service extends Plugin
{
    /**
     * 定义插件名称
     * @var string
     */
    protected $appName = '通用基础';

    /**
     * 定义安装包名
     * @var string
     */
    protected $package = 'hlw2326/think-plugin-mp-base';

    /**
     * 注册路由
     */
    public function boot(): void
    {
        // ThinkAdmin 插件根据控制器命名空间自动发现路由，无需手动注册
        // 路由映射规则：plugin\{code}\controller\{module}\{controller}@{action}
        // 本插件：plugin\mp\base\controller\api\v1\Feedback::submit → /api/v1/feedback/submit
    }

    /**
     * 注册模块菜单（菜单由 stc 迁移脚本写入 system_menu，此处用于插件中心显示）
     */
    public static function menu(): array
    {
        $code = app(static::class)->appCode;
        return [
            [
                'name' => '帮助管理',
                'subs' => [
                    [
                        'name' => '帮助分类',
                        'icon' => 'layui-icon layui-icon-theme',
                        'node' => "{$code}/help.cate/index",
                    ],
                    [
                        'name' => '帮助文章',
                        'icon' => 'layui-icon layui-icon-rss',
                        'node' => "{$code}/help.index/index",
                    ]
                ],
            ],
            [
                'name' => '工具管理',
                'subs' => [
                    [
                        'name' => '工具分类',
                        'icon' => 'layui-icon layui-icon-theme',
                        'node' => "{$code}/tools.cate/index",
                    ],
                    [
                        'name' => '工具列表',
                        'icon' => 'layui-icon layui-icon-util',
                        'node' => "{$code}/tools.index/index",
                    ],
                ],
            ],
            [
                'name' => '反馈建议',
                'subs' => [
                    [
                        'name' => '反馈列表',
                        'icon' => 'layui-icon layui-icon-rss',
                        'node' => "{$code}/feedback.index/index",
                    ],
                    [
                        'name' => '反馈类型',
                        'icon' => 'iconfont iconfont-tag',
                        'node' => "{$code}/feedback.type/index",
                    ],
                ],
            ],
        ];
    }
}
