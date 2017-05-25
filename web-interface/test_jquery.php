<!DOCTYPE html>
<html>
	<head>
		<title>MathJax TeX Test Page</title>
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#abc").click(function(){
					alert("Hello jQuery!");
				});
				
				$("#insert_equal").click(function(){
					var equation = prompt("Please enter equation (latex format)", "");
					if (equation != null) {
						equation = " $"+equation+"$ ";
						var cursorPosStart = $('#question_text').prop('selectionStart');
						var cursorPosEnd = $('#question_text').prop('selectionEnd');
						var v = $('#question_text').val();
						var textBefore = v.substring(0,  cursorPosStart );
						var textAfter  = v.substring( cursorPosEnd, v.length );
						$('#question_text').val( textBefore + equation + textAfter );
					}
				});
				
				$("#ans_type").change(function(){
					if($("#n_choice").val() == 0){
						alert("Please Enter number of choice");
					}
					else{
						var anstype = $(this).val();
						var nchoice = $("#n_choice").val();
						//multiple choice
						if(anstype == 0){
							$("#ans_form").empty();
							for(var i=0;i<nchoice;i++){
							$("#ans_form").append("<label>Answer "+(i+1)+": </label><input id=\"ans"+(i+1)+"\" type=\"text\" size=\"15\"></input>"
									+"&nbspCorrect<input type=\"radio\" name=\"correctAns\" id=\"correct"+(i+1)+"\">"
									+"<br>");
							}
						}
						//multiple correct choice
						else if(anstype == 1){
							$("#ans_form").empty();
							for(var i=0;i<nchoice;i++){
							$("#ans_form").append("<label>Answer "+(i+1)+": </label><input id=\"ans"+(i+1)+"\" type=\"text\" size=\"15\"></input>"
									+"&nbspCorrect<input type=\"checkbox\" id=\"correct"+(i+1)+"\">"
									+"<br>");
							}
						}
						//sorting choice
						else if(anstype == 2){
							$("#ans_form").empty();
							for(var i=0;i<nchoice;i++){
							$("#ans_form").append("<label>Position "+(i+1)+": </label><input id=\"ans"+(i+1)+"\" type=\"text\" size=\"30\"></input>"
									+"<br>");
							}
						}
						
						$("#ans_form").append("<p>Note: Choice will be auto shuffle order</p>");
					}
				});
			});
		</script>
	</head>
	<body>
		<div>
			<button type="button" id="abc">test</button>
			<button type="button" id="insert_equal">Equation</button>
			<textarea id="question_text"></textarea>
		</div>
		<br><br>

		<div>
			<label>Choice Number</label>
			<input id="n_choice" size="2" value="0"></input>
		<div>
		
		<div>
			<label>Answer Type</label>
			<select id="ans_type">
				<option>-- Select Type --</option>
				<option value="0">Multiple Choice</option>
				<option value="1">Multiple Correct Choice</option>
				<option value="2">Sorting</option>
			</select>
		</div>
		
		<div>
			<form id="ans_form">
			</form>
		</div>
	</body>
</html>