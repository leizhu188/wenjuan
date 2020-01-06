<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
        <script>
            $(function () {
                $('form').submit(function () {
                    if (!$('input[name="name"]').val()){
                        alert('请输入姓名');
                        return false;
                    }
                    if (!$('input[name="phone"]').val()){
                        alert('请输入手机号');
                        return false;
                    }
                    return true;
                });
            });
        </script>
        <title>问卷</title>
    </head>
    <body>
        @if($timu)
            <form action="{{url('/back/saveAnswer')}}"  method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                @foreach($timu['xuanze_list']??[] as $ti_num=>$ti)
                    {{$ti['q']}}<br>
                    @foreach($ti['as']??[] as $a_num=>$a)
                        <input type="radio" name="xuanze_{{$ti_num}}" value="{{$a_num}}" @if($a_num == 'A') checked="checked" @endif>{{$a}}<br>
                    @endforeach
                    <br><br>
                @endforeach

                @foreach($timu['tiankong_list']??[] as $ti_num=>$ti)
                    {{$ti}}<br>
                    <textarea name="tiankong_{{$ti_num}}"></textarea>
                    <br><br>
                @endforeach
                <br><br>
                姓名：<input type="text" name="name"><br>
                手机号：<input type="phone" name="phone"><br>
                <input type="submit" value="提交">
            </form>
        @else
            <h2>暂无问卷</h2>
        @endif

    </body>
</html>
