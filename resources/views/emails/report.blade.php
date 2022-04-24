<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通報がありました。</title>
</head>
<body>
<p>{{$report_contents[3]}}から{{$report_contents[1]}}のコメントに通報がありました。</p>
<br>
<p>コメント内容：{{$report_contents[2]}}</p>
<p>投稿データid:{{$report_contents[0]}}</p>
</body>
</html>