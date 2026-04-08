# 通用基础插件

ThinkAdmin 通用基础插件，适用于微信小程序（其他小程序未测试），提供业务系统共用的基础模块，无需重复开发。

## 模块说明

### 帮助管理

用于管理业务系统的帮助文档（FAQ、使用指南等），支持分类隔离。

- **帮助分类** — 树形分类，支持排序、状态控制
- **帮助文章** — 标题 + 富文本内容，支持按分类筛选

### 工具管理

提供小程序跳转工具的配置能力，支持多分类和多种跳转方式。

- **工具分类** — 支持排序、状态控制
- **工具列表** — 配置名称、Logo、描述及跳转方式

跳转方式支持：普通跳转（navigateTo）、重定向（redirectTo）、底部菜单（switchTab）、重启跳转（reLaunch）、网页（webview H5）、其他小程序（miniprogram）。

### 反馈建议

用户提交反馈的完整处理流程，支持多类型分类和聊天式回复。

- **反馈列表** — 按类型、处理状态筛选，显示回复数和最后回复时间
- **反馈类型** — 功能反馈、优化建议、问题反馈、投诉建议（可后台配置）

处理流程：用户提交 → 管理员回复（聊天记录，支持追问）→ 标记处理中 → 关闭完成。

## 安装

安装后系统自动执行数据库迁移，创建所有数据表和索引，同时注册后台菜单。

```bash
composer require hlw2326/think-plugin-mp-base
```

安装完成后访问 **系统管理 → 插件中心**，找到"通用基础"插件，点击安装。

## 数据库表

| 表名 | 说明 |
|------|------|
| `plugin_base_help_cate` | 帮助分类 |
| `plugin_base_help` | 帮助文章 |
| `plugin_base_tools_cate` | 工具分类 |
| `plugin_base_tools` | 工具配置 |
| `plugin_base_feedback_type` | 反馈类型（预置4种） |
| `plugin_base_feedback` | 反馈建议 |
| `plugin_base_feedback_reply` | 反馈回复记录 |

## API 接口

### 请求格式

所有接口的 appid 支持三种传参方式，**按优先级**：

1. **请求头** `appid: wxxxxxxx`（推荐，小程序端 header 传递，无需每个接口带参数）
2. **GET 参数** `?appid=wxxxxxxx`
3. **POST 参数** `appid=wxxxxxxx`

用户身份通过共享组件 `UserResolverService` 自动解析（详见下文集成说明）。

### 帮助中心

#### 获取帮助分类列表

```
GET /api/base/v1/help/cate
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| appid | header/get/post | 小程序 appid |

**响应**

```json
{
  "code": 1,
  "info": "获取成功",
  "data": {
    "list": [
      {"id": 1, "name": "使用指南", "sort": 0, "status": 1}
    ]
  }
}
```

#### 获取帮助文章列表

```
GET /api/base/v1/help/list
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| appid | header/get/post | 小程序 appid |
| cate_id | GET | 分类ID，筛选指定分类 |
| page | GET | 页码，默认 1 |
| limit | GET | 每页数量，默认 20，最大 50 |

**响应**

```json
{
  "code": 1,
  "info": "获取成功",
  "data": {
    "list": [
      {
        "id": 1,
        "cate_id": 1,
        "cate_name": "使用指南",
        "title": "如何注册账号",
        "content": "...",
        "sort": 0,
        "status": 1,
        "create_at": "2026-04-08 10:00:00"
      }
    ],
    "total": 10,
    "page": 1,
    "limit": 20
  }
}
```

#### 获取帮助文章详情

```
GET /api/base/v1/help/detail
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| appid | header/get/post | 小程序 appid |
| id | GET | 文章ID |

**响应**

```json
{
  "code": 1,
  "info": "获取成功",
  "data": {
    "id": 1,
    "cate_id": 1,
    "cate_name": "使用指南",
    "title": "如何注册账号",
    "content": "<p>富文本内容...</p>",
    "create_at": "2026-04-08 10:00:00"
  }
}
```

---

### 工具中心

#### 获取工具分类列表

```
GET /api/base/v1/tools/cate
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| appid | header/get/post | 小程序 appid |

**响应**

```json
{
  "code": 1,
  "info": "获取成功",
  "data": {
    "list": [
      {"id": 1, "name": "常用工具", "logo": "/upload/xxx.png", "sort": 0, "status": 1}
    ]
  }
}
```

