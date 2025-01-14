# include <iostream>

class Persona{
	private:
		int edad = 0;
		std::string nombre = "";
		
	public:
		Persona(const std::string& nombre, int edad) 
		     : nombre(nombre), edad(edad) {
		     std::cout << "Constructor llamado: " << this->nombre << ", " << this->edad << " años.\n";
		 }
		int getEdad(){
			return edad;
		}
		bool setEdad(int nuevaedad){
			if(nuevaedad == edad + 1){
				edad = nuevaedad;
				return true;
			}else{
				return false;
			}
		}
};

int main(){
	Persona* persona1 = new Persona("Jose Vicente",46);
	std::cout << persona1->getEdad() << std::endl;
	if(persona1->setEdad(47)){
		std::cout << "La edad ha sido actualizada correctamente" << std::endl;
	}else{
		std::cout << "Operación no permitida" << std::endl;
	}
	std::cout << persona1->getEdad() << std::endl;

	return 0;
}
