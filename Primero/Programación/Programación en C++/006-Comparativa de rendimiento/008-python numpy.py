import time
import numpy as np

start = time.time()

# Define the base number and the multiplier
numero = 1.00000000435
multiplier = 1.0000000000054
iterations = 1000000000

# Use NumPy's power function for efficient computation
numero = numero * np.power(multiplier, iterations)

end = time.time()
duration = end - start

print(numero)
print(f"Tiempo transcurrido: {duration} segundos")
