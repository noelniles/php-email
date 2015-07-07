$(document).ready(function(){
    $("#myForm").submit(function(){
        $.ajax({
            type: "POST",
            url: "contact_form/form_action.php",
            data: $("#myForm").serialize(),
            dataType: "json",

            success: function(msg){
                $("#formResponse").removeClass('error');
                $("#formResponse").removeClass('success');
                $("#formResponse").addClass(msg.status);
                $("#formResponse").html(msg.message);
            },  
            error: function(){
                $("#formResponse").removeClass('success');
                $("#formResponse").addClass('error');
                $("#formResponse").html("There was an error submitting the form. Please try again.");
            }   
        }); 
        // Make sure the form doesn't post.
        return false;
    });
});
       
