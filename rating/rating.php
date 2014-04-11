<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Star Rating</title>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.raty.min.js"></script>
<style type="text/css">
    table,th,td {border:1px solid; border-spacing:0px; padding:3px 5px; border-collapse:collapse;}
    .p-name{text-align: center; width:380px;}
    .p-score{text-align: center; width:50px;}
    .p-rating-btn{text-align: center; width:200px;}
</style>

</head>

<body>

<table id="product-tbl">
    <thead>
    <tr>
        <th class="p-name">Product</th>
        <th class="p-score">Rating</th>
        <th class="p-rating-btn"></th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<div id="star-ct"></div>

<script type="text/javascript">
    function refreshProduct(){
        $.ajax({
            url: 'dataProcessor.php',
            data: {
                action: 'getProducts'
            },
            dataType: 'json',
            success: function(resp) {
                if(resp['success']){
                    var $tbody = $('#product-tbl tbody');
                    $tbody.empty();
                    
                    for(var i=0,len=resp['data'].length; i<len; i++){
                        $tbody.append(
                           ['<tr>',
                                '<td class="p-name">'+resp['data'][i]['name']+'</td>',
                                '<td class="p-score">'+resp['data'][i]['score']+'</td>',
                                '<td id="p-btn-'+resp['data'][i]['id']+'" class="p-rating-btn"></td>',
                            '</tr>'].join('')
                        );
                    }
                    $('td.p-rating-btn').raty({
                        half : true,
                        size : 24,
                        starHalf : 'star-half-big.png',
                        starOff : 'star-off-big.png',
                        starOn : 'star-on-big.png',
                        click : function(score, evt) {
                            var id = parseInt( this.attr('id').substr(6) );
                            submitScore(id,score);
                        }
                    });
                }else{
                    alert("Fetching data failed.");
                }
            }
        });
    }
    
    function submitScore(productId, score){
        $.ajax({
            url: 'dataProcessor.php',
            data: {
                action: 'addRaty',
                productId: productId,
                score: score
            },
            dataType: 'json',
            success: function(data) {
                if(data['success']){
                    alert("Great job, rating processed.");
                    refreshProduct();
                }else{
                    alert("Processing failed.");
                }
            }
        });
    }
    
    $(function() {
        refreshProduct();
    });
</script>
</body>
</html>