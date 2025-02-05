import subprocess
import tkinter as tk

def calculaNumero():
    resultado = subprocess.run(
            ['./controlador1.out', numero.get()],
            capture_output=True,
            text=True,
            check=True
        )                                               # Lanzo el paquete de información contra C++            
    resultadotexto = resultado.stdout.strip()           # Recojo el resultado que me da C++
    retroalimentacion.config(text=resultadotexto)       # Y lo pinto en la pantalla

ventana = tk.Tk()

numero = tk.StringVar()

tk.Entry(ventana,textvariable=numero).pack(padx=10,pady=10)
tk.Button(ventana,text="Vamos a por ello",command=calculaNumero).pack(padx=10,pady=10)
retroalimentacion = tk.Label(ventana,text="?")
retroalimentacion.pack(padx=10,pady=10)

ventana.mainloop()


