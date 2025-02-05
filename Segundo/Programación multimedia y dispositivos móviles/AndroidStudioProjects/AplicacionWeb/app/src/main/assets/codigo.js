let a = document.querySelector("#a")
let b = document.querySelector("#b")

a.onclick = function(){
    revela("a")
}
b.onclick = function(){
    revela("b")
}

function revela(identificador){
console.log("#"+identificador+" .estadisticas")
    document.querySelector("#a .estadisticas").style.display = "block"
    document.querySelector("#b .estadisticas").style.display = "block"
    fetch("https://jocarsa.com/go/pruebaclaseaob/dame.php?opcion="+identificador)
    .then(function(result){
        return result.json()
    })
    .then(function(datos){
        console.log(datos)
        document.querySelector("#a .estadisticas").textContent = datos.a+"%"
        document.querySelector("#b .estadisticas").textContent = datos.b+"%"
    })
   }