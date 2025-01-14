# include <iostream>

int main(){
	int diadelasemana = 1;
	switch(diadelasemana){
		case 1:
			std::cout << "hoy es el peor día de la semana" << std::endl;
			break;
		case 2:
			std::cout << "hoy es el segundo peor día de la semana" << std::endl;
			break;
		case 3:
			std::cout << "Ya estamos a mitad de semana" << std::endl;
			break;
		case 4:
			std::cout << "Mañana ya es viernes" << std::endl;
			break;
		case 5:
			std::cout << "Por fin es viernes" << std::endl;
			break;
		case 6:
			std::cout << "hoy es el mejor día de la semana" << std::endl;
			break;
		case 7:
			std::cout << "Parece mentira que mañana ya sea lunes" << std::endl;
			break;
	}
	
	return 0;
}