#### 获取工具列表

```
GET /api/base/v1/tools/list
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| appid | header/get/post | 小程序 appid |
| cate_id | GET | 分类ID，筛选指定分类 |
| page | GET | 页码，默认 1 |
| limit | GET | 每页数量，默认 20，最大 50 |

**响应**

```json
{
  "code": 1,
  "info": "获取成功",
  "data": {
    "list": [
      {
        "id": 1,
        "cate_id": 1,
        "cate_name": "常用工具",
        "name": "二维码生成",
        "logo": "/upload/xxx.png",
        "desc": "生成精美二维码",
        "jump_type": "navigateTo",
        "jump_value": "/pages/qrcode/index",
        "click_count": 100,
        "sort": 0,
        "status": 1
      }
    ],
    "total": 10,
    "page": 1,
    "limit": 20
  }
}
```

#### 获取分类聚合列表

返回分类及其下的工具，适合首页展示。

```
GET /api/base/v1/tools/group
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| appid | header/get/post | 小程序 appid |

**响应**

```json
{
  "code": 1,
  "info": "获取成功",
  "data": {
    "list": [
      {
        "id": 1,
        "name": "常用工具",
        "tools": [
          {"id": 1, "name": "二维码生成", "logo": "...", "jump_type": "...", "click_count": 100}
        ],
        "count": 3
      }
    ]
  }
}
```

#### 工具点击计数

```
POST /api/base/v1/tools/click
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| appid | header/get/post | 小程序 appid |
| id | POST | 工具ID |

---

### 反馈建议

#### 获取反馈类型列表

```
GET /api/base/v1/feedback/types
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| appid | header/get/post | 小程序 appid |

**响应**

```json
{
  "code": 1,
  "info": "获取成功",
  "data": {
    "list": [
      {"id": 1, "code": "feedback", "name": "功能反馈", "sort": 0}
    ]
  }
}
```

#### 提交反馈

**需要登录。** appid 和 userId 由 `UserResolverService` 自动解析，不需要前端传参。

```
POST /api/base/v1/feedback/submit
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| content | POST | 反馈内容，必填，最多500字 |
| type | POST | 类型 code，默认 `feedback`，选填 |
| contact | POST | 联系方式，选填 |
| images | POST | 图片路径数组（JSON 格式），选填 |

**响应**

```json
{
  "code": 1,
  "info": "提交成功",
  "data": {"id": 1}
}
```

**错误返回**

```json
{"code": 0, "info": "请先登录"}
```

#### 获取当前用户的反馈列表

**需要登录。**

```
GET /api/base/v1/feedback/my
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| appid | header/get/post | 小程序 appid |
| page | GET | 页码，默认 1 |
| limit | GET | 每页数量，默认 20，最大 50 |

**响应**

```json
{
  "code": 1,
  "info": "获取成功",
  "data": {
    "list": [
      {
        "id": 1,
        "type": "feedback",
        "type_name": "功能反馈",
        "content": "...",
        "status": 0,
        "status_label": "待处理",
        "images": [],
        "create_at": "2026-04-08 10:00:00"
      }
    ],
    "total": 5,
    "page": 1,
    "limit": 20
  }
}
```

#### 获取反馈详情

**需要登录。** 只能查看自己的反馈。

```
GET /api/base/v1/feedback/detail
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| appid | header/get/post | 小程序 appid |
| id | GET | 反馈ID |

**响应**

```json
{
  "code": 1,
  "info": "获取成功",
  "data": {
    "id": 1,
    "type": "feedback",
    "type_name": "功能反馈",
    "content": "...",
    "status": 1,
    "status_label": "处理中",
    "images": [],
    "replies": [
      {"id": 1, "sender_type": 1, "content": "您好，我们已收到反馈", "create_at": "2026-04-08 11:00:00"}
    ]
  }
}
```

#### 追加反馈内容

**需要登录。** 只能追加自己的反馈。

```
POST /api/base/v1/feedback/append
```

**参数**

| 参数 | 来源 | 说明 |
|------|------|------|
| feedback_id | POST | 反馈ID，必填 |
| content | POST | 追加内容，必填，最多500字 |

#### 获取反馈统计

**需要登录。**

```
GET /api/base/v1/feedback/stats
```

**响应**

```json
{
  "code": 1,
  "info": "获取成功",
  "data": {
    "pending": 2,
    "completed": 3,
    "total": 5
  }
}
```

---

## 用户认证集成

插件本身不持有用户表，通过共享组件 `UserResolverService` 获取当前登录用户的 ID。
主应用（mini / data 模块）负责注册用户解析器，插件不依赖具体用户模块。

### 依赖说明

本插件依赖 `hlw2326/think-plugin-mp-shared` 共享包，由共享包提供 `UserResolverService` 和 `UserResolver` 接口。
所有依赖本插件的项目会自动引入共享包，无需单独安装。

### 工作原理

```
主应用注册解析器
  ↓
