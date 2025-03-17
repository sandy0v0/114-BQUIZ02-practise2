<fieldset>
<legend>目前位置：首頁 > 最新文章</legend>

    <table style="width: 100%;">
        <tr>
            <th width="20%">標題</th>
            <th width="60%">內容</th>
            <th width=""></th>
        </tr>
        <?php
        $total=$News->count();
        $div=5;
        $pages=ceil($total/$div);
        $now=$_GET['p']??1;
        $start=($now-1)*$div;
     
        $rows=$News->all(['sh'=>1]," Limit $start,$div");
        foreach($rows as $row):
        
        ?>
        <tr>
            <td class="clo"><?=$row['title'];?></td>
            <td><?=mb_substr($row['news'],0,25);?>...</td>
            <td></td>
        </tr>
        <?php endforeach;?>
    </table>

    <div>
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


