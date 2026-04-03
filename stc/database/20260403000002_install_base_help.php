<?php

declare(strict_types=1);

use think\admin\extend\PhinxExtend;
use think\migration\Migrator;

@set_time_limit(0);
@ini_set('memory_limit', '-1');

class InstallBaseHelp extends Migrator
{
    /**
     * 创建帮助文章表
     */
    public function up(): void
    {
        $table = $this->table('plugin_base_help', [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci',
            'comment' => '插件-帮助文章',
        ]);

        PhinxExtend::upgrade($table, [
            ['cate_id', 'integer', ['limit' => 11, 'default' => 0, 'null' => true, 'comment' => '分类ID']],
            ['title', 'string', ['limit' => 200, 'default' => '', 'null' => true, 'comment' => '文章标题']],
            ['content', 'text', ['default' => null, 'null' => true, 'comment' => '文章内容']],
            ['views', 'integer', ['limit' => 11, 'default' => 0, 'null' => true, 'comment' => '访问次数']],
            ['sort', 'integer', ['limit' => 11, 'default' => 0, 'null' => true, 'comment' => '排序权重']],
            ['status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态(0禁用,1启用)']],
            ['create_at', 'datetime', ['default' => null, 'null' => true, 'comment' => '创建时间']],
            ['update_at', 'datetime', ['default' => null, 'null' => true, 'comment' => '更新时间']],
        ], [
            'cate_id',
            'status',
            'sort',
            'create_at',
        ]);
    }

    /**
     * 回滚时删除表
     */
    public function down(): void
    {
        $this->table('plugin_base_help')->drop();
    }
}
