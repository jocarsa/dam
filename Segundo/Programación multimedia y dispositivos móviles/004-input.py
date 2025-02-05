import openai
import os
from dotenv import load_dotenv

# Load environment variables from .env file
load_dotenv()

# Retrieve the API key
api_key = os.getenv("OPENAI_API_KEY")
if not api_key:
    raise ValueError("API key not found. Set it in the .env file.")

# Initialize the OpenAI client
client = openai.OpenAI(api_key=api_key)
while True:
    entrada = input("Dime tu pregunta:")

    # Make a request using the new API structure
    response = client.chat.completions.create(
        model="gpt-4",
        messages=[{"role": "user", "content": entrada}]
    )

    # Print the assistant's response
    print(response.choices[0].message.content)
