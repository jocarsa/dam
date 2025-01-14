# include <iostream>

int main(){
	int edad = 36;
	if(edad < 10 ){
		std::cout << "Eres un niño"  << std::endl;
	}else if(edad >= 10 && edad < 20){
		std::cout << "Eres un adolescente"  << std::endl;
	}else if(edad >= 20 && edad < 30){
		std::cout << "Eres un joven"  << std::endl;
	}else{
		std::cout << "Ya no eres un joven"  << std::endl;
	}
	
	return 0;
}
