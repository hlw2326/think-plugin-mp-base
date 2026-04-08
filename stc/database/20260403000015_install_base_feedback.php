<?php

declare(strict_types=1);

use think\admin\extend\PhinxExtend;
use think\migration\Migrator;

@set_time_limit(0);
@ini_set('memory_limit', '-1');

class InstallBaseFeedback extends Migrator
{
    /**
     * 创建反馈建议表
     */
    public function up(): void
    {
        $table = $this->table('plugin_base_feedback', [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci',
            'comment' => '插件-反馈建议',
        ]);

        PhinxExtend::upgrade($table, [
            [
                'user_id',
                'string',
                [
                    'limit' => 32,
                    'default' => '',
                    'null' => true,
                    'comment' => '用户ID'
                ]
            ],
            [
                'type',
                'string',
                [
                    'limit' => 20,
                    'default' => 'feedback',
                    'null' => true,
                    'comment' => '反馈类型(关联plugin_base_feedback_type表)'
                ]
            ],
            [
                'content',
                'text',
                [
                    'default' => null,
                    'null' => true,
                    'comment' => '反馈内容'
                ]
            ],
            [
                'images',
                'text',
                [
                    'default' => null,
                    'null' => true,
                    'comment' => '图片(JSON数组)'
                ]
            ],
            [
                'contact',
                'string',
                [
                    'limit' => 50,
                    'default' => '',
                    'null' => true,
                    'comment' => '联系方式'
                ]
            ],
            [
                'reply',
                'text',
                [
                    'default' => null,
                    'null' => true,
                    'comment' => '回复内容'
                ]
            ],
            [
                'reply_admin',
                'integer',
                [
                    'limit' => 11,
                    'default' => 0,
                    'null' => true,
                    'comment' => '回复管理员ID'
                ]
            ],
            [
                'reply_at',
                'string',
                [
                    'limit' => 30,
                    'default' => '',
                    'null' => true,
                    'comment' => '回复时间'
                ]
            ],
            [
                'status',
                'integer',
                [
                    'limit' => 1,
                    'default' => 0,
                    'null' => true,
                    'comment' => '处理状态(0待处理,1处理中,2已完成)'
                ]
            ],
            [
                'create_at',
                'timestamp',
                ['default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => '创建时间']
            ],
            [
                'update_at',
                'timestamp',
                [
                    'default' => 'CURRENT_TIMESTAMP',
                    'null' => false,
                    'comment' => '更新时间'
                ]
            ],
        ], [
            'user_id',
            'type',
            'status',
            'create_at',
        ]);
    }

    /**
     * 回滚时删除表
     */
    public function down(): void
    {
        $this->table('plugin_base_feedback')->drop();
    }
}
