#include <iostream>
#include <cstdlib> 

int main(int argc, char* argv[]) {
   
    int entrada = std::atoi(argv[1]);
    int doble = entrada * 2;
    std::cout << doble;
    return 0; 
}