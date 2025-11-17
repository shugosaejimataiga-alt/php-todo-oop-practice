①：期限（DueDate）の保持

目的：
ToDo（Action）に期限（日付）を安全に保持できるようにする。
PHPでは日付情報を文字列ではなく DateTime オブジェクトで扱うのが実務的です。



① 例題コード（あなたのレベルに合わせたコード）
<?php

class Action {
  private $title;
  private $dueDate; // 期限を保持（DateTime型）

  public function __construct($title, $dueDateString) {
    $this->title = $title;
    $this->setDueDate($dueDateString);
  }

  // 期限をセット（不正な日付は弾く）
  public function setDueDate($dateString) {
    $date = DateTime::createFromFormat('Y-m-d', $dateString);

    if (!$date) {
      echo "不正な日付です\n";
      return;
    }

    $this->dueDate = $date;
  }

  // 期限を取得
  public function getDueDate() {
    return $this->dueDate->format('Y-m-d');
  }
}

$task1 = new Action("筋トレ30分", "2025-12-01");

echo $task1->getDueDate(); // → 2025-12-01



② 1文ずつの丁寧な解説

1. private $dueDate;
Actionが持つ期限（DueDate）を外から勝手に書き換えられないようにする。

2. コンストラクタで setDueDate() を呼ぶ
渡された文字列が本当に正しい日付かをチェックするため。

3. DateTime::createFromFormat('Y-m-d', $dateString)
2025-12-01 のような形式だけを許可する実務的な書き方。

4. $date が false の場合 → 不正な日付
format が違う／存在しない日付（例：2025-02-30）は拒否。

5. $this->dueDate = $date;
内部に DateTime オブジェクトとして安全に保持。

6. getDueDate() は文字列として返す
UIや表示用に整形した形にしている。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
// 期限を取得
  public function getDueDate() {
    return $this->dueDate->format('Y-m-d');
  }
これは何をしているんですか？getterは確かprivateの取得する為に必要でしたっけ？



✅ 結論（まず一言で）
getDueDate() は、内部にある DateTime オブジェクトを、人が読みやすい「2025-12-01」の文字列に変換して返す処理です。

✅ 本題：このコードの意味
public function getDueDate() {
  return $this->dueDate->format('Y-m-d');
}



✔ $this->dueDate は DateTimeオブジェクト

例：

DateTime Object
(
    [date] => 2025-12-01 00:00:00.000000
    [timezone_type] => 3
    [timezone] => Asia/Tokyo
)

つまり、ただの文字列ではありません。



✔ ->format('Y-m-d') とは？

DateTime を「文字列」に変える命令です。

$this->dueDate->format('Y-m-d');

これは「2025-12-01」という 文字列に変換する 作業。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
③ あなたが書く練習問題

次の仕様を満たす Action クラス を自分で書いてください。

仕様：

title（private）

dueDate（private / DateTime型）

コンストラクタ
　title と dueDateString を受け取る

setDueDate($dateString)
　- 日付が不正なら「不正な日付です」と表示
　- 正しければ DateTime に変換して保持

getDueDate()
　- Y-m-d の文字列で返す

動作確認：
　Action("読書30分", "2025-11-30") を作って dueDate を echo

書けたら貼ってください。短くてOKです。

class Action {
  private $title;
  private $DateTime;

  public function __construct($title, $dueDateStritng) {
    $this->title = $title;
    $this->setDueDate($dueDateString);
  }

  public function setDueDate($dueDateString) {
    $Date = DateTime::createFormFormat("Y-m-d",$dueDateStritng);

    if(!$Date) {
      echo "不正な日付です。\n";
      return;
    } else {
      $this->DateTime = $Date;
    }
  }

  public function getDueDate() {
    return $this->DateTime->format("Y-m-d");
  }
}

$action1 = new Action("家族と旅行", 2030-4-30);
echo $action1->getDueDate() . "\n";


❌ あなたのコードのミス一覧（わかりやすく）

① プロパティ名：private $DateTime;

→ 変数名に大文字から始めない方が良い
（慣習としてプロパティは小文字スタート）



② コンストラクタの引数の綴りミス

$dueDateStritng → $dueDateString



③ createFormFormat → createFromFormat（スペルミス）


④ $dueDateStritng → $dueDateString（変数名が違う）


⑤ 日付は必ず「"2025-11-30"」のように 文字列で渡す

2030-4-30 と書くと
→ 勝手に計算されて 1996 になる（PHPの仕様）



⑥ DateTime のプロパティ名は $dateTime や $dueDate が自然

（今回なら $dueDate がベスト）



createFormFormat → createFromFormat のスペルミス

「form」ではなく from です。



日付は必ず “ゼロ埋めあり” の文字列で書く必要がある

「2030-4-30」はフォーマット Y-m-d に一致しません。

→ "2030-04-30" のようにゼロ埋めが必要
ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題修正版：

class Action {
  private $title;
  private $dateTime;

  public function __construct($title, $dueDateString) {
    $this->title = $title;
    $this->setDueDate($dueDateString);
  }

  public function setDueDate($dueDateString) {
    $Date = DateTime::createFromFormat("Y-m-d",$dueDateString);

    if(!$Date) {
      echo "不正な日付です。\n";
      return;
    } else {
      $this->dateTime = $Date;
    }
  }

  public function getDueDate() {
    return $this->dateTime->format("Y-m-d");
  }
}

$action1 = new Action("家族と旅行", "2030-04-30");
echo $action1->getDueDate() . "\n";


完璧です！！
ここまで直すと 100％正しく動く実務レベルのコード になっています。

✅ コードチェック（全項目 OK）
✔ createFromFormat のスペル

→ 完全に正しい


✔ 日付フォーマット "2030-04-30"

→ 正しい形式で渡せている


✔ DateTime オブジェクトを private で保持

→ ちゃんとカプセル化できている


✔ getter で format('Y-m-d')

→ 表示用の文字列に変換できている


✔ setDueDate() で不正日付チェック

→ 実務通り


🔍 実行結果
2030-04-30

問題なしです。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
このクラスはto doアプリで言ったらどのような行動というか動きをする役割なのですか？
一応分かるのですが、このクラスだけで、行動できる仕組みは作られたのでしょうか？


🔵 Action クラスは“パーツ”（モデル）

ToDoアプリは“家（システム）”

イメージとしては…

Action → 1つの部品
Dream → 部品をまとめた構造
Controller → 動かす係
UI → 見せる係
Repository / DB → 保存する係

Action は 最先端アプリでも絶対必要な単位です。