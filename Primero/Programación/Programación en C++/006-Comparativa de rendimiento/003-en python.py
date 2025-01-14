import time

start = time.time()

numero = 1.00000000435
for i in range(1000000000):
    numero *= 1.0000000000054

end = time.time()
duration = end - start

print(numero)
print(f"Tiempo transcurrido: {duration} segundos")

