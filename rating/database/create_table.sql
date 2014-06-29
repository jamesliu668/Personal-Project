CREATE  TABLE IF NOT EXISTS `jms_rating`.`jms-rate-product` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB

CREATE  TABLE IF NOT EXISTS `jms_rating`.`jms-rate-rateItem` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `product_id` INT NOT NULL ,
  `hash_id` VARCHAR(10) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `Product ID_idx` (`product_id` ASC) ,
  CONSTRAINT `Product ID`
    FOREIGN KEY (`product_id` )
    REFERENCES `jms_rating`.`jms-rate-product` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB

CREATE  TABLE IF NOT EXISTS `jms_rating`.`jms-rate-rateRecord` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `item_id` INT NOT NULL ,
  `score` FLOAT(4,1) NOT NULL ,
  `rate_time` DATETIME NOT NULL ,
  `remote_ip` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `Rate Item ID_idx` (`item_id` ASC) ,
  CONSTRAINT `Rate Item ID`
    FOREIGN KEY (`item_id` )
    REFERENCES `jms_rating`.`jms-rate-rateItem` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB

CREATE  OR REPLACE VIEW `jms_rating`.`jms-item-rateRecord` AS
SELECT i.*, CAST(FLOOR(AVG(r.score)*2)/2 AS DECIMAL(2,1)) AS score
FROM `jms_rating`.`jms-rate-rateRecord` AS r 
LEFT JOIN `jms_rating`.`jms-rate-rateItem` AS i
ON r.item_id = i.id