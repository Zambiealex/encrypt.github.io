var imagecount = 0;
var imagesfound = [];
var imagesnofound = [];
var activeVideos = [];
var manageimages = [];
var videos_allow = ['.webm', '.avi', '.mp4'];
var maxD = 'max-width:720px;max-height:480px;';
var defaultD = 'width:120px; height: 90px;';
var pause;
$.docElement = document.documentElement;
window.debug = false;
window.prevList = new Array();

function coreQuery(typeMethod, addr, dataString, success)
{
		 $.ajax({
				url: addr,
				type: typeMethod,
				data: dataString,
				async: true,
				success: function (data) {
					success.call(this, data);
				},
				error:function(data){
						console.log('ERROR CORE: ');
						console.log(data);
				},
				cache: false,
				contentType: false,
				processData: false
		});
	
}

function array_diff(oldarray, newarray) {
	
	oldies = new Array();
	toadd = new Array();
	
	for(i = 0; i < oldarray.length; i++) {
		oldies[oldarray[i].id] = true;
	}
	
	for(k = 0; k < newarray.length; k++) {
		if(oldies[newarray[k].id] == null) {
			toadd.push(newarray[k]);
		}
	}
	
	return toadd;
} 

function check(image)
{
		if(isScaledImg(image))
		{
				if(!image.id){
						image.id= 'expanding_' + imagecount;	
				}
				
				if(!image.index)
				{
						image.index = imagecount;
				}
				
				imagecount++;
				imagesfound.push(image.id);
		}
}

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


function isScaledImg(img) {
    var src = img.src;
    var ret;
    var parent = get_parent(img);
    if (parent) {
        if (parent.nodeName == 'A') {
            if (parent.hasAttribute('href')) {
                var href = parent.href;
                var sEnding = src.substring(src.lastIndexOf('.'), src.length).toLowerCase();
                var hEnding = href.substring(href.lastIndexOf('.'), href.length).toLowerCase();
                if (sEnding == hEnding || hEnding == '.jpg' || hEnding == '.jpeg' || hEnding == '.png' || hEnding == '.gif' || hEnding == '.svg' || hEnding == '.webm') {
                    ret = true;
                }
            }
        }
    }
    return ret;
}

function get_parent(image)
{
		var parent = image.parentNode;
		
		if (parent.nodeName == 'SPAN') {
			parent = parent.parentNode;
		}
		
		if(parent.nodeName == 'A') {
			return parent;
		}
}

// CREAR FUNCION QUE SIRVA PARA .WEBM
function replaceImage(img, parent) {
	var original,
	folder,
	thumb,
	exten,
	source,
	change,
	current,
	video, 
	image;
	
	original = img.getAttribute('data-original'); 
	thumb = img.getAttribute('data-thumb');
	folder = img.getAttribute('data-folder');
	exten = original.substring(original.lastIndexOf('.'), original.length).toLowerCase();
	source = folder + original;
	change = folder + thumb;
	current= img.src;
	
	console.log($.inArray(exten, videos_allow));
	if( $.inArray(exten, videos_allow) != -1 )
	{
		if(video = document.getElementById('expanding_video'+img.index))
		{
			parent.removeChild(video);
			img.style.display = 'block';
			img.setAttribute('style', defaultD);
			return;
		}
		
		img.style.display = 'none';
		video = document.createElement('video');
		video.controls = true;
		video.loop = true;
		video.autoplay = true;
		video.volume = 0;
		video.title = 'CLICK ON THE VIDEO TO CLOSE';
		video.src = source;
		video.setAttribute('style', maxD);
		video.id = 'expanding_video'+img.index;
		video.onplay = onWebmPlay(video);
		parent.appendChild(video);
		
		return;
		
	}
	
	if(image = document.getElementById('expanding_image'+img.index))
	{
			image.src = change;
			image.setAttribute('style', defaultD);
			image.id = '';
			return;
	}
	img.removeAttribute('style');
	img.id = 'expanding_image'+ img.index;
	img.setAttribute('style', maxD);
	img.src = source;
	
}

function onWebmPlay(video)
{
		if(!activeVideos.length){
				document.addEventListener('scroll', onWindowScroll, false );
		}
		
		activeVideos.push(video);	
}

function onWindowScroll()
{
		clearTimeout(pause);
		pause = setTimeout(onPauseVideos, 500);	
}

