# include <iostream>

std::string miFuncion(){
	return "Esta es mi función";
}

std::string saluda(std::string nombre){
	return "Hola, "+nombre;
}

int main(){
	std::cout << "Yo soy la función principal" << std::endl;
	std::cout << miFuncion() << std::endl;
	std::cout << saluda("Jose Vicente") << std::endl;
	std::cout << saluda("Juan") << std::endl;
	return 0;
}
