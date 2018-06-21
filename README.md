Pickles2/px2-counter
=========

px2-counter はPickles 2 で制作しているページのコンテンツエリアの文字数をカウントします。
img タグの alt に設定された値も含めたページ内の文字数に対して任意に設定した最小値・最大値に応じてアラートを出します。


## Usage - 使い方

### 1. Pickles2 をセットアップ

### 2. composer.json に追記

```
"autoload": {
    "files": [
        "px-files/ykyuuuuka/px2-counter/px2-counter.php"
    ]
}
```

### 3. config.php に追記

プロセッサー処理の配列に以下を追記してください。
minLength と maxLength を定義しなかった場合は、全てのページでページ内の文字数がアラートされます。
```
'ykyuuuuka\px2_counter\ext::px2_counter('.json_encode([
	'minLength'=>'100',
	'maxLength'=>'1000',
]).')',
```

### 4. composer を更新

```
$ composer update
```

## ライセンス - License

Copyright (c)2001-2018 Tomoya Koyanagi, and Pickles 2 Project<br />
MIT License https://opensource.org/licenses/mit-license.php


## 作者 - Author
- Yuya Kaisen <yuya.kaisen@gmail.com>
- website: <https://github.com/ykyuuuuka>
