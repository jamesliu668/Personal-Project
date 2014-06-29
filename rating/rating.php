<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Star Rating</title>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.raty.js"></script>

</head>

<body>

<div id="star-ct"></div>
<a href="http://192.168.0.234/rating/RateManager.php?action=rating&itemid=AcjUPpoI5A&score=6">Rating</a>
<a href="http://192.168.0.234/rating/RateManager.php?action=getScore&itemid=AcjUPpoI5A">Get Rating</a>

<script type="text/javascript">
	$.fn.raty.defaults.path = 'img';
	
	$(function (){refreshProduct()});

    function refreshProduct(){
        $.ajax({
            url: 'RateManager.php',
			dataType: "text",
            data: {
                action: 'getScore',
				itemid: 'AcjUPpoI5A'
            },
            success: function(data) {
				$("#star-ct").raty({
					score: parseFloat(data),
					half : false,
					halfShow : true,
					size : 24,
					number: 10,
					starHalf : 'star-half-big.png',
					starOff : 'star-off-big.png',
					starOn : 'star-on-big.png',
					click : function(score, evt) {
						submitScore("AcjUPpoI5A", score);
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
                    refreshProduct();
                }else{
                    alert("Processing failed.");
                }
            }
        });
    }
</script>
</body>
</html>