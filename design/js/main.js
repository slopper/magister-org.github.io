function updatePrice(nowPrice) {
	var newPrice = $("#count").val()*nowPrice;
	$("#price").val(newPrice.toFixed(2)+" рублей")
}

function updateInformers() {
	$.ajax({
		dataType:'json',
		url:'/main/ajax/getInformers.php',
		type:'POST',
		success:function(data) {
			$(".informers_1").html(data.informers_1);
			$(".informers_2").html(data.informers_2);
			$(".informers_3").html(data.informers_3);
		}
	})
}

setInterval(updateInformers, 8000);