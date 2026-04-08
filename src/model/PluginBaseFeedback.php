<?php
declare(strict_types=1);

namespace plugin\mp\base\model;

use think\admin\Model;

/**
 * 反馈建议模型
 * @property int $id
 * @property string $user_id 用户ID
 * @property string $type 反馈类型编码
 * @property string $content 反馈内容
 * @property string $images 图片(JSON数组)
 * @property string $contact 联系方式
 * @property string $reply 回复内容
 * @property int $reply_admin 回复管理员ID
 * @property string $reply_at 回复时间
 * @property int $status 处理状态(0待处理,1处理中,2已完成)
 * @property string $create_at 创建时间
 * @property string $update_at 更新时间
 * @class PluginBaseFeedback
 * @package plugin\mp\base\model
 */
class PluginBaseFeedback extends Model
{
    /** @var string */
    protected $table = 'plugin_base_feedback';

    /** @var bool */
    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

    /**
     * 获取回复记录
     */
    public function replies()
    {
        return $this->hasMany(PluginBaseFeedbackReply::class, 'feedback_id');
    }

    /**
     * 获取反馈类型（下拉用）
     */
    public static function getTypes(): array
    {
        return PluginBaseFeedbackType::getItems();
    }

    /**
     * 处理状态
     */
    public static function getStatuses(): array
    {
        return [
            0 => ['label' => lang('待处理'), 'class' => 'layui-bg-red'],
            1 => ['label' => lang('处理中'), 'class' => 'layui-bg-blue'],
            2 => ['label' => lang('已完成'), 'class' => 'layui-bg-green'],
        ];
    }
}
