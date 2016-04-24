$(document).ready(function(){
    $("#keywords").hide();
$('select[name="Criteria"]').change(function(){
    if($('select[name="Criteria"] option:selected').val()=='Note'){
        $("#note").show();
        $("#keywords").hide();

    }
    else if($('select[name="Criteria"] option:selected').val()=='Keywords'){
        $("#keywords").show();
        $("#note").hide();
    }
});
});

