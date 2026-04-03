<?php
declare(strict_types=1);

namespace plugin\mp\base\controller\feedback;

use plugin\mp\base\model\PluginBaseFeedback;
use plugin\mp\base\model\PluginBaseFeedbackReply;
use plugin\mp\base\model\PluginBaseFeedbackType;
use think\admin\Controller;
use think\admin\helper\QueryHelper;

/**
 * 反馈建议
 * @class Index
 * @package plugin\mp\base\controller\feedback
 */
class Index extends Controller
{
    /**
     * 反馈列表
     * @auth true
     * @menu true
     */
    public function index(): void
    {
        PluginBaseFeedback::mQuery()->layTable(function () {
            $this->title    = '反馈列表';
            $this->types    = PluginBaseFeedbackType::getTypes();
            $this->statuses = PluginBaseFeedback::getStatuses();
        }, function (QueryHelper $query) {
            $query->like('user_id,content,contact');
            $query->equal('type,status');
            $query->dateBetween('create_at');
            $query->withCount(['replies' => function ($q) {
                $q->whereRaw('1=1');
            }]);
        });
    }

    /**
     * 列表数据处理
     */
    protected function _index_page_filter(array &$data): void
    {
        foreach ($data as &$vo) {
            $vo['reply_count'] = $vo['replies_count'] ?? 0;
            $lastReply = PluginBaseFeedbackReply::mk()
                ->where('feedback_id', $vo['id'])
                ->order('create_at desc')
                ->find();
            $vo['reply_at'] = $lastReply['create_at'] ?? '';
        }
    }

    /**
     * 回复反馈（聊天记录）
     * @auth true
     */
    public function reply(): void
    {
        $this->_applyFormToken();
        $id = $this->request->get('id/d', 0);
        $this->vo = PluginBaseFeedback::mk()->findOrEmpty($id);
        $this->types    = PluginBaseFeedbackType::getTypes();
        $this->statuses = PluginBaseFeedback::getStatuses();
        $this->replies  = PluginBaseFeedbackReply::mk()
            ->where(['feedback_id' => $id])
            ->order('create_at asc')
            ->select()
            ->toArray();

        $this->_form($id);
    }

    /**
     * 发送回复
     * @auth true
     */
    public function send(): void
    {
        $data = $this->_vali([
            'feedback_id.require' => '反馈ID不能为空！',
            'feedback_id.integer' => '反馈ID格式错误！',
            'content.require'      => '回复内容不能为空！',
            'content.max:500'     => '回复内容不能超过500字！',
        ]);

        $feedback = PluginBaseFeedback::mk()->findOrEmpty($data['feedback_id']);
        if ($feedback->isEmpty()) {
            $this->error('反馈不存在');
        }

        $adminId = \think\admin\service\AdminService::getUserId();

        PluginBaseFeedbackReply::mCreate([
            'feedback_id' => $data['feedback_id'],
            'sender_type' => 1,
            'content'     => $data['content'],
            'admin_id'    => $adminId,
        ]);

        PluginBaseFeedback::mk()->where('id', $data['feedback_id'])->update([
            'status' => 1,
        ]);

        $this->success('回复成功');
    }

    /**
     * 关闭反馈
     * @auth true
     */
    public function close(): void
    {
        $data = $this->_vali([
            'id.require' => '反馈ID不能为空！',
            'id.integer' => '反馈ID格式错误！',
        ]);

        PluginBaseFeedback::mk()->where('id', $data['id'])->update(['status' => 2]);
        $this->success('已关闭');
    }

    /**
     * 修改状态
     * @auth true
     */
    public function state(): void
    {
        PluginBaseFeedback::mSave($this->_vali([
            'status.in:0,1,2' => '状态值范围异常！',
            'status.require'  => '状态值不能为空！',
        ]));
    }

    /**
     * 删除反馈
     * @auth true
     */
    public function remove(): void
    {
        $ids = $this->request->post('id');
        if (!empty($ids)) {
            PluginBaseFeedbackReply::mk()->whereIn('feedback_id', is_array($ids) ? $ids : [$ids])->delete();
        }
        PluginBaseFeedback::mDelete();
    }
}
