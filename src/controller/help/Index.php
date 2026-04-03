<?php
declare(strict_types=1);

namespace plugin\mp\base\controller\help;

use plugin\mp\base\model\PluginBaseHelp;
use plugin\mp\base\model\PluginBaseHelpCate;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 帮助管理
 * @class Index
 * @package plugin\mp\base\controller\help
 */
class Index extends Controller
{
    /**
     * 帮助列表
     * @auth true
     * @menu true
     */
    public function index(): void
    {
        PluginBaseHelp::mQuery()->layTable(function () {
            $this->title = '帮助列表';
            $this->cates = PluginBaseHelpCate::mk()->where(['status' => 1])->order('sort desc,id asc')->column('name', 'id');
        }, function (QueryHelper $query) {
            $query->like('title');
            $query->equal('cate_id,status');
            $query->dateBetween('create_at');
        });
    }

    /**
     * 列表数据处理
     */
    protected function _index_page_filter(array &$data): void
    {
        $cates = PluginBaseHelpCate::mk()->column('name', 'id');
        foreach ($data as &$vo) {
            $vo['cate_name'] = $cates[$vo['cate_id']] ?? '-';
        }
    }

    /**
     * 添加帮助
     * @auth true
     */
    public function add(): void
    {
        $this->_applyFormToken();
        $this->title = '添加帮助';
        PluginBaseHelp::mForm('form');
    }

    /**
     * 编辑帮助
     * @auth true
     */
    public function edit(): void
    {
        $this->_applyFormToken();
        $this->title = '编辑帮助';
        PluginBaseHelp::mForm('form');
    }

    /**
     * 表单数据处理
     */
    protected function _form_filter(array &$data): void
    {
        $this->cates = PluginBaseHelpCate::mk()->where(['status' => 1])->order('sort desc,id asc')->column('name', 'id');
    }

    /**
     * 表单结果处理
     */
    protected function _form_result(bool $state): void
    {
        if ($state && empty(input('id'))) {
            $this->success('添加成功！', 'javascript:history.back();');
        }
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state(): void
    {
        PluginBaseHelp::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除帮助
     * @auth true
     */
    public function remove(): void
    {
        PluginBaseHelp::mDelete();
    }
}