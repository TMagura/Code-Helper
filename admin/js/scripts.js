
		$(document).ready(function(){
			$('#selectAllBoxes').click(function(event){

			if(this.checked) {

			$('.checkBoxes').each(function(){

				this.checked = true;
			});
		  } 
	       else {
			$('.checkBoxes').each(function(){

			this.checked = false;

			   });
			  }
			});
		});

		//make users appear to be online after evry refresh automatically
			function loadUsersOnline(){
			$.get("functions.php?onlineusers=result",function(data){

				$(".onlineusers").text(data);
			});
		} 
			setInterval(function() {
				loadUsersOnline();
		}, 500); 

