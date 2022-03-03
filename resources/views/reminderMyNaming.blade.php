<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNaming</title>
</head>
<body>
    <p>I</p>
    <form action="/reminder" method="GET">
        @csrf
        <input type="text" name="title" placeholder="タイトルを記入">
        <textarea name="" id="" cols="30" rows="10" placeholder="内容を記入"></textarea>
        <input type="button" value="送信する">
    </form>
</body>
</html>