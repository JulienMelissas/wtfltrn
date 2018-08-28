<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>What The Fuck Should I Listen To Right Now?</title>
		<link rel='stylesheet' href='style.css' type='text/css'/>
		<script src="//code.jquery.com/jquery-3.3.1.slim.min.js" type="text/javascript"></script>
		<script src="lastfm.api.js?v1" type="text/javascript"></script>
		<script src="lastfm.api.md5.js" type="text/javascript"></script>
		<script type="text/javascript">
			//Set used once, so It can be wrote to even after get_artist() is called.
			var used = 0;
			
			function get_artist(){
				//Get artist's name from form
				var artist_name = "<?php $artist = $_GET['artist']; echo ($artist);?>";
				
				//Unhides all the div's so loading... doesn't look so weird.		
				function unhide(){
						document.getElementById('artist').style.display="block";
						document.getElementById('no_like').style.display="block";
						document.getElementById('home').style.display="block";
						document.getElementById('info').style.display="block";
				}
				
				//If something breaks, display this:
				function broken(){
						document.getElementById('message').innerHTML  = 'Well, this fucking sucks.';
						document.getElementById('artist').innerHTML  = 'It didn\'t work';
						document.getElementById('no_like').innerHTML = '';
						document.getElementById('home').innerHTML = '<p><a href="/">Put something else in</a></p>';
						unhide();
				}				
					
				//Check for Blank Form and fix, if not blank, pass to else
				if(artist_name === ""){
						document.getElementById('message').innerHTML  = 'What the fuck?';
						document.getElementById('artist').innerHTML  = 'Don\'t you know how to use this website?';
						document.getElementById('no_like').innerHTML = '';
						document.getElementById('home').innerHTML = '<p><a href="/">Put something in!</a></p>';
						unhide();
				}
				//Now we can do stuff!
				else{
				//Set last.fm stuff (if using this code, please don't take mine)
						var api_key = "b70b8e3a7dd558843614d59aed596fa4";
						var api_secret = "d52f6e011d741b685c905e8ff42f8f4a";
				//Set shit so we can use it
						var the_name = 0; //name to use for artist being displayed
						var url = 0; //link to the last.fm site for the artist being displayed
						var random_artist_number = 0; //number we'll use to pick an artist out of the array
						var response = false; //sets it so that on default, we don't get any usable data from last.fm
						var n = []; //just a number for the random generation
						
						/* Create a LastFM object (part of felix bruns javascript libs on github)*/
						var lastfm = new LastFM({
						apiKey : api_key,
						apiSecret : api_secret,
						});
						
						/* Get similar artist. (part of felix bruns javascript libs on github)*/
						lastfm.artist.getSimilar({artist: artist_name}, {success: function(data){
						//"data" is the array we get back from last.fm
						//Get length of array so we can find out how many artists we got from last.fm (usually will be 100, 0-99)
						var length = data['similarartists']['artist'].length;
						
						function random_artist_number_gen(){
						//Generate a random number to pick a random an artist
						n = Math.floor(Math.random()* length);
								//Check if the last number is the same one as we picked, we don't want duplicates
								if(used == n){
										//if true, generate a new one
										n = Math.floor(Math.random()* length);
										//just in case... do it again
										if(used == n){
												n = Math.floor(Math.random()* length);
												return n;
										}
										return n;
								}
								else{
										//if n is new, pass it!
										return n;
								}
						}
						
						//Set the number from our function above
						random_artist_number = random_artist_number_gen();
						//Set used so that we know not to get duplicates after the first time
						used = n;
						
						//Call the name of the artist
						the_name = data['similarartists']['artist'][random_artist_number]['name'];
						//Get the link to the artist's page
						url = data['similarartists']['artist'][random_artist_number]['url'];
						
						//Check to make sure we got usable data from last.fm
						if(url != (0 || undefined))
						{
								response = true;
						}
								//If we don't get anything from last.fm, display the broken message
								if(response == false)
								{
										broken();
								}
								//If we DO, write it in!
								else if(response == true)
								{
										//Display's message - code in below in the body
										DisplayRandomDiv();
										//Write the artist
										document.getElementById('artist').innerHTML = '<a href="' + url + '" target="blank">' + the_name + '</a>';
										//Show the other divs
										unhide();
								}
						}, error: function(code, message){
								/* If our call to last.fm doesn't work - Show error message. */
								broken();
						}});
					}
			}
		</script> 
		<?php include_once("analyticstracking.php") ?>
	</head>
  <body onload="get_artist()">
		<div id="dl">
				<div id="message">
						<div id="randomdiv1" class="fucking_header">Have a fucking audiogasm and turn on some</div>
						<div id="randomdiv2" class="fucking_header">How about some fucking</div>
						<div id="randomdiv3" class="fucking_header">Why the fuck arn't you listening to</div>
						<div id="randomdiv4" class="fucking_header">Blow your eardrums out with some fucking</div>
						<div id="randomdiv5" class="fucking_header">Make your ears bleed with some fucking</div>
						<script type="text/javascript"><!--
						/* Random Div Display
						 Version 1.0
						 March 9, 2009
						 Will Bontrager
						 http://www.willmaster.com/
						 Copyright 2009 Bontrager Connection, LLC
						For information about implementing this software, see the article at
						http://www.willmaster.com/library/javascript/random-div-display.php
						*/
						
						// One place to customize:
						//
						// Type the number of div containers to randomly display.
						
						NumberOfDivsToRandomDisplay = 5;
						
						// No other customizations required.
						////////////////////////////////////
						var CookieName = 'DivRamdomValueCookie';
						function DisplayRandomDiv() {
						var r = Math.ceil(Math.random() * NumberOfDivsToRandomDisplay);
						if(NumberOfDivsToRandomDisplay > 1) {
							 var ck = 0;
							 var cookiebegin = document.cookie.indexOf(CookieName + "=");
							 if(cookiebegin > -1) {
									cookiebegin += 1 + CookieName.length;
									cookieend = document.cookie.indexOf(";",cookiebegin);
									if(cookieend < cookiebegin) { cookieend = document.cookie.length; }
									ck = parseInt(document.cookie.substring(cookiebegin,cookieend));
									}
							 while(r == ck) { r = Math.ceil(Math.random() * NumberOfDivsToRandomDisplay); }
							 document.cookie = CookieName + "=" + r;
							 }
						for( var i=1; i<=NumberOfDivsToRandomDisplay; i++) {
							 document.getElementById("randomdiv"+i).style.display="none";
							 }
						document.getElementById("randomdiv"+r).style.display="block";
						}
						//--></script>
				</div>
    </div>
    <div id="dt">
				<div id="artist">
						Loading...
				</div>
		</div>
    <div id="fucking_no">
      <div id="no_like" style="display:none;"><p><a onClick="get_artist()" style="cursor:pointer">I don't like that fucking artist.</a></p></div>
      <div id="home" style="display:none;"><p><a href="/">I want to pick another fucking artist.</a></p></div>
    </div>
    <div id="info" style="display:none;">This site was fucking made by <strong><a target="blank" href="http://www.last.fm/user/JulienAM">Julien</a></strong><br />
    This site was completly based off <br /><strong><a target="blank" href="http://www.whatthefuckshouldimakefordinner.com">What The Fuck Should I Make For Dinner</a></strong>
    </div>
		</body>
</html>