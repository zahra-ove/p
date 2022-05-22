<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <div class="mt-4">
        @if ($message = Session::get('status'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <form method="post" action="{{ route('pay') }}">
            @csrf
            takht_id:<input name="takht_id" type="text" /><br />
            user_id:<input name="user_id" type="text" /><br />
            description:<input name="description" type="text" /><br />
            amount:<input name="amount" type="text" /><br />
            raft:<input name="raft" type="text" /><br />
            bargasht:<input name="bargasht" type="text" /><br />

            <button type="submit" value="send" style="padding:20px"/>
        </form>
    </div>
</body>
</html>
