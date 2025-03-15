<fieldset style="width: 85%;magin:auto;">
    <legend>最新文章管理</legend>
<table class="ct" style="width: 100%;">
    <tr>
        <td>編號</td>
        <td width="50%">標題</td>
        <td>顯示</td>
        <td>刪除</td>
    </tr>
    <?php
    $total=$News->count();
    $div=3;
    $pages=ceil($total/$div);
    $now=$_GET['p']??1;
    $start=($now-1)*$div;

    $rows=$News->all(" Limit $start,$div");
    foreach($rows as $idx=>$row):
    ?>
    <tr>
        <td><?=$start+$idx+1;?></td>
        <td><?=$row['title'];?></td>
        <td>
        <input type="checkbox" name="sh[]" value="<?=$row['id'];?>" <?=($row['sh']==1)?"checked":"";?>>
    </td>
        <td>
        <input type="checkbox" name="sh[]" value="<?=$row['id'];?>">
        </td>
    </tr>

        <input type="hidden" name="id[]" value="<?=$row['id'];?>">
<?php endforeach;?>
</table>

<div class="ct">
    <?php

        if(($now-1)>0){
            echo "<a href='?do=news&p".($now-1)."'> &lt;</a>";
        }

        for($i=1;$i<=$pages;$i++){
            $size=($i==$now)?"24px":"16px";
            echo "<a href='?do=news&p=$i' style='font-size:$size'> $i </a>";
        }

        if(($now+1)<=$pages){
            echo "<a href='?do=news&p".($now+1)."'> &gt;</a>";
        }

?>
</div>

</fieldset>

<script>
function edit(){
    let ids=$("input[name='id[]'")
            .map((idx,item)=>$(item).val()).get();
    let del=$("input[name='del[]']:checked")
            .map((idx,item)=>$(item).val()).get();
    let sh=$("input[name='sh[]']:checked")
            .map((idx,item)=>$(item).val()).get();

    $.post("./api/edit_news.php",{ids,sh,del},(res)=>{
        location.reload();
    })

}


</script>