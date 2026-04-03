<?php
declare(strict_types=1);

namespace plugin\base\model;

use think\admin\Model;

/**
 * 反馈类型模型
 * @property int $id
 * @property string $name 类型名称
 * @property string $code 类型编码
 * @property string $class 样式Class
 * @property int $sort 排序权重
 * @property int $status 状态(0禁用,1启用)
 * @property string $create_at 创建时间
 * @property string $update_at 更新时间
 * @class PluginBaseFeedbackType
 * @package plugin\base\model
 */
class PluginBaseFeedbackType extends Model
{
    /** @var string */
    protected $table = 'plugin_base_feedback_type';

    /** @var bool */
    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

    /**
     * 获取启用的反馈类型（下拉/列表用）
     */
    public static function getItems(): array
    {
        $list = static::mk()
            ->where(['status' => 1])
            ->order('sort desc, id asc')
            ->column('name', 'code');
        return $list ?: [];
    }

    /**
     * 获取带样式的反馈类型（Badge用）
     */
    public static function getTypes(): array
    {
        $list = static::mk()
            ->where(['status' => 1])
            ->order('sort desc, id asc')
            ->select()
            ->toArray();
        $result = [];
        foreach ($list as $v) {
            $result[$v['code']] = [
                'label' => $v['name'],
                'class' => $v['class'] ?: 'layui-bg-gray',
            ];
        }
        return $result;
    }
}
