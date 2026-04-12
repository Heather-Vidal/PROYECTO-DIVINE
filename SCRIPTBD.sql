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
-- Table `DIVINE`.`PRODUCTO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DIVINE`.`PRODUCTO` (
  `codigo` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `cantidad` INT NULL,
  `precio` INT NULL,
  `costo` INT NULL,
  `categoria` VARCHAR(45) NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DIVINE`.`CLIENTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DIVINE`.`CLIENTE` (
  `dni` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `apellido` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `nacimiento` DATE NULL,
  `telefono` INT NULL,
  PRIMARY KEY (`dni`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
