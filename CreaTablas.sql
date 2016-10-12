/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  passh
 * Created: 12-oct-2016
 */


USE  `lacuevad_prueba`;

 CREATE TABLE  entries 
(
    id  INT(255)  AUTO_INCREMENT not null,  
    id_user INT(255), 
    id_category INT(255), 
    title varchar(255),
    content varchar(255),
    status varchar(255),
    image varchar(255),
 CONSTRAINT pk_entries PRIMARY KEY (id),
    CONSTRAINT fk_entries_id_user FOREIGN KEY (id_user) REFERENCES user(id), 
    CONSTRAINT fk_entries_id_category FOREIGN KEY (id_category) REFERENCES category(id)
) ENGINE = InnoDB CHARACTER SET latin1 COLLATE latin1_spanish_ci;


CREATE TABLE  tags 
(
    id  INT NOT NULL AUTO_INCREMENT, 
    `name` varchar(255), 
    description varchar(255), 
 CONSTRAINT pk_tags PRIMARY KEY (id) 
) ENGINE = InnoDB CHARACTER SET latin1 COLLATE latin1_spanish_ci;



CREATE TABLE  users 
(
    id  INT(255) NOT NULL AUTO_INCREMENT, 
   `role` varchar(255), 
   `name` varchar(255), 
   surname varchar(255), 
   email varchar(255), 
   password varchar(255), 
   image varchar(255), 
 CONSTRAINT pk_users PRIMARY KEY (id)
) ENGINE = InnoDB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

CREATE TABLE  categories 
(
    id  INT NOT NULL AUTO_INCREMENT, 
    `name` varchar(255), 
    description varchar(255),
 CONSTRAINT pk_categories PRIMARY KEY (id) 
) ENGINE = InnoDB CHARACTER SET latin1 COLLATE latin1_spanish_ci;


CREATE TABLE entrytag 
( 
     `id` INT NOT NULL AUTO_INCREMENT ,
     `id_tag` INT NOT NULL ,
     `id_entry` INT NOT NULL ,
    CONSTRAINT pk_entrytag PRIMARY KEY (id), 
    CONSTRAINT fk_entrytag_id_tag FOREIGN KEY (id_tag) REFERENCES tags(id), 
    CONSTRAINT fk_entrytag_id_entry FOREIGN KEY (id_entry) REFERENCES entries(id)
) ENGINE = InnoDB CHARACTER SET latin1 COLLATE latin1_spanish_ci;
