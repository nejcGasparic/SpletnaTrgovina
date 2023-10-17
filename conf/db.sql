-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema spletna_trgovina
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `spletna_trgovina` ;

-- -----------------------------------------------------
-- Schema spletna_trgovina
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `spletna_trgovina` DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci ;
USE `spletna_trgovina` ;

-- -----------------------------------------------------
-- Table `spletna_trgovina`.`Vloga`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `spletna_trgovina`.`Vloga` ;

CREATE TABLE IF NOT EXISTS `spletna_trgovina`.`Vloga` (
  `id_vloge` INT NOT NULL AUTO_INCREMENT,
  `naziv_vloge` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_vloge`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `spletna_trgovina`.`Uporabnik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `spletna_trgovina`.`Uporabnik` ;

CREATE TABLE IF NOT EXISTS `spletna_trgovina`.`Uporabnik` (
  `id_uporabnika` INT NOT NULL AUTO_INCREMENT,
  `ime_uporabnika` VARCHAR(45) NOT NULL,
  `priimek_uporabnika` VARCHAR(45) NOT NULL,
  `elektronski_naslov` VARCHAR(45) NOT NULL,
  `geslo` VARCHAR(255) NOT NULL,
  `Vloga_id_vloge` INT NOT NULL,
  `aktiven` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_uporabnika`),
  UNIQUE INDEX `elektronski_naslov_UNIQUE` (`elektronski_naslov` ASC) VISIBLE,
  INDEX `fk_Uporabnik_Vloga_idx` (`Vloga_id_vloge` ASC) VISIBLE,
  CONSTRAINT `fk_Uporabnik_Vloga`
    FOREIGN KEY (`Vloga_id_vloge`)
    REFERENCES `spletna_trgovina`.`Vloga` (`id_vloge`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `spletna_trgovina`.`Artikel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `spletna_trgovina`.`Artikel` ;

CREATE TABLE IF NOT EXISTS `spletna_trgovina`.`Artikel` (
  `id_artikla` INT NOT NULL AUTO_INCREMENT,
  `naziv_artikla` VARCHAR(45) NOT NULL,
  `cena_artikla` FLOAT NOT NULL,
  `aktiven` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_artikla`),
  UNIQUE INDEX `naziv_artikla_UNIQUE` (`naziv_artikla` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `spletna_trgovina`.`Status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `spletna_trgovina`.`Status` ;

CREATE TABLE IF NOT EXISTS `spletna_trgovina`.`Status` (
  `id_statusa` INT NOT NULL AUTO_INCREMENT,
  `naziv_statusa` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_statusa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `spletna_trgovina`.`Artikel_Ocena`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `spletna_trgovina`.`Artikel_Ocena` ;

CREATE TABLE IF NOT EXISTS `spletna_trgovina`.`Artikel_Ocena` (
  `Artikel_id_artikla` INT NOT NULL,
  `Uporabnik_id_uporabnika` INT NOT NULL,
  `ocena` INT NOT NULL,
  PRIMARY KEY (`Artikel_id_artikla`, `Uporabnik_id_uporabnika`),
  INDEX `fk_Artikel_has_Uporabnik_Uporabnik1_idx` (`Uporabnik_id_uporabnika` ASC) VISIBLE,
  INDEX `fk_Artikel_has_Uporabnik_Artikel1_idx` (`Artikel_id_artikla` ASC) VISIBLE,
  CONSTRAINT `fk_Artikel_has_Uporabnik_Artikel1`
    FOREIGN KEY (`Artikel_id_artikla`)
    REFERENCES `spletna_trgovina`.`Artikel` (`id_artikla`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Artikel_has_Uporabnik_Uporabnik1`
    FOREIGN KEY (`Uporabnik_id_uporabnika`)
    REFERENCES `spletna_trgovina`.`Uporabnik` (`id_uporabnika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `spletna_trgovina`.`Naročilo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `spletna_trgovina`.`Naročilo` ;

CREATE TABLE IF NOT EXISTS `spletna_trgovina`.`Naročilo` (
  `id_naročila` INT NOT NULL AUTO_INCREMENT,
  `cena` VARCHAR(45) NOT NULL,
  `Uporabnik_id_uporabnika` INT NOT NULL,
  `Status_id_statusa` INT NOT NULL,
  PRIMARY KEY (`id_naročila`),
  INDEX `fk_Naročilo_Uporabnik1_idx` (`Uporabnik_id_uporabnika` ASC) VISIBLE,
  INDEX `fk_Naročilo_Status1_idx` (`Status_id_statusa` ASC) VISIBLE,
  CONSTRAINT `fk_Naročilo_Uporabnik1`
    FOREIGN KEY (`Uporabnik_id_uporabnika`)
    REFERENCES `spletna_trgovina`.`Uporabnik` (`id_uporabnika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Naročilo_Status1`
    FOREIGN KEY (`Status_id_statusa`)
    REFERENCES `spletna_trgovina`.`Status` (`id_statusa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `spletna_trgovina`.`Artikel_Naročilo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `spletna_trgovina`.`Artikel_Naročilo` ;

CREATE TABLE IF NOT EXISTS `spletna_trgovina`.`Artikel_Naročilo` (
  `Artikel_id_artikla` INT NOT NULL,
  `Naročilo_id_naročila` INT NOT NULL,
  `količina` INT NOT NULL,
  PRIMARY KEY (`Artikel_id_artikla`, `Naročilo_id_naročila`),
  INDEX `fk_Artikel_has_Naročilo_Naročilo1_idx` (`Naročilo_id_naročila` ASC) VISIBLE,
  INDEX `fk_Artikel_has_Naročilo_Artikel1_idx` (`Artikel_id_artikla` ASC) VISIBLE,
  CONSTRAINT `fk_Artikel_has_Naročilo_Artikel1`
    FOREIGN KEY (`Artikel_id_artikla`)
    REFERENCES `spletna_trgovina`.`Artikel` (`id_artikla`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Artikel_has_Naročilo_Naročilo1`
    FOREIGN KEY (`Naročilo_id_naročila`)
    REFERENCES `spletna_trgovina`.`Naročilo` (`id_naročila`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `spletna_trgovina`.`Slika`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `spletna_trgovina`.`Slika` ;

CREATE TABLE IF NOT EXISTS `spletna_trgovina`.`Slika` (
  `id_slike` INT NOT NULL AUTO_INCREMENT,
  `pot_do_slike` VARCHAR(1024) NOT NULL,
  `Artikel_id_artikla` INT NOT NULL,
  PRIMARY KEY (`id_slike`),
  INDEX `fk_Slika_Artikel1_idx` (`Artikel_id_artikla` ASC) VISIBLE,
  CONSTRAINT `fk_Slika_Artikel1`
    FOREIGN KEY (`Artikel_id_artikla`)
    REFERENCES `spletna_trgovina`.`Artikel` (`id_artikla`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO `spletna_trgovina`.`Vloga` (naziv_vloge)
VALUES
("Administrator"),
("Prodajalec"),
("Stranka");

INSERT INTO `spletna_trgovina`.`Status` (naziv_statusa)
VALUES
("Neobdelano"),
("Potrjeno"),
("Preklicano"),
("Stornirano");

INSERT INTO `spletna_trgovina`.`Artikel` (naziv_artikla,cena_artikla)
VALUES
("APPLE MacBook Air13 M1",1149.99),
("HUAWEI MateBook D15",649.99),
("LENOVO V15 G2",399.99),
("ASUS VivoBook 15",899.99),
("HP ProBook 450 G8",960.99),
("HUAWEI MateView GT 34",579.99),
("DELL S2721HN", 229.99),
("ViewSonic VA2261-2",145.43),
("SAMSUNG ODYSSEY",298.99),
("TESLA 24MC625BF",153.70),
("SAMSUNG GALAXY BUDS2",89.99),
("SAMSUNG GALAXY BUDS1",29.99),
("PHILIPS TAH4205",49.99),
("XIAOMI REDMI BUDS 4",54.99),
("JBL JR310BT",29.99),
("JBL TUNE 230NC TWS",99.99),
("JBL T570",44.99),
("APPLE AIRPODS2",139.99),
("APPLE AIRPODS PRO",319.99),
("APPLE BEATS FLEX",59.99);

INSERT INTO `spletna_trgovina`.`Uporabnik` (ime_uporabnika,priimek_uporabnika,elektronski_naslov,geslo,Vloga_id_vloge)
VALUES
("Nejc","Gasparic","nejcgasparic@gmail.com","$2y$10$VcNuwy7q.JBTBNmQYblTJu2HSBe412WHchqAUyw8URerrjBGYzoYa",1),
("Uros","Gasparic","urosgasparic@gmail.com","$2y$10$D9nfn.YQ1P7wMgoETwq7DeBeU1b6rVTG5MGvN0oe1Iw4IkqO8uKOG",2),
("Marko","Gasparic","markogasparic@gmail.com","$2y$10$rCoX.EY9s0C7mQ2Xzmr7xeOKUmypnzayNswqlngEahRSSbU/t7nUq",2),
("Branka","Gasparic","brankagasparic@gmail.com","$2y$10$OIQQzkqmHLZMsSWP.oXzN.Mu0o6vDNB0X12A2U3ixlEVFwnepex6q",2),
("Edi","Slokar",edi@gmail.com,"$2y$10$VcNuwy7q.JBTBNmQYblTJu2HSBe412WHchqAUyw8URerrjBGYzoYa",3);
