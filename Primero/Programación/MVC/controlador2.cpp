#include <iostream>
#include <fstream>
#include <sstream>
#include <vector>
#include <ctime>

// Function to split a string by a delimiter
std::vector<std::string> split(const std::string& str, char delimiter) {
    std::vector<std::string> tokens;
    std::stringstream ss(str);
    std::string item;
    while (std::getline(ss, item, delimiter)) {
        tokens.push_back(item);
    }
    return tokens;
}

int main(int argc, char* argv[]) {
    if (argc < 2) {
        std::cerr << "Usage: " << argv[0] << " <comma-separated-list>" << std::endl;
        return 1;
    }

    // Get the input string from argv[1]
    std::string input = argv[1];

    // Split the input string by commas
    std::vector<std::string> elements = split(input, ',');

    // Get the current epoch time
    std::time_t epoch_time = std::time(nullptr);

    // Create the filename using epoch time
    std::string filename = std::to_string(epoch_time) + ".txt";

    // Open a file to write the elements
    std::ofstream file(filename);
    if (!file.is_open()) {
        std::cerr << "Failed to open file " << filename << std::endl;
        return 1;
    }

    // Write each element to the file on a new line
    for (const std::string& element : elements) {
        file << element << std::endl;
    }

    file.close();

    std::cout << "Elements saved to " << filename << std::endl;
    return 0;
}