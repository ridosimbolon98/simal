-- create table ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
        `id` varchar(128) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
        `data` blob NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`)
);


-- create table user
CREATE TABLE `simal`.`user` (
  `uid` VARCHAR(20) NOT NULL , 
  `nama` VARCHAR(50) NOT NULL , 
  `username` VARCHAR(50) NOT NULL , 
  `password` VARCHAR(500) NOT NULL , 
  `level` VARCHAR(50) NOT NULL , 
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  `updated_at` DATETIME NOT NULL , 
  PRIMARY KEY (`uid`), UNIQUE (`username`)
) ENGINE = InnoDB;

-- insert user admin
INSERT INTO `user` (`uid`, `nama`, `username`, `password`, `level`, `created_at`, `updated_at`) 
VALUES ('20221111001', 'Admin', 'admin', MD5('123456'), 'ADMIN', '2022-11-01 08:22:14', '2022-11-01 02:22:14.000000');


-- create table griya
CREATE TABLE `simal`.`griya` (
  `id` VARCHAR(20) NOT NULL , 
  `nama` VARCHAR(100) NOT NULL , 
  `alamat` TEXT NOT NULL , 
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `griya` ADD `biaya_mtc` VARCHAR(50) NOT NULL AFTER `alamat`;

-- insert data griya
INSERT INTO `griya` (`id`, `nama`, `alamat`) VALUES ('20221123012', 'GRIYA UTAMA BANJARDOWO BARU', '');
INSERT INTO `griya` (`id`, `nama`, `alamat`) VALUES ('20221123322', 'GRIYA UTAMA KUDU ASRI', '');


-- create table kartu meter pelanggan
CREATE TABLE `simal`.`kartu_meter` (
  `id` VARCHAR(20) NOT NULL , 
  `cid` VARCHAR(20) NOT NULL , 
  `bulan` VARCHAR(2) NOT NULL , 
  `periode` YEAR NOT NULL , 
  `aka_lalu` DOUBLE NOT NULL , 
  `aka_akhir` DOUBLE NOT NULL , 
  `jlh_pakai` DOUBLE NOT NULL , 
  `jlh_biaya` BIGINT NOT NULL , 
  `biaya_per_meter` BIGINT NOT NULL , 
  `inserted_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- insert data kartu meter pelanggan
INSERT INTO `kartu_meter` (`id`, `cid`, `bulan`, `periode`, `aka_lalu`, `aka_akhir`, `jlh_pakai`, `jlh_biaya`, `biaya_per_meter`, `inserted_at`) 
VALUES ('20221101001', '123345346', '01', '2022', '17', '29', '12', '50000', '4000', current_timestamp()), ('20221101002', '123345346', '02', '2022', '29', '40', '11', '46000', '4000', current_timestamp()), ('20221101003', '123345346', '03', '2022', '40', '48', '8', '34000', '4000', current_timestamp()), ('20221101004', '123345346', '04', '2022', '48', '59', '11', '46000', '4000', current_timestamp()), ('20221101005', '123345346', '05', '2022', '59', '72', '13', '54000', '4000', current_timestamp()), ('20221101006', '123345346', '06', '2022', '72', '79', '7', '30000', '4000', current_timestamp()), ('20221101007', '123345346', '07', '2022', '79', '88', '9', '38', '4000', current_timestamp()), ('20221101008', '123345346', '08', '2022', '88', '100', '12', '50000', '4000', current_timestamp()), ('20221101009', '123345346', '09', '2022', '100', '115', '15', '62000', '4000', current_timestamp()), ('20221101010', '123345346', '10', '2022', '115', '125', '10', '42000', '4000', current_timestamp())


-- create table customer
CREATE TABLE `simal`.`customer` (
  `cid` VARCHAR(20) NOT NULL , 
  `nama` VARCHAR(50) NOT NULL , 
  `alamat` TEXT NOT NULL , 
  `griya_id` VARCHAR(20) NOT NULL , 
  `golongan` VARCHAR(100) NOT NULL , 
  `stand_meter` VARCHAR(100) NOT NULL , 
  `input_by` VARCHAR(20) NOT NULL , 
  `inserted_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`cid`)
) ENGINE = InnoDB;

-- INSERT CUSTOMER
INSERT INTO `customer` (`cid`, `nama`, `alamat`, `griya_id`, `golongan`, `stand_meter`, `input_by`, `inserted_at`) VALUES ('2134235546', 'CONTOH', 'B-4', '20221123012', 'PERUMAHAN', '', '2334545', current_timestamp());



-- create table setup
CREATE TABLE `simal`.`setup` (`sid` INT NOT NULL AUTO_INCREMENT , `trx` VARCHAR(100) NOT NULL , `tipe` VARCHAR(100) NOT NULL , `nilai` VARCHAR(200) NOT NULL , `updated_by` VARCHAR(20) NOT NULL , `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`sid`)) ENGINE = InnoDB;

-- insert setup
INSERT INTO `setup` (`sid`, `trx`, `tipe`, `nilai`, `updated_by`, `updated_at`) VALUES ('1', 'BIAYA', 'M3', '4000', '20221111001', current_timestamp());
INSERT INTO `setup` (`sid`, `trx`, `tipe`, `nilai`, `updated_by`, `updated_at`) VALUES ('2', 'BIAYA', 'ADMIN', '2500', '20221111001', current_timestamp());