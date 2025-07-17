function Changeco(){
	const currentURL = window.location.href;
	let log = document.getElementById("log");
	let cad2 = document.getElementById("cad2");
	let obras = document.getElementById("obras");
	let categ = document.getElementById("categ");
	let salv = document.getElementById("salv");
	let perfil = document.getElementById("perfil");
	let data = document.getElementById("datalink");
	if(currentURL.includes("index") && log){
		log.style.color = "rgb(0, 0, 0)";
	}
	if(currentURL.includes("obras"||"data") && obras || data){
		obras.style.color = "rgb(0, 0, 0)";
	}
	if(currentURL.includes("categorias") && categ){
		categ.style.color = "rgb(0, 0, 0)";
	}
	if(currentURL.includes("salvo") && salv){
		salv.style.color = "rgb(0, 0, 0)";
	}
	if(currentURL.includes("perfil" || "perfilEdit") && perfil){
		perfil.style.color = "rgb(0, 0, 0)";
	}
}
// function eggfunc() {
//   const img = document.createElement("img");
// img.src = "/img/zoioarabe.jfif";
// img.style.width = "10vmin";
// img.style.height = "10vmin";
// img.style.borderRadius = "10vmin";
// img.style.position = "absolute";
// img.style.top = "58%";
// img.style.left = "22%";
// document.querySelector(".background").appendChild(img);
// }
document.addEventListener("DOMContentLoaded", Changeco);

