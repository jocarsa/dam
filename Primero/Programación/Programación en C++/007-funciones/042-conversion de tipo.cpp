# include <iostream>

std::string miFuncion(){
	return "Esta es mi función";
}

std::string saluda(std::string nombre,int edad){
	std::string edad_a_cadena = std::to_string(edad);
	return "Hola, "+nombre+" tienes "+edad_a_cadena+" años";
}

int main(){
	std::cout << "Yo soy la función principal" << std::endl;
	std::cout << miFuncion() << std::endl;
	std::cout << saluda("Jose Vicente",46) << std::endl;
	std::cout << saluda("Juan",47) << std::endl;
	return 0;
}
