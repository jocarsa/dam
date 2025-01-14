import requests

for _ in range(0,500):
    # Make a GET request to a sample URL
    url = "https://crimson.jocarsa.com/cliente"
    response = requests.get(url)

    # Print all the data from the response
    print("Status Code:", response.status_code)
    print("Headers:", response.headers)
    print("Elapsed Time:", response.elapsed)
