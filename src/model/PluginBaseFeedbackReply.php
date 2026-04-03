<?php
declare(strict_types=1);

namespace plugin\mp\base\model;

use think\admin\Model;

/**
 * 反馈回复记录模型
 * @property int $id
 * @property int $feedback_id 反馈ID
 * @property int $sender_type 发送者类型(0用户,1管理员)
 * @property string $content 回复内容
 * @property int $admin_id 管理员ID
 * @property string $create_at 创建时间
 * @class PluginBaseFeedbackReply
 * @package plugin\mp\base\model
 */
class PluginBaseFeedbackReply extends Model
{
    /** @var string */
    protected $table = 'plugin_base_feedback_reply';

    /** @var bool */
    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_at';
}
