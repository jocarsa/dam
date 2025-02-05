import tkinter as tk
import subprocess

def procesaCampos():
    valores = []
    for entrada in entradas:
        valores.append(entrada.get())
    resultado = ",".join(valores)
    print("Valores concatenados:", resultado)
    subprocess.run(
            ['./controlador3.out', resultado],
            capture_output=True,
            text=True,
            check=True
        )

ventana = tk.Tk()

archivo = open("modelo.txt",'r')
linea = archivo.readline()
campos = linea.split(",")
archivo.close()

entradas = []

for campo in campos:
    tk.Label(ventana,text="Introduce un nuevo valor para "+campo+": ").pack(padx=10,pady=10)
    entrada = tk.Entry(ventana)
    entrada.pack(padx=10, pady=5)
    entradas.append(entrada)

tk.Button(ventana,text="Procesa",command=procesaCampos).pack(padx=10, pady=5)
ventana.mainloop()


