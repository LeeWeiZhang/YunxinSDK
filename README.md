# YunxinSDK
PHP Package to integrate Yunxin API.

Example:

- Get users information
```
$yx = new Yunxin('APP_KEY', 'APP_SECRET');
$yxUsers = $yx->users();
$yxUsers->getUsersInfo(['yunxin_uid']);
```
