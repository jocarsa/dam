# include <iostream>
#include <chrono>

int main(){

	auto start = std::chrono::high_resolution_clock::now();

	double numero = 1.00000000435;
	for(int i = 0;i<1000000000;i++){
		numero *= 1.0000000000054;
	}
	
	auto end = std::chrono::high_resolution_clock::now();
	std::chrono::duration<double> duration = end - start;
	
	std::cout << numero << std::endl;
	std::cout << "Tiempo transcurrido: " << duration.count() << " segundos" << std::endl;
	
	return 0;
}
