var errorArray = [];
var userName = document.getElementById('userName');

function addListener (object, event, functio) 
{
    if (object.addEventListener) {
        object.addEventListener(event, functio);
    }
    
    else { object.attachEvent("on" + event + functio);}   
}

addListener(registerUserName, "blur", userNameVal);

function userNameVal () {
    
    //if (!isHTML5Supported()){
            var isNameValid = false;
        if(registerUserName.value.length == 0)
        {
            isNameValid = false;
            registerUserName.setAttribute("class", "notValid");
        }
        else { 
            registerUserName.removeAttribute("class", "notValid");
            registerUserName.setAttribute("class", "isValid");
            isNameValid = true; 
        }
            
            return isNameValid;
        
    //}//end of html5support
}//end of valFirstName function