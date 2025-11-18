🟦 Day12 応用②：進捗管理（Progress の setter 制御）


① 例題コード（あなたのレベルに合わせた最適版）
<?php

class Action {
  private $title;
  private $progress = 0; // 0〜100 の間だけ有効

  public function __construct($title) {
    $this->title = $title;
  }

  // 進捗を設定する（安全に制御）
  public function setProgress($value) {
    if ($value < 0 || $value > 100) {
      echo "進捗は 0〜100 の間で設定してください\n";
      return;
    }
    $this->progress = $value;
  }

  public function getProgress() {
    return $this->progress;
  }
}

$action = new Action("英語の勉強");
$action->setProgress(70);
echo $action->getProgress(); // 70



② 1文ずつの丁寧な解説

$progress は外から直接触らせないために private にする。

初期値は 0（未着手）。

setProgress() で入力された値が 0〜100 の範囲かをチェックする。

不正値ならエラー文を出して return。値を書き換えない。

正しい値なら $progress に保存する。

getProgress() で現在の進捗を読み取れる。

これで 「壊れない進捗の仕組み」 が完成します。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

③ あなたが書く練習問題

以下の仕様でクラスを書いてください。

📝 仕様

クラス名：Task

プロパティ：$name（文字列）、$progress（0〜100）

__construct($name) で name をセット。progress は 0 始まり。

setProgress($value) で 0〜100 以外は弾く。

getProgress() で現在値を返す。

期待する動作
$task = new Task("読書");
$task->setProgress(120); // エラー
$task->setProgress(30);  // OK
echo $task->getProgress(); // 30


まずはコードを書いてみてください。

<?php

class Task {
  private $name;
  private $progress = 0;

  public function __construct($name) {
    $this->name = $name;
  }

  public function setProgress($value) {
    if ($value < 0 || 100 > $value) {
      echo "0から100の間で入力してください\n";
      return;
    }
    $this->progress = $value;
  }

  public function getProgress() {
    return $this->progress;
  }
}

$task1 = new Task("サッカーをやる");
$task1->setProgress(40);
echo $task1->getProgress() . "\n";

?>


いい感じに書けています！
ですが 1つだけ重大なバグ があります。



❗ バグの原因

あなたが書いた if 文：

if ($value < 0 || 100 > $value)

これは実は…

$value < 0

100 > $value は「$value が 100 より小さいなら true」

つまり $value が 0〜100 の正しい値でも常に true になってしまいます。



例

setProgress(40) の場合：

$value < 0 → false

100 > $value → true
→ false || true = true → エラー扱い



✅ 正しい条件式（必ずこう書く）
if ($value < 0 || $value > 100)

値が 0 未満または 100 を超えたらエラー、という意味になります。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー


<?php

class Task {
  private $name;
  private $progress = 0;

  public function __construct($name) {
    $this->name = $name;
  }

  public function setProgress($value) {
    if ($value < 0 || $value > 100) {
      echo "0から100の間で入力してください\n";
      return;
    }
    $this->progress = $value;
  }

  public function getProgress() {
    return $this->progress;
  }
}

$task1 = new Task("サッカーをやる");
$task1->setProgress(40);
echo $task1->getProgress() . "\n";

?>

完璧です。

修正点もすべて反映され、次の点がしっかり守られています：

progress を private にして外部から守っている
setter で 0〜100 の範囲チェック ができている
不正な値は弾いて値を保持しない
正常なら中に保存 → getter で取り出せる
コンストラクタで name の初期化もOK

動作も問題ありません。

$task1->setProgress(40);
echo $task1->getProgress(); // 40

これで 「壊れないデータ管理」 の基礎が身につきました。


進捗管理（Progress 0〜100 の安全制御）を学習しました。