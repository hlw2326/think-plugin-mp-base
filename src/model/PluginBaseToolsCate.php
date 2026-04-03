<?php
declare(strict_types=1);

namespace plugin\mp\base\model;

use think\admin\Model;

/**
 * 工具分类模型
 * @property int $id
 * @property string $name 分类名称
 * @property int $sort 排序权重
 * @property int $status 状态(0禁用,1启用)
 * @property string $create_at 创建时间
 * @property string $update_at 更新时间
 * @class PluginBaseToolsCate
 * @package plugin\mp\base\model
 */
class PluginBaseToolsCate extends Model
{
    /** @var string */
    protected $table = 'plugin_base_tools_cate';
}
