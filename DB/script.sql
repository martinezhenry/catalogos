SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Table `flyer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flyer` ;

CREATE  TABLE IF NOT EXISTS `flyer` (
  `idflyer` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NULL ,
  `created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `modificated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `background_img` BLOB NULL ,
  `description` VARCHAR(100) NULL ,
  PRIMARY KEY (`idflyer`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `productFlyer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `productFlyer` ;

CREATE  TABLE IF NOT EXISTS `productFlyer` (
  `idproductFlyer` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NULL ,
  `no_part` VARCHAR(45) NULL ,
  `alias` VARCHAR(45) NULL ,
  `xref` VARCHAR(45) NULL ,
  `smp` VARCHAR(45) NULL ,
  `tomco` VARCHAR(45) NULL ,
  `oem` VARCHAR(45) NULL ,
  `price_name_one` VARCHAR(45) NULL ,
  `price_name_two` VARCHAR(45) NULL ,
  `price_name_three` VARCHAR(45) NULL ,
  `price_one` FLOAT NULL ,
  `price_two` FLOAT NULL ,
  `price_three` FLOAT NULL ,
  `image` BLOB NULL ,
  `flyer_idflyer` INT NOT NULL ,
  PRIMARY KEY (`idproductFlyer`) ,
  INDEX `fk_productFlyer_flyer_idx` (`flyer_idflyer` ASC) ,
  CONSTRAINT `fk_productFlyer_flyer`
    FOREIGN KEY (`flyer_idflyer` )
    REFERENCES `flyer` (`idflyer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
