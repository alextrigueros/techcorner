/* Script per crear la base de dades*/

CREATE DATABASE IF NOT EXISTS techcorner_db;
USE techcorner_db;

/* Taules i atributs */
CREATE TABLE IF NOT EXISTS USUARIS (
    usuari_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    cognoms VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    contrasenya VARCHAR(255),
    rol ENUM('usuari', 'admin') DEFAULT 'usuari',
    data_registre TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS CATEGORIES (
    categoria_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    descripcio TEXT
);

INSERT IGNORE INTO CATEGORIES (categoria_id, nom, descripcio) 
VALUES (1, 'Sense categoria', 'Categoria per defecte per a productes sense categoria assignada');

CREATE TABLE IF NOT EXISTS PRODUCTES (
    producte_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    marca VARCHAR(50),
    descripcio TEXT,
    preu DECIMAL(10, 2),
    stock INT,
    imatge_url VARCHAR(255),
    categoria_id INT
);

CREATE TABLE IF NOT EXISTS CARRETS (
    carret_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    data_actualitzacio TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    usuari_id INT UNIQUE
);

CREATE TABLE IF NOT EXISTS COMANDES (
    comanda_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    data_comanda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2),
    estat ENUM('pendent', 'pagat', 'enviat', 'lliurat') DEFAULT 'pendent',
    usuari_id INT
);

CREATE TABLE IF NOT EXISTS DETALL_CARRETS (
    detall_carret_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quantitat INT,
    carret_id INT,
    producte_id INT
);

CREATE TABLE IF NOT EXISTS DETALL_COMANDES (
    detall_comanda_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quantitat INT,
    preu_unitari DECIMAL(10, 2),
    comanda_id INT,
    producte_id INT
);

/* Claus foranes */

ALTER TABLE PRODUCTES
ADD CONSTRAINT fk_producte_categoria
FOREIGN KEY (categoria_id) REFERENCES CATEGORIES(categoria_id)
ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE CARRETS
ADD CONSTRAINT fk_carret_usuari
FOREIGN KEY (usuari_id) REFERENCES USUARIS(usuari_id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE COMANDES
ADD CONSTRAINT fk_comanda_usuari
FOREIGN KEY (usuari_id) REFERENCES USUARIS(usuari_id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE DETALL_CARRETS
ADD CONSTRAINT fk_detall_carret_id
FOREIGN KEY (carret_id) REFERENCES CARRETS(carret_id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE DETALL_CARRETS
ADD CONSTRAINT fk_detall_carret_producte
FOREIGN KEY (producte_id) REFERENCES PRODUCTES(producte_id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE DETALL_COMANDES
ADD CONSTRAINT fk_detall_comanda_id
FOREIGN KEY (comanda_id) REFERENCES COMANDES(comanda_id)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE DETALL_COMANDES
ADD CONSTRAINT fk_detall_comanda_producte
FOREIGN KEY (producte_id) REFERENCES PRODUCTES(producte_id)
ON DELETE CASCADE ON UPDATE CASCADE;

/*Trigger per actualitzar l'stock d'un producte quan s'afegeix a una comanda*/

DELIMITER //

CREATE TRIGGER actualitzar_stock
AFTER INSERT ON DETALL_COMANDES
FOR EACH ROW
BEGIN
    UPDATE PRODUCTES 
    SET stock = stock - NEW.quantitat /*Quantitat de la comanda*/
    WHERE producte_id = NEW.producte_id; /*ID del producte de la comanda*/
END;
//

CREATE TRIGGER gestio_borrat_categories
BEFORE DELETE ON CATEGORIES
FOR EACH ROW
BEGIN
    /*Evitar esborrar la categoria amb ID 1*/
    IF OLD.categoria_id = 1 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: No es pot eliminar la categoria per defecte (ID 1)';
    END IF;

    /*Assignem la categoria per defecte a els productes que tenen la categoria a eliminar*/
    UPDATE PRODUCTES 
    SET categoria_id = 1 
    WHERE categoria_id = OLD.categoria_id;
END;
//

DELIMITER ;

