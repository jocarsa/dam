import os

api_key = os.getenv("OPENAI_API_KEY")
if api_key:
    print("✅ API key detected!")
else:
    print("❌ API key NOT found. Try setting it again.")
