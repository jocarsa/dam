# include <iostream>

int main(){
	
	int edad = 46;
	std::cout << edad << std::endl;
	std::cout << &edad << std::endl;
	
	int* puntero = &edad;
	
	std::cout << puntero << std::endl;
	return 0;
}
