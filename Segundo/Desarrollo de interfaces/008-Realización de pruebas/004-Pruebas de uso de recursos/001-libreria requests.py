import requests

# Make a GET request to a sample URL
url = "https://crimson.jocarsa.com/cliente"
response = requests.get(url)

# Print all the data from the response
print("Status Code:", response.status_code)
print("Headers:", response.headers)
print("Content (text):", response.text)
print("Content (binary):", response.content)
try:
    print("JSON Data:", response.json())
except ValueError:
    print("No JSON Data")
print("Cookies:", response.cookies)
print("Final URL:", response.url)
print("Elapsed Time:", response.elapsed)
print("Redirect History:", response.history)
