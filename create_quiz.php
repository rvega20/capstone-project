<?php require_once('includes/auth.include.php'); 
restrictAccess("teachers");
?>

<!-- TODO:

- Warn user when a question has no answer
- Warn user when a question is blank
- Warn user when an answer is blank
- Ajax Post

-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Create a Quiz</title>

	<?php include('includes/header.include.php'); ?>

	<style type="text/css">
		.disabled{
			opacity: 0.5; /* opacity [0-1] */
			-moz-opacity: 0.5; /* opacity [0-1] */
			-webkit-opacity: 0.5; /* opacity [0-1] */
		}
	</style>

</head>
<body>

	<?php include('includes/nav.include.php'); ?>
	<div class="container">

		<form class="form-horizontal" id="quiz-create" action="create_quiz_submit.php" method="post">
			<fieldset>
				<!-- Form Name -->
				<h1 style="text-align:center; margin-bottom:4%; margin-top:0%;">Quiz Builder</h1>

				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="name">Quiz Name</label>  
					<div class="col-md-4">
						<input id="name" name="name" placeholder="Name of your Quiz" class="form-control input-md" required="" type="text">
					</div>
				</div>

				<hr>
				<div class="question">
					<div class="form-group">
						<label class="col-md-4 control-label" for="q[1]">Question 1</label>
						<div class="col-md-4">                     
							<textarea class="form-control question-box" id="q[1]" name="q[1]" placeholder="Enter a Question"></textarea>
						</div>
						<label class="control-label remove-button hidden">
							<span class="glyphicon glyphicon-remove"></span>
						</label>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="a[1][1]">Answer 1</label>
						<div class="col-md-4">
							<div class="input-group">
								<input id="a[1][1]" name="a[1][1]" class="form-control answer-box" placeholder="Enter an Answer" type="text">
								<span class="input-group-addon">     
									<input type="checkbox" class="check-correct" name="check[1][1]">
								</span>
							</div>
						</div>
						<label class="control-label remove-button hidden">
							<span class="glyphicon glyphicon-remove"></span>
						</label>
					</div>

					<div class="form-group disabled">
						<label class="col-md-4 control-label" for="a[1][2]">Answer 2</label>
						<div class="col-md-4">
							<div class="input-group">
								<input id="a[1][2]" name="a[1][2]" class="form-control answer-box" placeholder="Enter an Answer" type="text">
								<span class="input-group-addon">     
									<input type="checkbox" class="check-correct" name="check[1][2]" disabled="">     
								</span>
							</div>
						</div>
						<label class="control-label remove-button hidden">
							<span class="glyphicon glyphicon-remove"></span>
						</label>
					</div>
				</div>

				<hr>
				<div class="question">
					<div class="form-group disabled">
						<label class="col-md-4 control-label" for="q[2]">Question 2</label>
						<div class="col-md-4">                     
							<textarea class="form-control question-box" id="q[2]" name="q[2]" placeholder="Enter a Question"></textarea>
						</div>
						<label class="control-label remove-button hidden">
							<span class="glyphicon glyphicon-remove"></span>
						</label>
					</div>
				</div>

				<hr>

				<!-- Button (Double) -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="button1id"></label>
					<div class="col-md-4">
						<button id="submitQuiz" class="btn btn-success btn-lg btn-block">Save Quiz</button>
					</div>
				</div>


			</fieldset>
		</form>

		<!-- Hide new question and answer boxes outside the form so they don't trip -->

		<span style="display: none;" id="hiddenQuestion">
			<div class="question">
				<div class="form-group">
					<label class="col-md-4 control-label" for="appendedcheckbox">Answer 1</label>
					<div class="col-md-4">
						<div class="input-group">
							<input id="q[1][1]" name="q[1][1]" class="form-control answer-box" placeholder="Enter an Answer" type="text">
							<span class="input-group-addon">     
								<input type="checkbox" class="check-correct" disabled>
							</span>
						</div>
					</div>
					<label class="control-label remove-button hidden">
						<span class="glyphicon glyphicon-remove"></span>
					</label>
				</div>

				<div class="form-group disabled">
					<label class="col-md-4 control-label" for="appendedcheckbox">Answer 2</label>
					<div class="col-md-4">
						<div class="input-group">
							<input id="q[1][2]" name="q[1][2]" class="form-control answer-box" placeholder="Enter an Answer" type="text">
							<span class="input-group-addon">     
								<input type="checkbox" class="check-correct" disabled>     
							</span>
						</div>
					</div>
					<label class="control-label remove-button hidden">
						<span class="glyphicon glyphicon-remove"></span>
					</label>
				</div>
				<hr>
				<div class="form-group disabled">
					<label class="col-md-4 control-label" for="q[2]">Question 2</label>
					<div class="col-md-4">                     
						<textarea class="form-control question-box" id="q[2]" name="q[2]" placeholder="Enter a Question"></textarea>
					</div>
					<label class="control-label remove-button hidden">
						<span class="glyphicon glyphicon-remove"></span>
					</label>
				</div>
			</div>
		</span>

		<span style="display: none;" id="hiddenAnswer">
			<div class="form-group disabled">
				<label class="col-md-4 control-label"></label>
				<div class="col-md-4">
					<div class="input-group">
						<input class="form-control answer-box" placeholder="Enter an Answer" type="text">
						<span class="input-group-addon">     
							<input type="checkbox" class="check-correct" disabled>     
						</span>
					</div>
				</div>
				<label class="control-label remove-button hidden">
					<span class="glyphicon glyphicon-remove"></span>
				</label>
			</div>
		</span>
		
		<?php include('includes/footer.include.php'); ?>

	</div>


