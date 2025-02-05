import tkinter as tk

ventana = tk.Tk()                   # Creo una ventana

tk.Button(
    ventana,
    text="Pulsame"
    ).pack(
        padx=50,
        pady=50
    )                               # Creo un botón

ventana.mainloop()                  # Atrapo la ejecución