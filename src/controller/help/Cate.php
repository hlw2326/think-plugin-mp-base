<?php
declare(strict_types=1);

namespace plugin\mp\base\controller\help;

use plugin\mp\base\model\PluginBaseHelpCate;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 帮助分类
 * @class Cate
 * @package plugin\mp\base\controller\help
 */
class Cate extends Controller
{
    /**
     * 帮助分类
     * @auth true
     * @menu true
     */
    public function index(): void
    {
        PluginBaseHelpCate::mQuery()->layTable(function () {
            $this->title = '帮助分类';
        }, function (QueryHelper $query) {
            $query->like('name');
            $query->equal('status');
            $query->dateBetween('create_at');
        });
    }

    /**
     * 添加帮助分类
     * @auth true
     */
    public function add(): void
    {
        $this->_applyFormToken();
        PluginBaseHelpCate::mForm('form');
    }

    /**
     * 编辑帮助分类
     * @auth true
     */
    public function edit(): void
    {
        $this->_applyFormToken();
        PluginBaseHelpCate::mForm('form');
    }

    /**
     * 修改分类状态
     * @auth true
     */
    public function state(): void
    {
        PluginBaseHelpCate::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除帮助分类
     * @auth true
     */
    public function remove(): void
    {
        PluginBaseHelpCate::mDelete();
    }
}