function onPauseVideos(){
		var videos = [], pos , min, max, i , el;
		
		min = window.pageYOffset;
		max = window.pageYOffset + $.docElement.clientHeight;
		
		for(i = 0; el = activeVideos[i];++i)
		{
					pos = el.getBoundingClientRect();
					if (pos.top + window.pageYOffset > max || pos.bottom + window.pageYOffset < min) {
					 		el.pause();
					}
					else if (!el.paused){
					 		 videos.push(el);
					}
		}
		
		if(!videos.length)
		{
				document.removeEventListener('scroll', onWindowScroll, false );
		}
		
		activeVideos = videos;
}

function replaceSource(parent, image) {
    parent.removeAttribute('href');
    parent.addEventListener('click', function () {
        remanageImage(image.id)
		replaceImage(image, parent);
    })
}


function remanageImage(imgid) {
    var img = document.getElementById(imgid);
    if(img) {
        if (img.hasAttribute('style')) {
            img.removeAttribute('style');
            var indexofimg = manageimages.indexOf(img);
            if (indexofimg >= 0) {
                manageimages.splice(indexofimg, indexofimg) 
            }
        } else {
            manageimages.push(img)
        }
    }
}

function replaceImages()
{
		var index, image;
		if( imagesnofound.length > 0)
		{
				index = arraySplice(imagesnofound);
				image = document.getElementById(index);
				if(image)
				{
						var original = image.src;
						image.removeAttribute('src');
						image.src = original;
				}
				else 
					replaceImageNext();
		}
		else if(imagesfound.length > 0)
		{
				index = arraySplice(imagesfound);
				image = document.getElementById(index);
				
				if(image)
				{
						var parent = get_parent(image);
						if(parent)
						{
								manageImages(image);
								replaceSource(parent, image);
								
						}
				}
		}
}

function manageImages(image)
{
		addEvents(image);
		manageimages.push(image);
}

function addEvents(img){
    img.addEventListener('error', function () {
        handleImgError(img.id)
    });
 	img.addEventListener('load', function () {
        handleImgLoad()
    });
}
function replaceImageNext(){
	setTimeout(function () {
        replaceImages()
    }, 100);
}

function handleImgError(imgId) {
    imagesnofound.push(imgId); 
	replaceImageNext();
}

