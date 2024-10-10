import mysql.connector

connection = mysql.connector.connect(
    host='localhost',   
    user='miempresa',   
    password='miempresa',
    database='miempresa' 
)

cursor = connection.cursor(dictionary = True)

while True:
    print("Programa de gestión de clientes")
    print("1.-Insertar un cliente")
    print("2.-Listado de clientes")
    print("3.-...")
    opcion = input("Selecciona una opcion:")
    print("La opción que has escogido es:"+opcion)

    if opcion == "1":
        print("Vamos a insertar un cliente")
        cursor.execute("SHOW COLUMNS IN clientes")                                      # En primer lugar quiero un informe de qué columnas tiene esta tabla
        filas = cursor.fetchall()                                                       # Las meto en una lista
        for fila in filas:                                                              # Para cada una de las columnas
            if fila['Key'] != "PRI":                                                    # Me salto la columna que sea clave primaria
                input("Introduce el valor para el campo "+fila['Field']+":")            # Permito al usuario introducir un nuevo valor

            
        
    elif opcion == "2":
        print("Vamos a listar los clientes")
