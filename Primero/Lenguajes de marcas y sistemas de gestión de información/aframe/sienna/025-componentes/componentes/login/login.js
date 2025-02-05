
document.querySelector("#iniciarsesion").onclick = function(){
	document.querySelector("#login").style.display = "none";
	localStorage.setItem("siennausuario",document.querySelector("#usuario").value)
}

