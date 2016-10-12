/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  passh
 * Created: 12-oct-2016
 */

CREATE TABLE `lacuevad_prueba`.`ENTRYTAG` 
( 
    `id` INT NOT NULL AUTO_INCREMENT ,
     `id_tag` INT NOT NULL , `id_entry` INT NOT NULL ,
     PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

