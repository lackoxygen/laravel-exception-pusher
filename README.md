# laravel异常推送（钉钉｜微信）
# 安装

```
composer require lackoxygen/exception-push
```

# 配置文件
- config/tiktok.shop.php
```php
[
    'agents' => [
        Wx::class      => [
            'key' => '', 
            'enable' => false  //启用或停用
        ], Ding::class => [
            'token' => '', 
            'secret' => '', 
            'enable' => false  //启用或停用
        ]
    ],

    'client' => [
        'timeout' => 5.0, //超时时间
    ],

    'callbacks' => [
        'formatter' => null, //格式化内容
        'dispatcher' => null    //触发发送内容
    ]
];

```

# 配置发布

```php
php artisan vendor:publish --provider=Lackoxygen\\ExceptionPush\\ExceptionPushProvider
```


# 日志

```php
use function Lackoxygen\ExceptionPush\notify as notify

notify('hello world', 'debug');
```
