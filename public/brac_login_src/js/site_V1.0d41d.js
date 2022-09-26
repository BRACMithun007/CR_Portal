var site = getParameterByName('site');
var ref = getParameterByName('ref');
var uid = getParameterByName('uid');
var logout = getParameterByName('logout');
var error = decodeURI(getParameterByName('error'));
var googleError = decodeURI(getParameterByName('googleError'));
var userInvalid = getParameterByName('userInvalid');
var passwordInvalid = getParameterByName('passwordInvalid');
var forgetUrl = "./faces/forget-password.xhtml";
var signupUrl = "./faces/signup.xhtml";
var auth2 = {};

if(site !== undefined && site !== "") {
	forgetUrl += "?site=" + site + "&uid=" + uid;
	signupUrl += "?site=" + site + "&uid=" + uid;
	$("#nonEmailForm #site").val(site);
	$("#emailForm input#gsite").val(site);
}

if(uid !== undefined && uid !== "") {
	$("#nonEmailForm #uid").val(uid);
	$("#emailForm input#guid").val(uid);
}

$("a#forgetPass").attr('href', forgetUrl);
$("a#signup").attr('href', signupUrl);

if(ref !== undefined && ref !== "") {
	$("#nonEmailForm #ref").val(ref);
	$("#emailForm input#gref").val(ref);
}

if(error !== undefined && error !== "") {
	$("#nonEmailForm #error").html(error);
	$("#nonEmailForm #error").removeClass("d-none");
} else {
	$("#nonEmailForm #error").addClass("d-none");
}

if(googleError !== undefined && googleError !== "") {
	$("#googleError").html(googleError);
	$("#googleError").removeClass("d-none");
} else {
	$("#googleError").addClass("d-none");
}

if(userInvalid) {
	$("#nonEmailForm #user").addClass("is-invalid");
} else {
	$("#nonEmailForm #user").removeClass("is-invalid");
}

if(passwordInvalid) {
	$("#nonEmailForm #password").addClass("is-invalid");
} else {
	$("#nonEmailForm #password").removeClass("is-invalid");
}

function getParameterByName(paramKey) {
    var params = location.search.substr(location.search.indexOf("?")+1);
    var sval = "";
    params = params.split("&");
    for (var i=0; i<params.length; i++) {
    	var temp = params[i].split("=");
    	if ( [temp[0]] == paramKey ) { sval = temp[1]; }
	}
      
    return sval;
 }

function start() {
	gapi.load('auth2', function() {
		gapi.auth2.init({
			// For sso.brac.net
			//client_id: '629767295614-1giu2vma82g7v4lb9qvj1bt3dicoive1.apps.googleusercontent.com'
			client_id: '402997664718-tisukq6joc3qb0mg33drljeqnc9ji97s.apps.googleusercontent.com'

			// For ssogsuite.brac.net
//			client_id: '629767295614-d04csknpl1317de1vrschf1lpkmprkjf.apps.googleusercontent.com'
		}).then(function(oauth2) {
			auth2 = oauth2;
			if(logout === "true") {
				console.log('User is logging out...');
				logOut(oauth2);
				return;
			}
			
			/*if(oauth2.isSignedIn.get()) {
				console.log('User is logged in...');
				oauth2.grantOfflineAccess({prompt : 'consent'}).then(signInCallback);
			}*/
		});
//		auth2 = gapi.auth2.getAuthInstance();
	});
}

$('#glogin').click(function() {
	auth2.grantOfflineAccess().then(signInCallback);
});
function signInCallback(authResult) {
	
	if (authResult['code']) {
		$("#emailForm input#gpassword").val(authResult['code']);
		
	    $('#glogin').attr('style', 'display: none');
	    $('#emailForm').submit();
	} else {
		$("#googleError").html("Error logging in.");
		$("#googleError").removeClass("d-none");
	}
}

function logOut(auth2) {
	auth2.disconnect().then(function() {
    	$('#glogin').attr('style', 'display: initial');
    });
}
