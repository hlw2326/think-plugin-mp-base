<?php

declare(strict_types=1);

use think\admin\extend\PhinxExtend;
use think\migration\Migrator;

@set_time_limit(0);
@ini_set('memory_limit', '-1');

class InstallBaseTools extends Migrator
{
    /**
     * 创建工具配置表
     */
    public function up(): void
    {
        $table = $this->table('plugin_base_tools', [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci',
            'comment' => '插件-工具配置',
        ]);

        PhinxExtend::upgrade($table, [
            ['cate_id', 'integer', ['limit' => 11, 'default' => 0, 'null' => true, 'comment' => '分类ID']],
            ['name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '工具名称']],
            ['logo', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '工具Logo']],
            ['desc', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '工具描述']],
            ['jump_type', 'string', ['limit' => 30, 'default' => 'navigateTo', 'null' => true, 'comment' => '跳转类型']],
            ['jump_value', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '跳转值']],
            ['click_count', 'integer', ['limit' => 11, 'default' => 0, 'null' => true, 'comment' => '点击次数']],
            ['sort', 'integer', ['limit' => 11, 'default' => 0, 'null' => true, 'comment' => '排序权重']],
            ['status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态(0禁用,1启用)']],
            ['create_at', 'datetime', ['default' => null, 'null' => true, 'comment' => '创建时间']],
            ['update_at', 'datetime', ['default' => null, 'null' => true, 'comment' => '更新时间']],
        ], [
            'jump_type',
            'status',
            'sort',
        ]);
    }

    /**
     * 回滚时删除表
     */
    public function down(): void
    {
        $this->table('plugin_base_tools')->drop();
    }
}
