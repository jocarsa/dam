from ClaseCliente import *
import pickle

agenda = []                                                                     # Creo una agenda que de momento esta vacia

def insertar():                                                          # En el caso de que el usuario haya escogido la opcion 1
    print("Vamos a insertar un nuevo cliente")                              # Le digo que vamos a insertar un cliente
    
    nombre = input("Introduce el nuevo nombre:")                            # Atrapo los datos que me proporciona el usuario
    apellidos = input("Introduce los nuevos apellidos:")
    email = input("Introduce el nuevo email:")
    direccion = input("Introduce la nueva direccion:")
    nuevocliente = Cliente(nombre,apellidos,email,direccion)                # Creo una nueva instancia de la clase Cliente
    agenda.append(nuevocliente)                                             # La anexo a la agenda

def listar():                                                         # En el caso de que el usuario haya escogido la opcion 2
    for cliente in agenda:                                                  # PAra cada uno de los clientes de la agenda
        print("-----------------------")                                    # Imprimo cada uno de los clientes pero en formato bonito
        print("nombre:",cliente.nombre)
        print("apellidos:",cliente.apellidos)
        print("email:",cliente.email)
        print("direccion:",cliente.direccion)
            
def guardar():                                                          # En el caso de que el usuario elija la opcion 3
        
    archivo = open("agenda.bin",'wb')                                       # Abro un archivo binario en modo escritura binaria
    pickle.dump(agenda,archivo)                                             # Vierto el contenido de la agenda en el interior de ese archivo
    print("La agenda ha sido guardada en un archivo")                       # Imprimo un mensaje de aviso
    archivo.close()                                                         # Cierro el archivo
        
def abrir():                                                          # En el caso de que el usuario elija la opcion 4
        
    archivo = open("agenda.bin",'rb')                                       # Abro un archivo binario en modo de lectura binaria
    agenda = pickle.load(archivo)                                           # En la agenda vierto de vuelta el contenido del archivo del disco duro
    archivo.close()                                                         # Cierro el archivo
        
        







        
