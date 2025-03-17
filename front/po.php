<div>
    目前位置：首頁 > 分類網誌 > <span id="type">健康新知</span>
</div>

<style>
    .type, .list-item{
        display: block;
        margin: 10px 0;
    }
</style>

<fieldset style="width: 150px; display: inline-block;vertical-align: top;">
    <legend>分類網誌</legend>
    <a href="#" class='type' data-type='1'>健康新知</a>
    <a href="#" class='type' data-type='2'>菸害防治</a>
    <a href="#" class='type' data-type='3'>癌症防治</a>
    <a href="#" class='type' data-type='4'>慢性病防治</a>
</fieldset>

<fieldset style="width: 500px;display: inline-block;">
    <legend>文章列表</legend>
    <div id="postList"></div>
</fieldset>

<script>

getList(1)

$(".type").on('click',function(){
    $("#type").text($(this).text())

    let type=$(this).data('type')
    getList(type)
})

function getList(type){
    $("#postList").load("./api/get_list.php",{type})
}

</script>