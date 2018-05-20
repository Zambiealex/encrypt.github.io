
function printing(text, col, delay, top, right)
{
					var add = $('<div />');
					add.css({
											position: 'fixed', 
											top: top,
											right: right,
											background: col,
											color: 'white',
											padding: 10 + 'px',
											'text-align' : 'center'
					});
					add.text(text);
					$('html').append(add);	
					setTimeout(function(){ add.remove(); },delay);
}


function reloadPage(time, url, backward)
{
		if( time > 0 )
		{
				setTimeout(function()
				{
						if( url )
							 window.location = url;
						else
							window.location.reload();
							
						if( backward )
						{
								parent.history.back();
						}
				}, time);
				return;
		}
		
		if( backward )
		{
				parent.history.back();
				return;
		}
		
		if( url  )
			 window.location = url;
		else
			 window.location.reload();
		return;
}

$(document).ready(function(e) {
	
	var items = $('[contenteditable]');
	var data  = {};
	$.each(items,function(index, value) { 
		items[index].addEventListener('keydown', function(event) 
		{
			var esc = event.which == 27,
			nl = event.which == 13;
			//var el;
			//items[index] = event.target;
			//input = items[index].nodeName != 'INPUT' && items[index].nodeName != 'TEXTAREA';	
			printing('TO SAVE CHANGES PRESS [CTRL+ENTER]', '#8ACA63', 5000, 150, 0);
			
			if (esc) 
			{
				// restore state
				document.execCommand('undo');
				items[index].blur();
			}
			
			if( !(event.ctrlKey && nl) ) { return; }
			
			// save
			$.each(items,function(id, value) { 
					data[items[id].getAttribute('data-name')] = items[id].innerText;
					items[id].blur();
				});
				
				if( !$.inArray('url', data) )
						return true;
				
				$.post( data['url'] , data, function(response) {
					printing('SAVING! ...', '#8ACA63', 2500, 200, 0);
					//console.log(response);
					$('html').append(response);
					reloadPage(3000, 0, 0);
				});
			event.preventDefault();
		}, true);
	});
	
	var searchBox = document.getElementById('search');
	
	if( searchBox )
	{
		searchBox.addEventListener('keydown', function(event) {
			
			var nl = event.which == 13;
			var value = this.value;
			var url = this.getAttribute('data-url');
			
			if( nl && value.length > 0 )
			{
				
					window.location = url + '/' + value;
			}
			
		});
	}
	
	var form = document.getElementsByTagName('form');
	if(form)
	{
						$.each(form, function(index, value) {
							$(form[index]).submit(function(e){
										$.ajax( {
											url: $(form[index]).attr('action') ,
												type: 'POST',
												  data: new FormData(form[index]),
													processData: false,
														contentType: false,
																 success: function(response) {
																	 				  $(form[index]).get(0).reset();
																					  $('html').append(response);
																 },
																 error: function(response) {
																					  $('html').append(response);
																 }
										} ); 
										reloadPage(5000, 0, 0);
										e.preventDefault();
							});
						});
	}
	
	var con = document.getElementsByTagName('a');
	if( con.length>0 )
	{
				$.each(con, function(index, value){
							if(con[index].getAttribute('id') == 'confirm')
							{			
								var url = con[index].getAttribute('href');
								con[index].removeAttribute('href');
								
								$(con[index]).css('cursor', 'pointer');
								
								con[index].addEventListener('click', function(e){
											if(confirm(con[index].getAttribute('data-lang')))
											{
														$.post(url, '', function(response){
																$('html').append(response);	
														});  
														reloadPage(5000, 0 , 0);
											}
											e.preventDefault();
								});	
							}
				});
			
	}
	
}); 

