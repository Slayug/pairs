//On défini ces deux variables pour gérer l'ajout et réponse pour un questionnaire
/**
*	key: idQuestion
*	value: titre de la question (string)
*/
var questions_ = new Map();
/**
*	key: idQuestion
*	value: Map de answers
*/
var answers_ = new Map();
var questionSelected = 0;
/**
*	Permet de avoir quel select l'utilisateur a intéragi en dernier
*	0 --> questions
*	1 --> answers
*/
var selectSelected = -1;

function spawnDivAndInnerUrl(divId, url){
	var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			div = spawnDiv(divId);
			div.innerHTML = xhr.responseText;
		}
    };
	xhr.send(null);
}
function spawnDivAndInnerContent(divId, content){
	div = spawnDiv(divId);
	div.innerHTML = content;
}
function spawnDiv(divName){
	var div = document.getElementById(divName);
	div.className = "startMove";
	if(divName == "field_registration"){
		divContent = document.getElementById("registration");
		//divContent.style.width = "18%";
		//div.style.width ="20%";
	}
	return div;
}
function closeDiv(divName){
	var div = document.getElementById(divName);
	if(div == null){
		window.location = "index.php";
	}
	div.className = "initMove";
	div.innerHTML = "";
	div.style.height="auto";
}
function submitDiv(div){
	document.getElementById(div).submit();
}
function arrowRight(){
	var elements = new Map();
	if(selectSelected == 0){
		$("#questions").find(":selected").each(function() {
			elements.set($(this).val()+'', $(this).text());
			questions_.set($(this).val()+'', $(this).text());
			$(this).remove();
		});
		/*for(var key of questions_.keys()){
			divQuestions.append('<div class="question question-'+key+'"><h5>'+questions_.get(key)+'</h5><h6>Réponses:</h6></div>');
		}*/
		var divQuestions = $("#questions-questionnaires");
		for(var key of elements.keys()){
			var remove = '<button style="float:right;margin-top:6px;" onclick="removeQuestion('+key+')" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon glyphicon-remove" ></span></button>'
			var click = ' onclick="selectQuestion('+key+')"'
			var answers = '<ul class="sortable" id="answers-question-'+key+'"></ul>'
			divQuestions.append('<div class="question" id="question-'+key+'" '+click+'>'+remove+'<h4>'+elements.get(key+'')+'</h4><h6>Réponses:</h6>'+answers+'</div>');
			questionSelected = key;
		}
	}else if(selectSelected == 1){
		$("#answers").find(":selected").each(function() {
			elements.set($(this).val()+'', $(this).text());
		});	
		var answersList = $('#answers-question-'+questionSelected);
		if(answers_.get(questionSelected+'') == null){
			answers_.set(questionSelected+'', new Map());
		}
		for(var key of elements.keys()){
			if(!answers_.get(questionSelected+'').has(key+'')){
				var remove = '<button style="float:right;" onclick="removeAnswer('+questionSelected+','+key+')" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon glyphicon-remove" ></span></button>'
				var sortable = '<span class="add-on"><i class="icon-sortable"></i></span>'
				answersList.append('<li class="ui-state-default" class="answer" id="answer-'+key+'"> '+sortable+' '+elements.get(key+'')+' '+remove+'</li>');
				answers_.get(questionSelected+'').set(key+'', elements.get(key+''));				
			}
		}
		//$(function() {
		
		$("#answers-question-"+questionSelected).sortable();
		$("#answers-question-"+questionSelected).disableSelection();
		//});
	}
	console.log(answers_);
	updateQuestionSelected();
}
function arrowLeft(){
}
function selectQuestion(idQuestion){
	questionSelected = idQuestion;
	updateQuestionSelected();
}
function updateQuestionSelected(){
	for(var key of questions_.keys()){
		var bloc = $("#question-"+key);
		bloc.removeClass('question-selected');
	}
	if(questionSelected != 0){
		var bloc = $("#question-"+questionSelected);
		bloc.addClass('question-selected');
	}
}
/**
*	Permet de définir sur quel select l'utilisateur a intéragi en dernier
*	0 --> questions
*	1 --> answers
*/
function changeSelectMode(type){
	if(type >= 0){
		selectSelected = type;
	}
}
function removeAnswer(idQuestion, idAnswer){
	$('#question-'+idQuestion+' #answer-'+idAnswer).remove();
	answers_.get(idQuestion+'').delete(idAnswer+'');
}
/**
*	supprime le bloc et le remet dans le select
*/
function removeQuestion(id){
	$("#question-"+id).remove();
	var strQuestion = questions_.get(id+'');
	var select = $("#questions");
	select.append('<option value="'+id+'">'+strQuestion+'</option>');
	questions_.delete(id+'');
	answers_.delete(id+'');
}
/**
*	Permet d'ajouter un élément dans un select depuis un input text
*	SELECT DIV ID: elements
*	INPUT DIV ID: add-element
*/
function addElement(element){
	var newElement = $("#add-"+element);
	if(newElement.val().length > 0){
		var newId = $('select#'+element+'s option').length + 1;
		if(element == 'question'){
			newId += questions_.size;
		}
		var select = $("#"+element+"s");
		select.append('<option value="'+newId+'">'+newElement.val()+'</option>');
		newElement.val('');
	}
}
$(window).scroll(function() {
	if($("#questions-questionnaires").height() >= 400 || $("#questions-questionnaires-scroll").height() >= 400){
		if(isVisibleAfterScroll("#agent-question-answer") == false){
			$("#agent-question-answer").attr('id', 'agent-question-answer-scroll');
			$("#questions-questionnaires").attr('id', 'questions-questionnaires-scroll');
		}
		if($(window).scrollTop() <= 390){
			$("#agent-question-answer-scroll").attr('id', 'agent-question-answer');
			$("#questions-questionnaires-scroll").attr('id', 'questions-questionnaires');
		}
	}else{
		$("#agent-question-answer-scroll").attr('id', 'agent-question-answer');
		$("#questions-questionnaires-scroll").attr('id', 'questions-questionnaires');	
	}
});
/**
*	Test si un element est visible après
*	un scroll VERTICAL
*/
function isVisibleAfterScroll(elem)
{
    var $elem = $(elem);
	if($elem.length){
		var $window = $(window);

		var docViewTop = $window.scrollTop();
		var docViewBottom = docViewTop + $window.height();
		var elemTop = $elem.offset().top;
		var elemBottom = elemTop + $elem.height();

		return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
	}
}
function submitQuestionnaireAdd(){
	for(var key of questions_.keys()){
		var input = '<div class="input select"><input type="hidden" name="'+key+'#-#'+questions_.get(key+'')+'[]" value><select id="question-'+key+'" name="'+key+'#-#'+questions_.get(key+'')+'[]" id="'+key+'" multiple="multiple">';
		$('#question-'+key).find('li').each(function(){
			var id = $(this).attr('id').split('-')[1];
			var content = answers_.get(key+'').get(id+'');
			input += '<option selected="selected" value="'+id+'#-#'+content+'"></option>';
		});
		input += '</div></input></select>';
		$('#questions_submit').append(input);
	}
	document.getElementById('questionnaire_add').submit();
}
function saveSubmit(){
	var optionSave = '<input type="hidden" id="save" name="save" value></input>';
	$('#save-or-not').append(optionSave);
	//$('#questionnaires_reply').submit();
}