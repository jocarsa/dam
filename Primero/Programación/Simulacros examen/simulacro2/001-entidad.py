import mysql.connector                  

conexion = mysql.connector.connect(
    host="localhost",           
    user="examenprogramacion",        
    password="examenprogramacion",   
    database="examenprogramacion"    
)

cursor = conexion.cursor(dictionary = True)

peticion = "SELECT * FROM capitulos"

cursor.execute(peticion)

filas = cursor.fetchall()

print(filas)
