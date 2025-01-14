# include <iostream>

class Persona{
	private:
		int edad = 0;
		std::string nombre = "";
		
	public:
		int getEdad(){
			return edad;
		}
};

int main(){
	Persona* persona1 = new Persona();
	std::cout << persona1->getEdad() << std::endl;

	return 0;
}
