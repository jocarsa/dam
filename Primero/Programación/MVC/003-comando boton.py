import tkinter as tk

def pulsaBoton():
    print("Has pulsado el boton")

ventana = tk.Tk()                           # Creo una ventana

tk.Button(
    ventana,
    text="Pulsame",
    command = pulsaBoton
    ).pack(
        padx=50,
        pady=50
    )                                       # Creo un botón

ventana.mainloop()                          # Atrapo la ejecución