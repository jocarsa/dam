# include <iostream>

int main(){
	long double numero = 1.00000000435;
	for(int i = 0;i<1000000000;i++){
		numero *= 1.0000000000054;
	}
	std::cout << numero << std::endl;
	
	return 0;
}