function handleImgLoad() {
   replaceImageNext();
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
function get()
{
	if(imagesfound.length == 0 && imagesnofound.length == 0)
	{
		var images = document.getElementsByTagName('img');
		
		for(var i = 0; i < images.length; i++)
		{
				check(images[i]);	
		}
		
		for(var i = 0; i < 3; i++)
		{
				replaceImages();	
		}
	}
}

function arraySplice(array) {
    var ele = array[0];
    array.splice(0, 1);
    return ele;
}

function commentsProcess()
{
	var comments = document.getElementsByClassName('message');
			var count = 0;
			$.each(comments, function(index, value){
						var url = []; 
						var text = [];
						text[index] = comments[index].innerHTML;
						
						if(text[index].indexOf('#') != -1)
						{
								var message = [];
								message[index] = [];
								url[index] = [];
								url[index][count] = [];
								message[index][count] = text[index].substr(text[index].indexOf('#'), text[index].length);
								message[index][count] = message[index][count].match(/#(.*?)\s/gi);
								
								for(var x = 0; x <= message[index][count].length; x++)
								{ 
											if(message[index][count][x] == null || message[index][count][x] == "")
																	continue;
																	
											if(message[index][count][x] == message[index][count][x+1] ){
															comment[index].innerHTML = comment[index].innerHTML.replace(message[index][count][x], " ");
															continue;
											}
											
											message[index][count][x] = message[index][count][x].substr(1, message[index][count][x].length);				
											if(!$.isNumeric(message[index][count][x]))
														continue;
														
											var query = '#comment_'+message[index][count][x];
											 
											if( $(query).length <= 0){
															comment[index].innerHTML = comment[index].innerHTML.replace('#'+message[index][count][x], " [#notfound] ");
															continue;
											}
											
											message[index][count][x] = $.trim(message[index][count][x]);		
											comment[index].innerHTML = comment[index].innerHTML.replace('#'+message[index][count][x], '');
											url[index][count][x] = document.createElement('a');  
											url[index][count][x].href = '#comment_' + message[index][count][x];
											url[index][count][x].text = ' #'+message[index][count][x];
											url[index][count][x].setAttribute( 'data-index', '#comment_' + message[index][count][x]);
											url[index][count][x].id = index*count*x;
											comments[index].appendChild(url[index][count][x]);
											
								}
								count++;
						}
						
			});
			
		  	var adding = document.getElementsByClassName('index-attr');
			$.each(adding, function(index, value) {
						adding[index].addEventListener('click', function(){
									var place = $('#placeIndex');
									var text = place.text();
									
									if(text.indexOf(adding[index].id) != -1)
									{
												return;	
									}
									
									place.text(text + ' ' + adding[index].id);
									
									printing('ADDED!', 'orange',  2500, 200, 0);
									 
						});
						
			});
			
			jQuery('a[href^="#"]').click(function(e) {
			 
			 	// PREVENT # ONLY
				if( jQuery(this.hash).length < 1) 
								return;
				// ANIMAT SCROLL
				jQuery('html, body').animate({ scrollTop: jQuery(this.hash).offset().top}, 1000);
			 	jQuery(this.hash).addClass('temp');
				
				// REMOVE CLASS
				var temp = this.hash;
				setTimeout( function() { 
								 $(temp).removeClass('temp'); 
				}, 5000);
				
				e.preventDefault();
			});
}
function reportProcess()
{
			var reports = $('[id=report]');
			var tab = document.getElementsByClassName('tab-collapse');
			
			if( reports )
			{ 
						$.each(reports, function(index, value) {
							
									if( reports[index] == null || reports[index] == 'undefined') {
												return true;
									}
									
									reports[index].addEventListener('click', function(event) {
												$(tab).css('display', 'inline-table');
												$(tab).find('.index').html('').append(reports[index].getAttribute('data-lang') +' ' + reports[index].getAttribute('data-index'));
												$(tab).find('.close').on('click', function(event) {
															$(tab).css('display', 'none');
															event.preventDefault();
												});
												
												if( reports[index].getAttribute('data-report') == 'post')
												{
													$(tab).find('[name=postid]').val(reports[index].getAttribute('data-index'));
													$(tab).find('[name=comid]').val(0);
													
												}
												else if( reports[index].getAttribute('data-report') == 'comment')
												{
													$(tab).find('[name=comid]').val(reports[index].getAttribute('data-index'));
													$(tab).find('[name=postid]').val(0);
												}
												event.preventDefault();
									});
						});
				
			}
}

function formProcess() {
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
										reloadPage(3000, 0, 0);
										e.preventDefault();
							});
						});
			}
}

function recentProcess()
{
			
			var template = $("#getRecent");
			if( template )
			{
				coreQuery("GET", "/secure/actions/auth/recent/get", '', function(results){
							results = jQuery.parseJSON(results);
						
							if(window.debug) {
								console.log("RESULTS: "); 	console.log(results);
								
							}
							
							add = array_diff(window.prevList, results);
							
							if( add.length < 1 )
							{
										setTimeout(function()
										{
											// PREVENT EMPTY RECENT
											recentProcess();
											
										}, 400);
							}
							
							for(i = (add.length - 1); i >= 0; i--) {
								try {
									addRecent(template, add[i]);
								}
								catch (err) {
										
								}		
							}
							
							try {
												$("abbr.timeago").timeago();
							}
							catch (err) {
												console.log("ERROR! timeago");
							}
											
							window.prevList = results;
				});
			}
}

function addRecent(template, result)
{
			var anim = template.tmpl(result);
			animateAndAdd(anim);
}

function animateAndAdd(element) {
	element.css("visibility", "hidden");
	$("#routing").prepend(element);
	element.slideDown(600,function() {
		$(this).css("visibility", "visible");
		$(this).css("display", "none");
		$(this).fadeIn(500);
	});
}

$(document).ready(function(e) {
			 
			 
			// GET ALL THUMBS 
			get();
			
			// RECENT
			recentProcess();
			
			// PARSE TIME AGO
			try {
				$("abbr.timeago").timeago();
			}
			catch (err) {
				console.log("ERROR! timeago");
			}
			
			
			// CHECK COMMENTS
			commentsProcess();
			
			// CHECK REPORTS
			reportProcess();
			
			// CHECK FORMS 
			formProcess();
			
			// PREVENT HEADER HEIGHT 
			$('.header').height(  window.innerHeight );
});
 