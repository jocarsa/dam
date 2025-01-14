# include <iostream>

int main(){

	std::cout << (4 == 4 && 3 == 3 && 2 == 2) <<  std::endl;
	std::cout << (4 == 4 && 3 == 3 && 2 == 1) <<  std::endl;
	
	std::cout << (4 == 4 || 3 == 3 || 2 == 2) <<  std::endl;
	std::cout << (4 == 4 || 3 == 3 || 2 == 1) <<  std::endl;
	std::cout << (4 == 4 || 3 == 2 || 2 == 1) <<  std::endl;
	std::cout << (4 == 3 || 3 == 2 || 2 == 1) <<  std::endl;

	return 0;
}
