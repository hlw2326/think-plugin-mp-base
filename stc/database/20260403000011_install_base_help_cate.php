<?php

declare(strict_types=1);

use think\admin\extend\PhinxExtend;
use think\migration\Migrator;

@set_time_limit(0);
@ini_set('memory_limit', '-1');

class InstallBaseHelpCate extends Migrator
{
    /**
     * 创建帮助分类表
     */
    public function up(): void
    {
        $table = $this->table('plugin_base_help_cate', [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci',
            'comment' => '插件-帮助分类',
        ]);

        PhinxExtend::upgrade($table, [
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 06e1aad13524cc985f5de5e7709a38d999d228b3
            [
                'name',
                'string',
                ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '分类名称']
            ],
            [
                'sort',
                'integer',
                ['limit' => 11, 'default' => 0, 'null' => true, 'comment' => '排序权重']
            ],
            [
                'status',
                'integer',
                ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态(0禁用,1启用)']
            ],
            [
                'create_at',
                'timestamp',
                ['default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => '创建时间']
            ],
            [
                'update_at',
                'timestamp',
                ['default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => '更新时间']
            ],
<<<<<<< HEAD
=======
=======
            ['name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '分类名称']],
            ['sort', 'integer', ['limit' => 11, 'default' => 0, 'null' => true, 'comment' => '排序权重']],
            ['status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态(0禁用,1启用)']],
            ['create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => '创建时间']],
            ['update_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false, 'comment' => '更新时间']],
>>>>>>> 0c61f9001ca69a4d4393b498481b4cd06340e178
>>>>>>> 06e1aad13524cc985f5de5e7709a38d999d228b3
        ], [
            'name',
            'status',
            'sort',
        ]);
    }

    /**
     * 回滚时删除表
     */
    public function down(): void
    {
        $this->table('plugin_base_help_cate')->drop();
    }
}
