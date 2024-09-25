import mysql.connector                              # Importo la librería de Flask
from flask import Flask                             # Importo la librería que me permite crear un miniservidor web
from flask_cors import CORS                         # Importamos la librería dde CORS para que nos deje conectarnos desde HTML
# pip install flask-cors - pip3 install flask-cors

aplicacion = Flask(__name__)                        # Creo el servidor web
CORS(aplicacion)                                    # Permito que a esta aplicacion se puedan conectar personas desde un navegador externo

servidor = "localhost"                              # Creo una variable en la que apunto a mi servidor
usuario = "miempresa"                               # Creo una variable para definir el usuario
contrasena = "miempresa"                            # Creo una variable para definir la contraseña del usuario
base_de_datos = "miempresa"                         # Creo una variable para definiar la base de datos a la que me conecto

conexion = mysql.connector.connect(
    host=servidor,      
    database=base_de_datos,  
    user=usuario,  
    password=contrasena  
)                                                   # Establezco una conexión con la base de datos con los datos seleccionados

@aplicacion.route('/')                              # Creo un escuchador para que esté pendiente de cuando alguien entre en la raiz
def inicio():                                       # Defino una funcion - se puede llamar como yo quiera
    peticion = "SELECT * FROM clientes;"            # Preparo una petición

    cursor = conexion.cursor()                      # Una petición en Python requiere un cursor

    cursor.execute(peticion)                        # En el cursor, ejecuto la petición que he dejado preparada arriba
    filas = cursor.fetchall()                       # En una variable llamadas filas, almaceno los resultados que me da la base de datos
    contenido = []                                  # Creo una lista vacía donde pondré a los clientes
    for fila in filas:                              # Como filas representa a todas las filas, yo quiero coger una a una
        contenido.append(fila)                      # Utilizando el comando append añado cada uno de los elementos a la lista
    return contenido                                # Lanzo el contenido al navegador web          

aplicacion.run(debug=True)                          # Arranco el servidor


