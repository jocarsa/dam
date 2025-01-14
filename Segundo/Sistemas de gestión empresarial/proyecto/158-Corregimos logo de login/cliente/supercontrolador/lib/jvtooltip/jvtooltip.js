let jvtooltip = document.createElement("div")
jvtooltip.classList.add("jvtooltip")

document.querySelector("body").appendChild(jvtooltip)

document.onmousemove = function(e){

	jvtooltip.style.left = e.pageX+"px"
	jvtooltip.style.top = e.pageY+"px"
}

document.onmouseover = function(event) {
    const element = event.target;
    if(element.hasAttribute("jvtooltip") != ""){
    	//console.log("aqui!!!")
    	jvtooltip.style.display = "block"
    	jvtooltip.textContent = element.getAttribute("jvtooltip")
    }else{
    	jvtooltip.style.display = "none"
    }
}
