# Actividad Evaluable 2 IAW
## 2025 - ASIR

Esta aplicación permite gestionar tareas, asignarles un usuario responsable y una fecha de ejecución.
El usuario administrador debe ser creado al finalizar la carga de la DB
Iniciada la sesión como administrador, se deben crear los usuarios, estos no se pueden crear desde ninguna sección
Los usuario podran crear, modificar y eliminar las tareas, asignar o desasignar las mismas a otros usuarios, pero nunca perderán el estatus de dueño de la tarea

Creación del usuario Administrador // PASS pvvU1Pnj5OBTeFJXHsr5aT4sdJ6
INSERT INTO users (id_user, password, email, user_created) VALUES ('administrador','$2y$10$VxcK1a18uiINpErfQCgx5eqm6MiSYb.pjD1R0N74sZskZ11qNQ51W','administrador@ferarg.com','1970-01-01 00:00:00');
