-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema DIVINE
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema DIVINE
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `DIVINE` DEFAULT CHARACTER SET utf8 ;
USE `DIVINE` ;

-- -----------------------------------------------------
-- Table `DIVINE`.`CLIENTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DIVINE`.`CLIENTE` (
  `CI` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `celular` INT NULL,
  `rol` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`CI`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DIVINE`.`PRODUCTO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DIVINE`.`PRODUCTO` (
  `codigo` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `descripcion` VARCHAR(45) NULL,
  `precio` INT NULL,
  `costo` INT NULL,
  `stock` INT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DIVINE`.`PEDIDOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DIVINE`.`PEDIDOS` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  `fecha` DATE NULL,
  `estado` VARCHAR(45) NULL,
  `nombrevendedor` VARCHAR(45) NULL,
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DIVINE`.`CARRITO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DIVINE`.`CARRITO` (
  `PRODUCTO_codigo` INT NOT NULL,
  `PEDIDOS_ID` INT NOT NULL,
  `cantidad` INT NULL,
  `costototal` DOUBLE NULL,
  PRIMARY KEY (`PRODUCTO_codigo`, `PEDIDOS_ID`),
  INDEX `fk_PRODUCTO_has_PEDIDOS_PEDIDOS1_idx` (`PEDIDOS_ID` ASC) ,
  INDEX `fk_PRODUCTO_has_PEDIDOS_PRODUCTO_idx` (`PRODUCTO_codigo` ASC) ,
  CONSTRAINT `fk_PRODUCTO_has_PEDIDOS_PRODUCTO`
    FOREIGN KEY (`PRODUCTO_codigo`)
    REFERENCES `DIVINE`.`PRODUCTO` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRODUCTO_has_PEDIDOS_PEDIDOS1`
    FOREIGN KEY (`PEDIDOS_ID`)
    REFERENCES `DIVINE`.`PEDIDOS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
