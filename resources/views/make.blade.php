<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>问卷</title>
        <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
        <script>
            $(function () {
                if ("{{$pwd_error ?? 0}}" == 1){
                    alert('管理员密码错误');
                }
                if ("{{$make_success ?? 0}}" == 1){
                    alert('修改问卷成功');
                }

                //接受后端初始数据
                var xuanzes = [];
                var xuanze_as = [];
                var tiankongs = [];
                "<?php
                    foreach ($timus['tiankong_list']??[] as $ti_num=>$ti){
                    ?>";
                ti_num = "<?php echo $ti_num+1; ?>";
                ti = "<?php echo $ti; ?>";
                tiankongs[ti_num]= ti;
                "<?php } ?>";
                "<?php
                    foreach ($timus['xuanze_list']??[] as $ti_num=>$ti){
                    ?>";
                    xuanzes["<?php echo $ti_num+1; ?>"] = "<?php echo $ti['q']??null; ?>";
                    as_list = [];
                    "<?php
                        foreach ($ti['as']??[] as $as_num=>$as){
                        ?>";
                        as_list["<?php echo $as_num; ?>"] = "<?php echo $as; ?>";
                    "<?php } ?>";
                    xuanze_as["<?php echo $ti_num+1; ?>"] = as_list;
                "<?php } ?>";

                //选择题
                $timus = "";
                for (var i = 1; i <= 30; i++) {
                    $timus += "问题"+i+":<input type='text' style='width: 80%;' name='choose_q"+i+"'/><br>";
                    $timus += "A:<input type='text' style='width: 12%;' name='choose_"+i+"_A'/>";
                    $timus += "B:<input type='text' style='width: 12%;' name='choose_"+i+"_B'/>";
                    $timus += "C:<input type='text' style='width: 12%;' name='choose_"+i+"_C'/>";
                    $timus += "D:<input type='text' style='width: 12%;' name='choose_"+i+"_D'/>";
                    $timus += "E:<input type='text' style='width: 12%;' name='choose_"+i+"_E'/>";
                    $timus += "F:<input type='text' style='width: 12%;' name='choose_"+i+"_F'/>";
                    $timus += "<br/><br/>";
                }
                $('.choose-list').append($timus);

                //选择题赋值
                for (num in xuanzes){
                    $("[name='choose_q"+num+"']").val(xuanzes[num]);
                }
                for (num in xuanze_as){
                    for (a_num in xuanze_as[num]){
                        $("[name='choose_"+num+"_"+a_num+"']").val(xuanze_as[num][a_num]);
                    }
                }

                //填空题
                $timus = "";
                for (var i = 1; i <= 20; i++) {
                    $timus += "问题"+i+":<input type='text' style='width: 80%;' name='tiankong_q"+i+"'/><br>";
                    $timus += "<br/><br/>";
                }
                $('.tiankong-list').append($timus);

                //填空题赋值
                for (num in tiankongs){
                    $("[name='tiankong_q"+num+"']").val(tiankongs[num]);
                }


            });

        </script>
    </head>
    <body>
    <form action="{{url('/back/doMakeWenjuan')}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="choose-list">
            <h3>选择题</h3>
        </div>
        <div class="tiankong-list">
            <h3>填空</h3>
        </div>
        管理员密码：<input type="text" name="pwd"/><br>
        <input type="submit" value="提交"/>
    </form>
    </body>
</html>
