    refreshProduct();
	
	function refreshProduct(){
        $.ajax({
            url: 'dataProcessor.php',
            data: {
                action: 'getProducts'
            },
            dataType: 'json',
            success: function(resp) {
				if(resp['success']) {
					for(var i=0, len=resp['data'].length; i<len; i++){
						//render star
						$("#" + resp['data'][i]['shortname']).attr("voteValue", resp['data'][i]['score'] == "null" ? 0 : resp['data'][i]['score']);
						$("#" + resp['data'][i]['shortname']).raty({
							half:  true,
							start: resp['data'][i]['score'] == "null" ? 0 : resp['data'][i]['score'],
							click : function(score, evt) {
									var id = this.attr('id');
									submitScore(id, score, this.attr('voteValue'));
								}
							});
						
						//render info
						$("#" + resp['data'][i]['shortname'] + "_rt").text(resp['data'][i]['total'] + " ratings");
                    }
				} else {
                    alert("Fetching data failed.");
                }
            }
        });
    }
	
	function submitScore(productId, score, oldValue){
        $.ajax({
			type: 'POST',
            url: 'dataProcessor.php',
            data: {
                action: 'addRaty',
                shortname: productId,
                score: score
            },
            dataType: 'json',
            success: function(resp) {
                if(resp['success']){
                    //alert("Great job, rating processed.");
                    //refreshProduct();
					for(var i=0, len=resp['data'].length; i<len; i++){
						//render star
						/*
						$("#" + resp['data'][i]['shortname']).raty({
							half:  true,
							start: resp['data'][i]['score'] == "null" ? 0 : resp['data'][i]['score'],
							click : function(score, evt) {
									var id = this.attr('id');
									submitScore(id, score);
								}
							});*/
							
						$("#" + resp['data'][i]['shortname']).attr("voteValue", resp['data'][i]['score']);
						$.fn.raty.start(resp['data'][i]['score'], "#" + resp['data'][i]['shortname']);
						//render info
						$("#" + resp['data'][i]['shortname'] + "_rt").text(resp['data'][i]['total'] + " ratings");
                    }
                }else{
					$.fn.raty.start(oldValue, "#" + productId);
                    alert(resp['msg']);
                }
            }
        });
    }