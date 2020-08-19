// Must define the following variables:
// repeat_groups (All repeated groups available in the form)
// responses_json (All responses that have been saved or submitted as part of a repeated group)
// validationMessage (Avalidation message if input was wrong)
// validationEmptyMessage (Validation Message if inputs were empty for submit validation)

var group_responses = []
responses_json
if(responses_json != ''){
    group_responses = Object.values($.parseJSON(responses_json));
}
var repeatGroupsCounter = [];
function activateSection(section) {
    var section_btn = '#section_btn_' + section;
    var section_content = '#section_content_' + section;
    $('a.active.step').removeClass('active');
    $(section_btn).addClass('active');
    $('div.ui.attached.active.segment').removeClass('active').hide();
    $(section_content).addClass('active').fadeIn();
}
function prevSection(){
    var currSection = parseInt($('a.active.step').attr("section"));
    var nextSection = currSection - 1;
    if($('a[section='+nextSection+']').length){
        activateSection(nextSection);
    }
    window.scrollTo(0,0);
}
function nextSection(){
    var currSection = parseInt($('a.active.step').attr("section"));
    var nextSection = currSection + 1;
    if($('a[section='+nextSection+']').length){
        activateSection(nextSection);
    }
    window.scrollTo(0,0);
}
function toogleCondQuestions(elem){
    var selector = 'div[data-condition=' + elem.attributes.dataoption.value + ']';
    $(selector).parent().show();
    $(selector).fadeIn();
    $(selector+'[data-required="yes"]').addClass('required');
    $(elem).addClass("active");
    $('input[type=radio]:not(:checked).active').map(function (index, option) {
        $(option).removeClass("active");
        var selector = 'div[data-condition=' + option.attributes.dataoption.value + ']';
        $(selector).fadeOut().removeClass('required');
    });
}
function displayErrorField(elem, msg){
    $(elem).val('').attr('placeholder', msg);
    $(elem).parent().addClass("error");
}
function removeErrorField(elem){
    $(elem).parent().removeClass("error");
}
function validateEmptyFields(){
    var isFormValid = true;
    var validationResults = [];
    $('a[id^="section_btn_"]>div.floating.label').remove();
    $('div[id^="field_"]').removeClass('error');
    $('div[id^="field_"].required').each(function(index, elem){
        var type = IntegerValue($(elem).attr('type'));
        var theme = IntegerValue($(elem).attr('data-theme'));
        $(elem).find('input[name^="q_"],textarea[name^="q_"]').each(function(inputIndex, inputElem){
            function validationProcedure(element){
                //Count the appearance of the validation issue
                validationResults[theme] = IntegerValue(validationResults[theme]) + 1;
                //Display an error on the field
                displayErrorField(element,"");
            }
            switch(type){
                //Checkbox & Radio Inputs
                case 2:
                case 3:
                    var name = $(inputElem).attr('name'); 
                    if(!$('[name="'+name+'"]:checked').length && !name.includes("other")){
                        validationProcedure($(inputElem).parent().parent());
                    }
                    break;
                //Attachments
                case 5:
                    if($(inputElem).siblings('div.ui.basic.message').length === 0){
                        validationProcedure(inputElem);
                    }
                    break;
                //All other types of input
                default:
                    if($(inputElem).val()===""){
                        validationProcedure(inputElem);
                    }
                    break;
            }
        });
    });
    validationResults.forEach(function(value, index){
        $('#section_btn_'+index+'').append('<div class="floating ui red circular label">'+value+'</div>')
    });
    if(validationResults.length != 0){
        $('#FlashMessage').html('<div class="ui negative message">'+validationEmptyMessage+'</div>');
        window.scrollTo(0,0);
        return isFormValid = false;
    }
    return isFormValid;
}
function IntegerValue(field){
    var number = parseInt(field);
    if(isNaN(number)){
        return 0;
    }
    return number;
}
function handleRepeat(group) {
    var currentGroup = "[group][1]";
    repeatGroupsCounter[group]++;
    var nextGroup = "[group]["+repeatGroupsCounter[group]+"]";
    var data_prev = $('#q_group_' + group).html();
    var data_curr = data_prev.replaceAll(currentGroup,nextGroup);
    var html_current = '<div><a href="javascript:void(0)" class="ui right floated basic segment" onclick="$(this).parent().remove();repeatGroupsCounter['+group+']--;"><i class="close red icon"></i></a>'
        + data_curr +
        '</div>';
    $('#repeat_group_' + group + '_container')
        .append(html_current);
    $('#repeat_group_' + group + '_container > div > div.repeat.group.addons').remove();
    $('#repeat_group_' + group + '_container > div > div > div.ui.header.question').remove();
    $('.ui.dropdown').dropdown();
}
function totalPercentageLimit(changedQuestion, questions, totalField=""){
    var totalPercent = 0;
    questions.forEach(function(question){
        totalPercent = totalPercent + IntegerValue($('#q_'+question+'').val());
    });
    if(totalPercent > 100){
            displayErrorField(changedQuestion, validationMessage);
        }else{
            removeErrorField(changedQuestion);
        if(totalField != ""){
            $('#q_'+totalField+'').val(totalPercent);
        }
    }   
}
$('#saveDraft').click(function(){
    $('input[name="applicationStatus"]').val('draft');
    $(this).addClass('loading');
    $('#main_form').submit();
})
$('#submitForm').click(function(){
    var isFormValid = validateEmptyFields();
    if(isFormValid){
        $('input[name="applicationStatus"]').val('final');
        $(this).addClass('loading');
        $('#main_form').submit();
    }
});
$('input[type=radio][dataoption]').change(function () {
    toogleCondQuestions(this);
});

