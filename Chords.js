var Chords = function(){
	

	this.build = function(){

		this.results = $('#results')
		var loc = this;

		$('#chord').keyup(function(){
			
			if( $(this).val() == '' ){
				loc.results.children().remove();
				return;
			}
			
			console.log($(this).val().length)
			
			if( $(this).val().length == 1 ){
				$(this).val( $(this).val().toUpperCase() );
			}
			
			$.ajax({
				url: 'search.php',
				dataType: 'json',
				data: {chord:$(this).val()},
				success: function(response){
					loc.showResults(response);
				}
			});


		});

	}
	
	this.showResults=function(json){
		
		this.results.children().remove();
		
		for (var i=0; i < json.files.length; i++) {
			
			var lbl = '';

			if( json.files[i].label.length == 1){
				lbl = 'primary'
			}
			
			var img = $('<div class="imgHolder '+lbl+'"><img src="'+json.files[i].image+'"/><label>'+json.files[i].label+'</label></div>');
			
			if( lbl == 'primary'){
				this.results.prepend( img )
			}else{
				this.results.append( img )
			}
			
			
		};
		

	}



	this.build();
}

$(document).ready(function(){
	window.chords = new Chords();
})