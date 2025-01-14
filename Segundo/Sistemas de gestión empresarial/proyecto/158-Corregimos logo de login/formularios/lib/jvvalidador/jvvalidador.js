const entradas = document.querySelectorAll('input');
			const validadores = Array.from(entradas).filter(input => input.getAttribute('jvvalidador') !== null);
			validadores.forEach(function(validador){
				validador.onblur = function(){
					switch(this.getAttribute("jvvalidador")){
						case "dni":
							validar(/^[0-9]{8}[A-Z]$/,this,this.value);
							break;
						case "iban":
							validar(/^ES\d{22}$/,this,this.value);
							break;
						case "cp":
							validar(/^\d{5}$/,this,this.value);
							break;
						case "tarjetacredito":
							validar(/^\d{13,19}$/,this,this.value);
							break;
					}
				}
			});
			function validar(miregex,elemento,valor){
				const regex = miregex;
				if(regex.test(valor)){
					elemento.classList.remove("ko");
					elemento.classList.add("ok");
				}else{
					elemento.classList.remove("ok");
					elemento.classList.add("ko");
				}
			};