UserResolverService 持有回调
  ↓
Base 控制器构造时自动调用
  ↓
$this->userId 获得当前用户ID（未登录则为 null）
  ↓
所有子类直接使用 $this->userId
```

### 主应用注册方式

在主应用模块的 `Service.php` 中注册，推荐在 `boot()` 方法中：

```php
<?php
// app/mini/service/MiniService.php
declare(strict_types=1);

namespace app\mini\service;

use app\mini\model\MiniUser;
use think\admin\Service;
use hlw2326\mp\shared\service\UserResolverService;

class MiniService extends Service
{
    public function boot(): void
    {
        // 注册用户解析器：插件通过此回调获取当前登录用户
        UserResolverService::register(function (string $appid): ?string {
            return MiniUser::getCurrentUserId($appid);
        });
    }
}
```

或者通过实现接口的方式注册：

```php
// 实现 UserResolver 接口
<?php
namespace app\mini\service;

use app\mini\model\MiniUser;
use hlw2326\mp\shared\contract\UserResolver;

class MpUserResolver implements UserResolver
{
    public static function getUserId(string $appid): ?string
    {
        return MiniUser::getCurrentUserId($appid);
    }
}
```

```php
// 注册
use app\mini\service\MpUserResolver;
UserResolverService::register(MpUserResolver::class);
```

### MiniUser 模型需要实现的方法

主应用的 `MiniUser` 模型需要有一个静态方法 `getCurrentUserId(string $appid)`：

```php
<?php
// app/mini/model/MiniUser.php
class MiniUser extends Model
{
    /**
     * 根据 appid 获取当前登录用户 ID
     * @param string $appid 小程序 appid
     * @return string|null
     */
    public static function getCurrentUserId(string $appid): ?string
    {
        // 从 Session 或 Token 中解析用户身份
        $token = session('mini_token_' . $appid);
        if (empty($token)) {
            return null;
        }
        $user = static::mk()->where(['token' => $token, 'appid' => $appid])->findOrEmpty();
        return $user->isExists() ? strval($user->id) : null;
    }
}
```

### 注册优先级

支持按 appid 精确匹配：

```php
// 通用解析器（所有 appid 共用）
UserResolverService::register(fn($appid) => MiniUser::getCurrentUserId($appid), '*');

// 精确匹配（特定 appid 专用）
UserResolverService::register(fn($appid) => DataUser::getCurrentUserId($appid), 'wx1234567890');
```

精确匹配优先于通配符。

### 无需登录的接口

以下接口不需要用户登录，插件会自动跳过用户解析：

| 接口 | 说明 |
|------|------|
| `GET /api/base/v1/help/*` | 帮助中心（全部开放） |
| `GET /api/base/v1/tools/*` | 工具中心（全部开放） |
| `GET /api/base/v1/feedback/types` | 反馈类型（查看可用类型） |

---

## 路由前缀

ThinkAdmin 插件根据控制器命名空间自动发现路由，无需手动注册。

路由映射规则：

```
plugin\{code}\controller\{module}\{controller}@{action}
```

本插件 `{code}` 为 `mp_base`，控制器在 `controller/api/v1/` 下，所以：

```
plugin\mp\base\controller\api\v1\Help::cate     → /api/v1/help/cate
plugin\mp\base\controller\api\v1\Tools::list    → /api/v1/tools/list
plugin\mp\base\controller\api\v1\Feedback::submit → /api/v1/feedback/submit
```

完整接口地址为 `/api/base/v1/...`，其中 `base` 是 ThinkAdmin 插件中心的统一路由前缀（自动分配）。

## 版本要求

- PHP >= 8.2
- ThinkAdmin v6
- ThinkPHP >= 6.0