$(function () {
    repeat_groups.forEach(group => {
        $('div[group=' + group.group + ']').wrapAll('<div id="q_group_' + group.group + '" class="ui repeating pink segment"/>');
        $('#q_group_' + group.group)
            .append(
                '<div class="repeat group addons"><div id="repeat_group_'
                + group.group +
                '_container"></div><a href="javascript:void(0)" onclick="handleRepeat('
                + group.group +
                ')" class="ui basic red right floated button repeater"><i class="plus icon"></i>'
                + group.repeat_text +
                '</a><div><br></br>'
            );
        if ($('#q_group_' + group.group).children().css("display") == "none") {
            $('#q_group_' + group.group).hide();
        }
        repeatGroupsCounter[group.group] = 1;
    });
    //Toogle conditional questions as saved before
    $.each($('input[type=radio][dataoption][checked]'), function(key,elem){
        toogleCondQuestions(elem);
    });
    // Load previously saved inputs in groups
    group_responses.forEach(function(value){
        var length = Object.keys(value.text.group).length;
        if(length>repeatGroupsCounter[value.question.group]){
            var repetitions = length - repeatGroupsCounter[value.question.group];
            for (i = 0; i < repetitions; i++) {
                handleRepeat(value.question.group);
            }
        }
        Object.values(value.text.group).forEach(function(array,key){
            var type = value.question.type;
            //Text & Text Area & Dropdown & Country
            if(type === 0 || type === 1 || type === 4 || type === 7){
                if(array.hasOwnProperty('content')){
                    $('[name="q_'+value.question.id+'[group]['+(key+1)+'][content]"]').val(array.content);
                }
            }
            //Checkboxes & Radio
            if(type === 2 || type === 3){
                if(array.hasOwnProperty('options')){
                    array.options.forEach(function(optionID){
                        $('[name="q_'+value.question.id+'[group]['+(key+1)+'][options][]"][value='+optionID+']').attr('checked','');
                    });
                }
                if(array.hasOwnProperty('other')){
                    $('[name="q_'+value.question.id+'[group]['+(key+1)+'][other]"]').val(array.other);
                }
            }
            //Phone
            if(type === 8){
                if (array.hasOwnProperty("phone")){
                    if (array.phone.hasOwnProperty("number")){
                        $('[name="q_'+value.question.id+'[group]['+(key+1)+'][phone][number]"]').val(array.phone.number);
                     }
                     if (array.phone.hasOwnProperty("code")){
                        $('[name="q_'+value.question.id+'[group]['+(key+1)+'][phone][code]"]').val(array.phone.code);
                    }
                }
            }
            //Language Percentage
            if(type === 9){
                if (array.hasOwnProperty("language")){
                    if (array.language.hasOwnProperty("name")){
                        $('[name="q_'+value.question.id+'[group]['+(key+1)+'][language][name]"]').val(array.language.name);
                        $('.ui.dropdown').dropdown();
                     }
                     if (array.language.hasOwnProperty("percentage")){
                        $('[name="q_'+value.question.id+'[group]['+(key+1)+'][language][percentage]"]').val(array.language.percentage);
                    }
                }
            }
            //File Upload
            if(type === 5){
                if(array.hasOwnProperty('file')){
                    var message = '<div class="ui basic message"><strong>Uploaded file:</strong> '+array.file+'</div>';
                    $(message).insertBefore('[name="q_'+value.question.id+'[group]['+(key+1)+']"]');
                }
            }
        });
        
    });

});   
$('input[type=text], textarea').change(function () {
    function isInputValid(regexValidation, inputValue) {
        var pattern = new RegExp(regexValidation);
        return pattern.test(inputValue);
    };
    if (!isInputValid($(this).attr('validation'), $(this).val())) {
        displayErrorField(this, validationMessage);
    } else {
        removeErrorField(this);
    }
});
$('body').delegate('input.q_percentage', 'change' , function () {
    var questionSelector = $(this).attr('name').replace(/\[.*\]/gi, "");
    var totalPercent = 0;
    $('[name^="'+questionSelector+'"].q_percentage').each(function(index, elem){
        totalPercent = totalPercent + IntegerValue($(elem).val());
    });
    if(totalPercent > 100){
        displayErrorField(this, validationMessage);
    }else{
        removeErrorField(this);
    }   
    
});
$('body').delegate('input[type=text],textarea','change',function(){
    var data = $(this).val();
    $(this).val(data.replace("'","`"));
});

$('.ui.dropdown').dropdown();