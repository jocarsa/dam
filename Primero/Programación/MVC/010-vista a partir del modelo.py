import tkinter as tk

ventana = tk.Tk()

archivo = open("modelo.txt",'r')
linea = archivo.readline()
campos = linea.split(",")

for campo in campos:
    tk.Label(ventana,text="Introduce un nuevo valor para "+campo+": ").pack(padx=10,pady=10)
    tk.Entry(ventana).pack(padx=10,pady=10)

ventana.mainloop()


