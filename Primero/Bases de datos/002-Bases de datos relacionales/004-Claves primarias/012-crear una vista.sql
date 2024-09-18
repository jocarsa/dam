CREATE VIEW empleadosydirecciones AS
SELECT 
	empleados.nombre,
    empleados.apellidos,
    direcciones.calle,
    direcciones.codigopostal
FROM
empleados
LEFT JOIN direcciones
ON direcciones.empleados_nombre = empleados.Identificador;
