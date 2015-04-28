var threeLineButton = document.getElementById("threeLineButton");

var container = document.getElementById("container");



threeLineButton.addEventListener("click", menuButtonClicked, false);
menuCloseButton.addEventListener("click", menuButtonClicked, false);

function menuButtonClicked(e){
    e.preventDefault(); //this stops an event that could occur, in this case the link from being used
    console.log("working here")
    
    if(container.classList.contains("openMenu")){
       container.classList.remove("openMenu");
          console.log("if");
    }

    else {
        container.classList.add("openMenu");
        console.log("else");
    }

}