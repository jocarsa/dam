import subprocess

entrada = input("Dime un numero:")

resultado = subprocess.run(
            ['./controlador1.out', entrada],
            capture_output=True,
            text=True,
            check=True
        )

print(resultado.stdout.strip())