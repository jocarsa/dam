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
    std::vector<std::string> values = split(input, ',');

    // Read the "modelo.txt" file
    std::ifstream model_file("modelo.txt");
    if (!model_file.is_open()) {
        std::cerr << "Failed to open modelo.txt" << std::endl;
        return 1;
    }

    std::string model_line;
    std::getline(model_file, model_line);
    model_file.close();

    // Split the model_line into column names
    std::vector<std::string> columns = split(model_line, ',');

    // Check if the number of columns matches the number of values
    if (columns.size() != values.size()) {
        std::cerr << "The number of columns in modelo.txt does not match the number of values provided." << std::endl;
        return 1;
    }

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

    // Write each column name and corresponding value to the file
    for (size_t i = 0; i < columns.size(); ++i) {
        file << columns[i] << ":" << values[i] << std::endl;
    }

    file.close();

    std::cout << "Data saved to " << filename << std::endl;
    return 0;
}
