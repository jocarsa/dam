from flask import Flask

aplicacion = Flask(__name__)

@aplicacion.route('/')
def inicio():
    entradas = []
    entradas.append({
        "titulo":"Mi primera entrada",
        "fecha":"2024-09-26",
        "contenido":"Este es el contenido de mi primera entrada"
    })
    return entradas

if __name__ == '__main__':
    aplicacion.run()