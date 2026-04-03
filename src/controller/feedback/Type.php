<?php
declare(strict_types=1);

namespace plugin\base\controller\feedback;

use plugin\base\model\PluginBaseFeedbackType;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 反馈类型
 * @class Type
 * @package plugin\base\controller\feedback
 */
class Type extends Controller
{
    /**
     * 反馈类型
     * @auth true
     * @menu true
     */
    public function index(): void
    {
        PluginBaseFeedbackType::mQuery()->layTable(function () {
            $this->title = '反馈类型';
        }, function (QueryHelper $query) {
            $query->like('name,code');
            $query->equal('status');
            $query->dateBetween('create_at');
        });
    }

    /**
     * 添加反馈类型
     * @auth true
     */
    public function add(): void
    {
        $this->_applyFormToken();
        PluginBaseFeedbackType::mForm('form');
    }

    /**
     * 编辑反馈类型
     * @auth true
     */
    public function edit(): void
    {
        $this->_applyFormToken();
        PluginBaseFeedbackType::mForm('form');
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state(): void
    {
        PluginBaseFeedbackType::mSave($this->_vali([
            'status.in:0,1'   => '状态值范围异常！',
            'status.require'  => '状态值不能为空！',
        ]));
    }

    /**
     * 删除反馈类型
     * @auth true
     */
    public function remove(): void
    {
        PluginBaseFeedbackType::mDelete();
    }
}
