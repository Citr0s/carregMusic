var errorArray = [];
var registerUserName = document.getElementById('registerUserName');
var email = document.getElementById('Email');
var nickName = document.getElementById('nickName');
var canSubmit = false;
var errorMessage = document.createElement("p");
errorMessage.setAttribute("class", "appendedError");
var formField = document.getElementsByTagName("tr");
var Password1 = document.getElementById("Password1");
var PasswordCheck = document.getElementById("PasswordCheck");

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
addListener(nickName, "blur", nickNameVal);

function userNameVal () {
    
   if (!Modernizr.inputtypes.email){
       
        if(registerUserName.value.length <= 2 || registerUserName.value.length >= 120)
        {
            canSubmit = false;
            registerUserName.setAttribute("class", "notValid");
            addErrorMessage(0);
        }
        else { 
            registerUserName.removeAttribute("class", "notValid");
            registerUserName.setAttribute("class", "isValid");
            removeErrorMessage(0);
            canSubmit = true;
        }
        
   }//end of html5support
}//end of valFirstName function

function nickNameVal () {
    
    if (!Modernizr.inputtypes.email){
       
        if(nickName.value.length <= 2 || nickName.value.length >= 120)
        {
            canSubmit = false;
            nickName.setAttribute("class", "notValid");
            addErrorMessage(1);
        }
        else { 
            nickName.removeAttribute("class", "notValid");
            nickName.setAttribute("class", "isValid");
            removeErrorMessage(1);
            canSubmit = true;
        }
        
    }//end of html5support
}//end of valFirstName function

function emailVal () {

    var emailCheck = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    
    if(!emailCheck.test(email.value)){
        email.setAttribute("class", "notValid");
        addErrorMessage(2);
        canSubmit = false;
    }
    
    else {
        email.removeAttribute("class", "notValid"); 
        email.setAttribute("class", "isValid"); 
        removeErrorMessage(2);
        canSubmit = true;
    }
    

}//end of valEmail function

function passwordVal () {
if (!Modernizr.inputtypes.email){ 

    if(Password1.value !== PasswordCheck.value || Password1.value.length <= 3 || Password1.value.length >= 120){
        Password1.setAttribute("class", "notValid");
        PasswordCheck.setAttribute("class", "notValid");;
        addErrorMessage(3);
        canSubmit = false;  
    }
    
    else {
        Password1.removeAttribute("class", "isValid"); 
        PasswordCheck.removeAttribute("class", "isValid"); 
        Password1.setAttribute("class", "isValid");
        PasswordCheck.setAttribute("class", "isValid");
        removeErrorMessage(3);
        canSubmit = true;
    }

    }//end of html5support
}//end of passwordval function


function addErrorMessage (i){

            switch(i) {
                case 0: errorText="Must be between 3 and 122 characters."
                break;
                case 1: errorText="Must be between 3 and 122 characters."
                break;
                case 2: errorText="Must be a valid email."
                break;
                case 3: errorText="Passwords must match"
                break;
            }

            var newElement = document.createElement("p");
            newElement.setAttribute("class", "appendedError");
            newElement.setAttribute("id", "remove" + [i]);
            newElement.innerHTML=errorText;
            formField[i].appendChild(newElement);
}//need to know both child and parent element to remove, that why id is created above with element.

function removeErrorMessage (i){
    if(document.getElementById("remove" + [i])!=null){
    var child = document.getElementById("remove" + [i]);
    var parent = formField[i];
    parent.removeChild(child);
    }
}