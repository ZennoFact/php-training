<?php
// PHPの変数は$で始まるけど，$$を二つ重ねたらどうなるかとか考えたことありますか？
// やってみましょう
$name = 'zenno';
$zenno = 'I love programming.';

echo $$name; // これはどう出力される？予想しながら楽しんでください。
echo '<br>';

// これを使うとこんなこともできます。
$user = array(
    "id" => 'ZennoFact.',
    "userName" => $name,
    "role" => 'teacher',
);

foreach ($user as $key => $value) {
    $$key = $value;
}

// どう出力されるのか，エラーになるのか，予想しながら楽しんでください。
echo $id . "<br>";
echo $userName . "<br>";
echo $role . "<br>";

// PHPの変数のスコープの扱いあっての話ですが，こういう一見トリッキーなこともできるのがPHPの面白いところです。