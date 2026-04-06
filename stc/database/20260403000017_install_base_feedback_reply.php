<?php

declare(strict_types=1);

use think\admin\extend\PhinxExtend;
use think\migration\Migrator;

@set_time_limit(0);
@ini_set('memory_limit', '-1');

class InstallBaseFeedbackReply extends Migrator
{
    /**
     * 创建反馈回复记录表
     */
    public function up(): void
    {
        $table = $this->table('plugin_base_feedback_reply', [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci',
            'comment' => '插件-反馈回复记录',
        ]);

        PhinxExtend::upgrade($table, [
            ['feedback_id', 'integer', ['limit' => 11, 'default' => 0, 'null' => true, 'comment' => '反馈ID']],
            ['sender_type', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '发送者类型(0用户,1管理员)']],
            ['content', 'text', ['default' => null, 'null' => true, 'comment' => '回复内容']],
            ['admin_id', 'integer', ['limit' => 11, 'default' => 0, 'null' => true, 'comment' => '管理员ID']],
            ['create_at', 'datetime', ['default' => null, 'null' => true, 'comment' => '创建时间']],
        ], [
            'feedback_id',
            'sender_type',
        ]);
    }

    /**
     * 回滚时删除表
     */
    public function down(): void
    {
        $this->table('plugin_base_feedback_reply')->drop();
    }
}
