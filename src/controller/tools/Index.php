<?php
declare(strict_types=1);

namespace plugin\base\controller\tools;

use plugin\base\model\PluginBaseTools;
use plugin\base\model\PluginBaseToolsCate;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 工具管理
 * @class Index
 * @package plugin\base\controller\tools
 */
class Index extends Controller
{
    /**
     * 工具列表
     * @auth true
     * @menu true
     */
    public function index(): void
    {
        PluginBaseTools::mQuery()->layTable(function () {
            $this->title      = '工具管理';
            $this->jump_types = PluginBaseTools::getJumpTypes();
            $this->cates      = PluginBaseToolsCate::mk()->where(['status' => 1])->order('sort desc,id asc')->column('name', 'id');
        }, function (QueryHelper $query) {
            $query->like('name');
            $query->equal('cate_id,jump_type,status');
            $query->dateBetween('create_at');
        });
    }

    /**
     * 列表数据处理
     */
    protected function _index_page_filter(array &$data): void
    {
        $cates = PluginBaseToolsCate::mk()->column('name', 'id');
        foreach ($data as &$vo) {
            $vo['cate_name'] = $cates[$vo['cate_id']] ?? '-';
        }
    }

    /**
     * 添加工具
     * @auth true
     */
    public function add(): void
    {
        $this->_applyFormToken();
        $this->title = '添加工具';
        PluginBaseTools::mForm('form');
    }

    /**
     * 编辑工具
     * @auth true
     */
    public function edit(): void
    {
        $this->_applyFormToken();
        $this->title = '编辑工具';
        PluginBaseTools::mForm('form');
    }

    /**
     * 表单数据处理
     */
    protected function _form_filter(array &$data): void
    {
        $this->jump_types = PluginBaseTools::getJumpTypes();
        $this->cates      = PluginBaseToolsCate::mk()->where(['status' => 1])->order('sort desc,id asc')->column('name', 'id');
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state(): void
    {
        PluginBaseTools::mSave($this->_vali([
            'status.in:0,1'   => '状态值范围异常！',
            'status.require'  => '状态值不能为空！',
        ]));
    }

    /**
     * 删除工具
     * @auth true
     */
    public function remove(): void
    {
        PluginBaseTools::mDelete();
    }
}
