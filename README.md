# phpHotUpdate

<b>for fun:)<br></b>
update Global Variable/Constant value in .php file directly

```php
$h = new HotUpdater(__DIR__ . "/test/TestConfig.php");
$h->replaceConstant("ACONST",["a" => "c", "1" => 2]);
$h->replaceGlobalVariable("aVer",["c" => "d", "1" => 2]);
$h->save();
```
Thus, value in the .php file will be rewrite.
<br>
<i>this can be used in web for initialization</i>