<?php
declare(strict_types=1);

namespace plugin\mp\base\controller\tools;

use plugin\mp\base\model\PluginBaseToolsCate;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 工具分类
 * @class Cate
 * @package plugin\mp\base\controller\tools
 */
class Cate extends Controller
{
    /**
     * 工具分类
     * @auth true
     * @menu true
     */
    public function index(): void
    {
        PluginBaseToolsCate::mQuery()->layTable(function () {
            $this->title = '工具分类';
        }, function (QueryHelper $query) {
            $query->like('name');
            $query->equal('status');
            $query->dateBetween('create_at');
        });
    }

    /**
     * 添加工具分类
     * @auth true
     */
    public function add(): void
    {
        $this->_applyFormToken();
        PluginBaseToolsCate::mForm('form');
    }

    /**
     * 编辑工具分类
     * @auth true
     */
    public function edit(): void
    {
        $this->_applyFormToken();
        PluginBaseToolsCate::mForm('form');
    }

    /**
     * 修改分类状态
     * @auth true
     */
    public function state(): void
    {
        PluginBaseToolsCate::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除工具分类
     * @auth true
     */
    public function remove(): void
    {
        PluginBaseToolsCate::mDelete();
    }
}
