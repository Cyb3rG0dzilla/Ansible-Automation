setInterval(function(){
	checkUserStatus();
},5000);
function checkUserStatus(){
	jQuery.ajax({
		url:'check-status.php',
		success:function(result){
			var result=result.trim();
			if(result=='logout'){
				window.location.href='logout-user.php';
			}
		}
	});			
}
