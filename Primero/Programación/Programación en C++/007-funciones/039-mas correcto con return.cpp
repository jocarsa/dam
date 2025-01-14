# include <iostream>

std::string miFuncion(){
	return "Esta es mi función";
}

int main(){
	std::cout << "Yo soy la función principal" << std::endl;
	std::cout << miFuncion() << std::endl;
	return 0;
}
