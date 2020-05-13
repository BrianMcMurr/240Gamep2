<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="gameBackground.css">
	<link rel="stylesheet" type="text/css" href="fallingBlocks.css?v=1">
	<button type = "button" id= "startGameButton" onclick="run('<?php echo $_POST['song']?>','<?php echo $_POST['gameType'] ?>');document.getElementById('startGameButton').remove();">Click me to start game</button>
	<div id = "background" class="gameBackground"></div>
</head>

<body>
	<form action="../EndScreens/Victory Screen/VictoryScreen.php" id="win" method="post">
	<input type="hidden" id = "winScore" name = "score" value=""></form>
	<form action="../EndScreens/LoseScreen/LScreen.php" id="lose" method="post">
	<input type = "hidden" id = "loseScore" name = "score" value=""></form>
	<script src="randomEquation.js"></script>
	<script type="text/javascript">
		var gameStyle;
		var go; //this variable will hold the interval for blockCannon. Initialized in start(gap).
		var blockInterval = 1000;//diffuclty of game, the lower, the harder
		var counter = 0;//counts number of total blocks created
		var blockList = new Array(); //list containing all active blocks
		var currentScore = 0;//the current points earned by the player
		var missedPoints = 0;//number of points missd by the player
		var maxMissedPoints = 100;//maximum number of points allowed to be missed by the player untill the game ends  
		var iWon = 'win';// varible for checking weather player has won or lost game, values are 'win' for winning, or 'lose' for when the player loses

		/**
		 * This function runs the game when the "start game" button is pressed. Music will play according to the song that the user selected
		 * and blocks will start to fall from the blockCannon function.
		 */
	   function run(selectedSong, selectedGameType) {
		   //make an audio tag based on the selected song
			gameStyle = selectedGameType;
			var sound = new Audio('../MusicPic/' + selectedSong + '.mp3');
			//adjust the difficulty based on the song selected (lower is harder).
			switch(selectedSong) {
				case("EverytimeWeTouch"):
					blockInterval = 6000;
					break;
				case("HannahMontana"):
					blockInterval = 5000;
					break;
				case("In_the_Jungle"):
					blockInterval = 4000;
					break;
				case("Revenge"):
					blockInterval = 3000;
					break;
				case("TNT"):
					blockInterval = 2000;
					break;
				case("WhatMakesYouBeautiful"):
					blockInterval = 1000;
					break;
				default:	
					alert("Song not Found");
					break;
			}
			//set attributes and append audio tag to document body:
			sound.id = "playingSong";
			document.body.appendChild(sound);
			//play the song:
			sound.play();
			//listen for when the song ends and execute the stop function:
			sound.addEventListener('ended',stop);
			//call block cannon every blockInterval milliseconds and update score:
			go = setInterval(blockCannon, blockInterval);
			updateScore();
	   }

	   /**
		* This function displays the user's current score and how many points they have missed so far.
	    */
		function updateScore() {
			document.getElementById("background").innerHTML = "Your current score is " + currentScore + "\n You've missed " + missedPoints + " points so far";
		}
		
		/**
		 * The stop() function stops blocks from falling, adjusts the loseScore and winScore html tags, updates the leaderboard, and redirect 
		 * to either a win or lose screen based on the game's outcome.
		 */
		function stop(){
			//if(stopVal != 0){
			clearInterval(go);
			updateHighScore(currentScore);
			document.getElementById('loseScore').value = currentScore;
			document.getElementById('winScore').value = currentScore;
			document.getElementById(iWon).submit();
			//update highscore with php 
		}

		/**
		 * the updateHighScore(newScore) function updates the .txt file containing the userinfo with the latest scores.
		 */
		function updateHighScore(newScore){
			var args = {
				score: newScore,
				gameType: "<?php echo $_POST['gameType']?>"
			}
			jQuery.ajax({
   				  type: "POST",
   				  url: '../Misc/update_score.php',
   				  data: JSON.stringify(args)
				});
				console.log("done");
			}

		/**
		 * blockCannon() makes blocks fall with random equations from the top of the screen to the bottom.
		 */
		function blockCannon() {
			++counter;
			var currentBlockId = "block" + counter; 
			var randomEquation;
			//access the gameType
			var gameType = '<?php echo $_POST['gameType'] ?>';
			//generate a random equation based on gameType:
			if(gameType == 'addition'){
				randomEquation = generateAddition();
			} else {
				randomEquation = generateSubtraction();
			}
			//make a Block with the equation and its own unique blockID:
			makeBlock(currentBlockId, randomEquation);
			var newBlock = {id: currentBlockId, equation: randomEquation};
			//push that block into the list:
			blockList.push(newBlock);
		}
		/**
		 * makeBlock() creates block with a random animation of either blockfall1, blockfall2, or blockfall3. Then appends the object to the webpage and sets the inner html equal to the equation which it holds
		*/
		function makeBlock(newBlockId, equation) {
			var rand = parseInt(Math.random() * 4) + 1; //create a random number between 1 and 4 inclusive
			var block = document.createElement('div');// block object to be appended to webpage
			block.addEventListener("webkitAnimationEnd", animationEndListener);//event listener that triggers on animation end to delete block
			block.setAttribute("id",newBlockId);
			block.setAttribute("class", "fallingBlocks");
			switch(rand){//random selection of the main animation patterns for the blocks
			case (1) : block.setAttribute("style","animation-name: blockFall1"); break;
			case (2) : block.setAttribute("style","animation-name: blockFall2"); break;
			case (3) : block.setAttribute("style","animation-name: blockFall3"); break;
			default : block.setAttribute("style","animation-name: blockFall4"); break;
			}
			block.setAttribute("color","blue");//creates color value of block used to determine if the user has answered that block yet or not
			document.body.appendChild(block);
			//block.setAttribute("style","background-color: turquoise");
			block.innerHTML = equation.fontsize(6);

		}

		/**
		 * animationEndListener listens for when a block reaches the bottom of the screen. When it does, it updates the score and 
		 * checks to see if the game is over or not.
		 */
		function animationEndListener(e) {
			//when event triggers, removes block from webpage and removes block from blockList
			removeBlockId = e.target.getAttribute("id");
			color = e.target.getAttribute("color");
			//find the block that has ended and remove it from the list:
			for(i = 0; i < blockList.length; i++) {
				if(removeBlockId == blockList[i].id){
					blockList.splice(i,1); 
				}
			}
			e.target.remove();
			if(color == "blue") {//if the user hasn't answered it
				explosion(); //make a noise so that the user knows that they got it wrong
				missedPoints += 10; //penalize them with points
			}
			updateScore();// updates score counter on webpage
			checkIfGameFinish();// checks if player has missed maximum number of points
		}
		/**
		 * checks if the user has missed the maximum amount of points, if so ends the game and gives score card as alert
		 */
		function checkIfGameFinish() {
			if(missedPoints == maxMissedPoints) {
				iWon = 'lose';
				for (i = 0; i < blockList.length; i++) {
					document.getElementById(blockList[i].id).remove();
				}
				stop();//stops the game 
			}
		}
		/**
		 * explosion() makes an explosion noise
		 */
		function explosion() {
			var explosions = <?php echo explosionOptions();?>;
			var explode = new Audio("../soundEffects/Explosions/" + explosions[Math.floor(Math.random()* (explosions.length - 2) + 2 )]);
			explode.addEventListener("ended",explode.remove());
			explode.play();		
		}
	</script>
	

	<?php 
	function explosionOptions() {
		echo json_encode(scandir("../soundEffects/Explosions"));
	}
	?>
	<textarea id = "userGuess" cols="40" rows="5" onkeypress="checkEntryValue(event)"></textarea>
	<script type="text/javascript">
		var guess = ""; //stores a user's guess
		/**
		 * checkEntryValue(e) checks to see if the entered value is the correct answer to any of the current blocks.
		 */
		function checkEntryValue(e) {
			// if user presses enter then checks the value inside textbox and compares it to the values of the equations inside of 
			//blockList to see if the user input is correct, if so then removes block from screen and block list
			if (e.keyCode == 13) {
				e.preventDefault();//prevents enter from performing default function
				guess = document.getElementById("userGuess").value;//stores value of user guess
				for(var i = 0; i < blockList.length; i++){//runs through existing blocks to check if they hold value equal to user guess
					if(getAnswer(blockList[i], i) == true) {// if value is equal to a block then deletes that block
							break;
					}	
				}
				document.getElementById("userGuess").value = "";//resets text area to blank

			} 
		}
		/**
		 * getAnwer(block, iterator) is a helper function for checkEntryValue(e). It calculates the correct value for each of the Blocks
		 * and tries to match the guess variable to the correct answer. If it finds a match, it retuns true, otherwise, it returns false.
		 */
		function getAnswer(block, iterator) {//checks if user input is equal to the chosen blocks equation value, if so then removes block from screen and blockList Array
			asArray = block.equation.split(" ");//splits and solves the equation stored within the block equation
			num1 = parseInt(asArray[0]);
			symbol = asArray[1];
			num2 = parseInt(asArray[2]);
			if (symbol == "+"){//if addition, then solves as additon
				result = num1 + num2;
			} else {//if subtration, solve for subtraction
				result = num1 - num2;
			}
			if(result == parseInt(guess)) {//if user guess is correct then deletes the Block, updates score, and changes the Block's color
					elem = document.getElementById(block.id);
					animationName = elem.getAttribute("style");
					elem.setAttribute("style", "background-color: orchid;" + animationName);
					elem.setAttribute("color", "orchid");//saves color attribute of Block as orchid if correct
					blockList.splice(iterator, 1); 
					currentScore += 10;
					updateScore();
					return true;
				}
				else{
					return false;
				}
			}


	</script>
</body>
	</html>
