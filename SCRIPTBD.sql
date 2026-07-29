-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema MYMS
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema MYMS
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `MYMS` DEFAULT CHARACTER SET utf8 ;
USE `MYMS` ;

-- -----------------------------------------------------
-- Table `MYMS`.`Productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MYMS`.`Productos` (
  `Codigo` INT NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NULL DEFAULT NULL,
  `Descripcion` VARCHAR(45) NULL DEFAULT NULL,
  `Precio` VARCHAR(45) NULL DEFAULT NULL,
  `Stock` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`Codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MYMS`.`Usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MYMS`.`Usuarios` (
  `CI` INT NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NULL DEFAULT NULL,
  `Direccion` VARCHAR(45) NULL DEFAULT NULL,
  `Celular` VARCHAR(45) NULL DEFAULT NULL,
  `Rol` VARCHAR(45) NULL DEFAULT NULL,
  `Estado` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`CI`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MYMS`.`Pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MYMS`.`Pedidos` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NULL DEFAULT NULL,
  `Fecha` DATE NULL DEFAULT NULL,
  `Estado` VARCHAR(45) NULL DEFAULT NULL,
  `NombreVendedor` VARCHAR(45) NULL DEFAULT NULL,
  `telefono` INT NULL,
  `direccion` VARCHAR(45) NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MYMS`.`Carrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MYMS`.`Carrito` (
  `Productos_Codigo` INT NOT NULL,
  `Pedidos_ID` INT NOT NULL,
  `Cantidad` INT NULL DEFAULT NULL,
  `CostoTotal` INT NULL DEFAULT NULL,
  PRIMARY KEY (`Productos_Codigo`, `Pedidos_ID`),
  INDEX `fk_Productos_has_Pedidos_Pedidos1_idx` (`Pedidos_ID` ASC)  ,
  INDEX `fk_Productos_has_Pedidos_Productos1_idx` (`Productos_Codigo` ASC)  ,
  CONSTRAINT `fk_Productos_has_Pedidos_Productos1`
    FOREIGN KEY (`Productos_Codigo`)
    REFERENCES `MYMS`.`Productos` (`Codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Productos_has_Pedidos_Pedidos1`
    FOREIGN KEY (`Pedidos_ID`)
    REFERENCES `MYMS`.`Pedidos` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MYMS`.`Ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MYMS`.`Ventas` (
  `Pedidos_ID` INT NOT NULL,
  `Costototal` INT NULL,
  `Estado` VARCHAR(45) NULL,
  `Metodo` VARCHAR(45) NULL,
  INDEX `fk_Ventas_Pedidos1_idx` (`Pedidos_ID` ASC)  ,
  PRIMARY KEY (`Pedidos_ID`),
  CONSTRAINT `fk_Ventas_Pedidos1`
    FOREIGN KEY (`Pedidos_ID`)
    REFERENCES `MYMS`.`Pedidos` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
