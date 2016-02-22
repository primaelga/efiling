$(document).ready(function() {
//change CAPTCHA on each click or on refreshing page
 $("#reload").click(function() {
	
        $("img#img").remove();
		var id = Math.random();
        $('<img id="img" src="captcha/captcha.php?id='+id+'"/>').appendTo("#imgdiv");
		 id ='';
    });
       
    //validation function
    $('#button').click(function() {
        var name = $("#username").val();
        var pass = $("#password").val();
        var captcha = $("#captchatext").val();

        if (name == '' || pass == '' || captcha == '')
        {
            alert("Fill All Fields");
        }

        else
        {   
            //validating CAPTCHA with user input text 
            var dataString = 'captcha=' + captcha;
            $.ajax({
                type: "POST",
                url: "auth/login.php",
                data: dataString,
                success: function(html) {
         //           alert(html);
                    }
                });
            }
    });
});