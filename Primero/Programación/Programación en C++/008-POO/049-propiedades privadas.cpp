# include <iostream>

class Persona{
	private:
		int edad = 0;
		std::string nombre = "";
};

int main(){
	Persona* persona1 = new Persona();
	std::cout << persona1->edad << std::endl;
	persona1->edad++;
	std::cout << persona1->edad << std::endl;
	return 0;
}
