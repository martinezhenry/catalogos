SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Table `flayer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `flayer` ;

CREATE  TABLE IF NOT EXISTS `flayer` (
  `idflayer` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NULL ,
  `created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `modificated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `background_img` BLOB NULL ,
  `description` VARCHAR(100) NULL ,
  PRIMARY KEY (`idflayer`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `productFlayer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `productFlayer` ;

CREATE  TABLE IF NOT EXISTS `productFlayer` (
  `idproductFlayer` INT NOT NULL AUTO_INCREMENT ,
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
  `flayer_idflayer` INT NOT NULL ,
  PRIMARY KEY (`idproductFlayer`) ,
  INDEX `fk_productFlayer_flayer_idx` (`flayer_idflayer` ASC) ,
  CONSTRAINT `fk_productFlayer_flayer`
    FOREIGN KEY (`flayer_idflayer` )
    REFERENCES `flayer` (`idflayer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
