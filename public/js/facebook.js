

window.fbAsyncInit = function() {
    FB.init({
        appId      : '562961157074755',
        status     : true, // check login status
        cookie     : true, // enable cookies to allow the server to access the session
        xfbml      : true  // parse XFBML
    });
};


(function(d){
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
}(document));


function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
        console.log('Good to see you, ' + response.name + '.');
    });
}

function Login(){
    FB.login(function(response) {
    if (response.authResponse) {
        var access_token_val = response.authResponse.accessToken;

        $.ajax( {
            url: "https://graph.facebook.com/me?access_token="+access_token_val 
            , dataType: 'json'
            , success: function( data ) { 
                console.log(data);
                console.log(access_token_val);
                $.post( "./fb_callback", 
                {
                    name        : data.first_name+' '+data.last_name,
                    email       : data.email,
                    username    : data.username,
                    access_token: access_token_val,
                    uid         : data.id 
                })
                .done(function( data2 ) {
                    $("#user-block").fadeOut("slow").hide();
                    $("#user-block").load(document.URL+" #user-block",function(data){
                        $("#user-block").fadeIn("slow").show();    
                    });

                    window.location.href = './';
                });
            }
            , error: function( data ) { 
            }
        } );

    }else{
        console.log('Authorization failed.');
    }},{scope: 'email'});
}


function FB_Logout(){
    FB.logout();
}