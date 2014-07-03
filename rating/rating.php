<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Star Rating</title>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.raty.js"></script>
<script type="text/javascript" language="javascript">
	$.fn.raty.defaults.path = 'img';
    function refreshProduct(itemId){
        $.ajax({
            url: 'RateManager.php',
			dataType: "text",
            data: {
                action: 'getScore',
				itemid: itemId
            },
            success: function(data) {
				$("#" + itemId).raty({
					score: parseFloat(data),
					half : false,
					halfShow : true,
					size : 24,
					number: 10,
					starHalf : 'star-half-big.png',
					starOff : 'star-off-big.png',
					starOn : 'star-on-big.png',
					click : function(score, evt) {
						submitScore(itemId, score);
					}
				});
            }
        });
    }
    
    function submitScore(productId, score){
        $.ajax({
            url: 'RateManager.php',
            data: {
                action: 'rating',
                itemid: productId,
                score: score
            },
            success: function(data) {
                if(data == "true"){
                    alert("Great job, rating processed.");
                    refreshProduct(productId);
                }else{
                    alert("Processing failed.");
                }
            }
        });
    }
</script>

</head>

<body>

<div id="AcjUPpoI5A"></div>
<script type="text/javascript">
$(function (){refreshProduct('AcjUPpoI5A')});
</script>
</body>
</html>