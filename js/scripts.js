var errorArray = [];
var userName = document.getElementById('userName');
var email = document.getElementById('Email');
var canSubmit = false;

function addListener (object, event, functio) 
{
    if (object.addEventListener) {
        object.addEventListener(event, functio);
    }
    
    else { object.attachEvent("on" + event + functio);}   
}

addListener(registerUserName, "blur", userNameVal);
addListener(email, "blur", emailVal);
addListener(Password1, "blur", passwordVal);
addListener(PasswordCheck, "blur", passwordVal);

function userNameVal () {
    
    //if (!isHTML5Supported()){
       
        if(registerUserName.value.length == 0)
        {
            canSubmit = false;
            registerUserName.setAttribute("class", "notValid");
        }
        else { 
            registerUserName.removeAttribute("class", "notValid");
            registerUserName.setAttribute("class", "isValid");
            canSubmit = true;
        }
            
            return isNameValid;
        
    //}//end of html5support
}//end of valFirstName function

function emailVal () {
 //if(!isHTML5Support()){   
    var emailCheck = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    
    if(!emailCheck.test(email.value)){
        email.setAttribute("class", "notValid");
        canSubmit = false;
    }
    
    else {
        email.removeAttribute("class", "notValid"); 
        email.setAttribute("class", "isValid"); 
        canSubmit = true;
    }
    
    //}//end of html5support
}//end of valEmail function

function passwordVal () {
 //if(!isHTML5Support()){   
    
    if(Password1.value !== PasswordCheck.value){
        Password1.setAttribute("class", "notValid");
        PasswordCheck.setAttribute("class", "notValid");;
        canSubmit = false;  
    }
    
    else {
        Password1.removeAttribute("class", "isValid"); 
        PasswordCheck.removeAttribute("class", "isValid"); 
        Password1.setAttribute("class", "isValid");
        PasswordCheck.setAttribute("class", "isValid");
        canSubmit = true;
    }

    //}//end of html5support
}//end of valEmail function

