# include <iostream>

int main(){
	
	int edad = 46;
	std::cout << edad << std::endl;
	std::cout << &edad << std::endl;
	
	int* puntero = &edad;
	
	std::cout << puntero << std::endl;
	std::cout << "valor del puntero: " << *puntero << std::endl; 
	return 0;
}
