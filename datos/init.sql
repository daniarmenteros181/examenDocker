CREATE DATABASE IF NOT EXISTS cesta;

 USE cesta;

CREATE TABLE IF NOT EXISTS regalo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    cesta  VARCHAR(255) NOT NULL
);

INSERT INTO regalo (nombre, correo, cesta) VALUES
    ('manolo', 'jve@ieslasfuentezuelas.com', 'sin'),
    ('dani', 'daniarmenteros18@gmail.com', 'con'); 