</div>

<?php include('includes/scripts.include.php'); ?>

<script type="text/javascript">
	var qarr = [2];
	var prevQClose;
	

	function nameToQNum(name){
		//Convert the HTML ID in the format q[x][x] to return just question #
		name = name.substring(2).split("]")[0];
		return name;
	}

	function newQuestion(){
		// Build out the HTML for a new question
		html = $("#hiddenQuestion").html();
		return html;
	}

	function newAnswer(){
		// Build out the HTML for a new answer
		html = $("#hiddenAnswer").html();
		return html;
	}

	function buildAnswerLabels(object, qnum){
		// Generate the labeling for the newly generated answer

		// First, increment the corresponding entry in the array by one
		anum = qarr[qnum-1] += 1;
		// Generate field name based on question and answer numbers
		ansid = "a[" + qnum + "][" + anum + "]";
		checkid = "check[" + qnum + "][" + (anum - 1) + "]";

		//find the label and the input in question
		var label = object.find(".control-label").first();
		var input = object.find(".answer-box").first();
		var check = object.prev().find(".input-group-addon").find(".check-correct").first();
		var prevclose = object.prev().prev().find(".remove-button");
		var close = object.prev().find(".remove-button");

		// Change inputs
		label.attr("for",ansid)
		.text("Answer " + anum);

		input.attr("id",ansid)
		.attr("name",ansid);

		check.removeAttr("disabled")
		.attr("name", checkid);
/*
		prevclose.addClass("hidden");

		close.removeClass("hidden");
		close.click(function() {
			close.after(newQuestion());
			close.closest(".form-group").next().remove();
			close.closest(".form-group").remove();
			qarr[qnum-1] -= 1;
			newAnswer();
			buildAnswerLabels(object, qnum);
		});*/

		return true;
	}

	function buildQuestionLabels(object){
		// Generate the labeling for the newly generated question
		qnum = qarr.length + 1;
		// First, add a new question entry to the array
		qarr.push(2);

		// now count array length and add one to get question #
		for (var x=0; x<=3; x++){
			if (x > 0 && x < 3){
				anum = x;
				id = "a[" + qnum + "][" + anum + "]";
				checkid = "check[" + qnum + "][" + (anum - 1) + "]";
				//find the label and the input in answer
				var clabel = object.find(".control-label").first();
				var ainput = object.find(".answer-box").first();
				var check = object.prev().find(".input-group-addon").find(".check-correct").first();

				clabel.attr("for",id)
				.text("Answer " + anum);

				ainput.attr("id",id)
				.attr("name",id);

				check.removeAttr("disabled")
				.attr("name", checkid);

			}
			else{
				//find the label and the input in question
				var clabel = object.find(".control-label").first();
				var qinput = object.find(".question-box").first();

				if (x == 0){
				var close = object.find(".remove-button");

				if (prevQClose){
					prevQClose.addClass("hidden")
					.css('background', 'red');
				}

				close.removeClass("hidden");
				prevQClose = close;
				}

				
				if (x == 3) {
					qnum = qarr.length+1;
				}
				
				id = "q[" + qnum + "]";
				clabel.attr("for",id)
				.text("Question " + qnum);
				
				qinput.attr("id",id)
				.attr("name",id);

			}
			//advance ahead by one form-group
			object = object.nextAll(".form-group").first();

		}
		
		return true;
	}

	$('body').on('click', 'textarea.question-box', function() {
		formparent = $(this).closest('div[class^="form-group"]');
		if (formparent.hasClass("disabled")){
			formparent.removeClass("disabled");
			formparent.after(newQuestion());
			buildQuestionLabels(formparent);
		}
	});

	$('body').on('click', 'input.answer-box', function() {
		formparent = $(this).closest('div[class^="form-group"]');
		if (formparent.hasClass("disabled")){
			formparent.removeClass("disabled");
			qnum = nameToQNum($(this).attr("name"));
			formparent.after(newAnswer());
			buildAnswerLabels(formparent.next('div[class^="form-group"]'), qnum);
		}
	});

	function validate(formData, jqForm, options) { 
		return true;
		// fieldValue is a Form Plugin method that can be invoked to find the 
		// current value of a field 
		// 
		// To validate, we can capture the values of both the username and password 
		// fields and return true only if both evaluate to true 
		
		var usernameValue = $('input[name=username]').fieldValue(); 
		var passwordValue = $('input[name=password]').fieldValue(); 
		
		// usernameValue and passwordValue are arrays but we can do simple 
		// "not" tests to see if the arrays are empty 
		if (!usernameValue[0] || !passwordValue[0]) { 
			alert('Please enter a value for both Username and Password'); 
			return false; 
		} 
		alert('Both fields contain values.'); 
	}

	// wait for the DOM to be loaded 
	/*$(document).ready(function() { 
		// bind 'myForm' and provide a simple callback function 
		$('#quiz-create').ajaxForm({ 
			beforeSubmit: validate, 
			success: function(){
				alert("Submitted!");
			}  
		}); 
	}); */
	</script>
</body>
</html>
