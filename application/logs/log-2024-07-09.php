<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2024-07-09 10:13:46 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 10:13:47 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 10:13:49 --> Total execution time: 2.8178
DEBUG - 2024-07-09 10:15:06 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 10:15:06 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 10:15:06 --> Total execution time: 0.2286
DEBUG - 2024-07-09 13:18:10 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:18:10 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 13:18:11 --> Query error: ERROR:  syntax error at or near "datatex_productibeandtl_240706"
LINE 2:    datatex_productibeandtl_240706 a
           ^ - Invalid query: select case when max(a.dtxproductibeanid) = b.dtxproductibeanid then 'ok' else 'no' end cekprod 
			datatex_productibeandtl_240706 a
			join datatex_productibean_240706  b 
			on trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05) = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06) and
			trim(a.subcode07) = trim(b.subcode07) and
			trim(a.subcode08) = trim(b.subcode08) and
			where b.itemtypecode = 'FAB' and 
			trim(a.subcode01) = '00027250' and
			trim(a.subcode02) = 'WOVEN' and
			trim(a.subcode03) = 'TWILL' and
			trim(a.subcode04) = 'PL10X' and
			trim(a.subcode05) = 'NA' and
			trim(a.subcode06) = '56' and
			trim(a.subcode07) = 'NA' and
			trim(a.subcode08) = 'PIECE'
			;
DEBUG - 2024-07-09 13:18:11 --> DB Transaction Failure
DEBUG - 2024-07-09 13:18:56 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:18:56 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 13:18:56 --> Query error: ERROR:  syntax error at or near "where"
LINE 14:    where b.itemtypecode = 'FAB' and 
            ^ - Invalid query: select case when max(a.dtxproductibeanid) = b.dtxproductibeanid then 'ok' else 'no' end cekprod 
			from
			datatex_productibeandtl_240706 a
			join datatex_productibean_240706  b 
			on trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05) = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06) and
			trim(a.subcode07) = trim(b.subcode07) and
			trim(a.subcode08) = trim(b.subcode08) and
			where b.itemtypecode = 'FAB' and 
			trim(a.subcode01) = '00027250' and
			trim(a.subcode02) = 'WOVEN' and
			trim(a.subcode03) = 'TWILL' and
			trim(a.subcode04) = 'PL10X' and
			trim(a.subcode05) = 'NA' and
			trim(a.subcode06) = '56' and
			trim(a.subcode07) = 'NA' and
			trim(a.subcode08) = 'PIECE'
			;
DEBUG - 2024-07-09 13:18:56 --> DB Transaction Failure
DEBUG - 2024-07-09 13:19:21 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:19:21 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 13:19:22 --> Query error: ERROR:  column "b.dtxproductibeanid" must appear in the GROUP BY clause or be used in an aggregate function
LINE 1: select case when max(a.dtxproductibeanid) = b.dtxproductibea...
                                                    ^ - Invalid query: select case when max(a.dtxproductibeanid) = b.dtxproductibeanid then 'ok' else 'no' end cekprod 
			from
			datatex_productibeandtl_240706 a
			join datatex_productibean_240706  b 
			on trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05) = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06) and
			trim(a.subcode07) = trim(b.subcode07) and
			trim(a.subcode08) = trim(b.subcode08)
			where b.itemtypecode = 'FAB' and 
			trim(a.subcode01) = '00027250' and
			trim(a.subcode02) = 'WOVEN' and
			trim(a.subcode03) = 'TWILL' and
			trim(a.subcode04) = 'PL10X' and
			trim(a.subcode05) = 'NA' and
			trim(a.subcode06) = '56' and
			trim(a.subcode07) = 'NA' and
			trim(a.subcode08) = 'PIECE'
			;
DEBUG - 2024-07-09 13:19:22 --> DB Transaction Failure
DEBUG - 2024-07-09 13:19:57 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:19:57 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:57 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:58 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:59 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:59 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:59 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:59 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:59 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
ERROR - 2024-07-09 13:19:59 --> Severity: 4096 --> Object of class CI_DB_pdo_result could not be converted to string C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 87
DEBUG - 2024-07-09 13:21:31 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:21:31 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 13:23:23 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:23:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 13:25:31 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:25:31 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 13:26:22 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:26:22 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 13:26:43 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:26:43 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 13:27:06 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:27:06 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 13:30:29 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:30:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 13:31:06 --> Total execution time: 36.8913
DEBUG - 2024-07-09 13:34:48 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:34:48 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 13:34:48 --> Severity: Notice --> Undefined variable: arrData C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 301
DEBUG - 2024-07-09 13:38:05 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:38:05 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 13:38:05 --> Severity: Notice --> Undefined variable: arrData C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 301
DEBUG - 2024-07-09 13:40:17 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:40:17 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 13:40:17 --> Severity: Notice --> Undefined variable: arrData C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 301
DEBUG - 2024-07-09 13:41:38 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:41:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 13:42:15 --> Total execution time: 37.5369
DEBUG - 2024-07-09 13:49:59 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:49:59 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 13:50:34 --> Severity: Notice --> Array to string conversion C:\xampp\htdocs\eis_datatex\system\database\DB_driver.php 1484
ERROR - 2024-07-09 13:50:34 --> Query error: ERROR:  syntax error at or near "0"
LINE 1: INSERT INTO "datatex_productibean_240706" (0) VALUES (Array)
                                                   ^ - Invalid query: INSERT INTO "datatex_productibean_240706" (0) VALUES (Array)
DEBUG - 2024-07-09 13:50:34 --> DB Transaction Failure
DEBUG - 2024-07-09 13:52:46 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 13:52:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 13:53:22 --> Total execution time: 36.2691
DEBUG - 2024-07-09 14:15:00 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 14:15:00 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:01 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
ERROR - 2024-07-09 14:15:02 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 88
DEBUG - 2024-07-09 14:17:11 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 14:17:11 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 14:17:11 --> Query error: ERROR:  syntax error at or near "select"
LINE 2:    select select case when max(a.dtxproductibeanid)= max(b.d...
                  ^ - Invalid query: 
			select select case when max(a.dtxproductibeanid)= max(b.dtxproductibeanid) then 1 else 0 end cekprod
            from
			datatex_productibeandtl_240706 a
			join datatex_productibean_240706  b 
			on trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05) = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06) and
			trim(a.subcode07) = trim(b.subcode07) and
			trim(a.subcode08) = trim(b.subcode08)
			where b.itemtypecode = 'FAB' and 
			trim(a.subcode01) = '00027250' and
			trim(a.subcode02) = 'WOVEN' and
			trim(a.subcode03) = 'TWILL' and
			trim(a.subcode04) = 'PL10X' and
			trim(a.subcode05) = 'NA' and
			trim(a.subcode06) = '56' and
			trim(a.subcode07) = 'NA' and
			trim(a.subcode08) = 'PIECE'
			group by b.dtxproductibeanid
			;
DEBUG - 2024-07-09 14:17:11 --> DB Transaction Failure
DEBUG - 2024-07-09 14:17:21 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 14:17:21 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 14:17:21 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:21 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:21 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:22 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
ERROR - 2024-07-09 14:17:23 --> Severity: Notice --> Undefined variable: gkw C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 89
DEBUG - 2024-07-09 14:18:05 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 14:18:05 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 14:18:49 --> Total execution time: 44.1399
DEBUG - 2024-07-09 14:36:36 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 14:36:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 14:37:21 --> Total execution time: 44.7115
DEBUG - 2024-07-09 14:42:47 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 14:42:47 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-09 14:42:47 --> Severity: error --> Exception: syntax error, unexpected 'if' (T_IF), expecting function (T_FUNCTION) or const (T_CONST) C:\xampp\htdocs\eis_datatex\application\models\Services\ProductIBeanService.php 305
DEBUG - 2024-07-09 14:43:21 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 14:43:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 14:43:26 --> Total execution time: 4.9831
DEBUG - 2024-07-09 14:53:40 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 14:53:40 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 14:53:41 --> Total execution time: 1.0094
DEBUG - 2024-07-09 15:04:57 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 15:04:57 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 15:05:08 --> Total execution time: 10.7745
DEBUG - 2024-07-09 15:10:26 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 15:10:26 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 15:11:13 --> Total execution time: 47.1153
DEBUG - 2024-07-09 15:33:12 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 15:33:12 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 15:33:13 --> Total execution time: 0.7744
DEBUG - 2024-07-09 16:30:13 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 16:30:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 16:30:14 --> Total execution time: 1.0272
DEBUG - 2024-07-09 16:39:31 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 16:39:31 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 16:39:38 --> Total execution time: 7.2919
DEBUG - 2024-07-09 16:42:50 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 16:42:50 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 16:42:50 --> Total execution time: 0.2563
DEBUG - 2024-07-09 16:43:20 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 16:43:20 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 16:43:25 --> Total execution time: 5.1963
DEBUG - 2024-07-09 16:49:44 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 16:49:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 16:49:50 --> Total execution time: 6.4694
DEBUG - 2024-07-09 16:51:08 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 16:51:08 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 16:51:08 --> Total execution time: 0.2935
DEBUG - 2024-07-09 16:53:16 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 16:53:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 16:53:19 --> Total execution time: 3.5458
DEBUG - 2024-07-09 16:55:57 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 16:55:57 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 16:56:03 --> Total execution time: 6.1491
DEBUG - 2024-07-09 17:11:33 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 17:11:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 17:11:34 --> Total execution time: 0.6522
DEBUG - 2024-07-09 17:16:44 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 17:16:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 17:16:50 --> Total execution time: 6.0855
DEBUG - 2024-07-09 17:17:26 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 17:17:26 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 17:17:26 --> Total execution time: 0.2621
DEBUG - 2024-07-09 17:21:37 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 17:21:37 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 17:21:47 --> Total execution time: 10.2656
DEBUG - 2024-07-09 17:28:55 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 17:28:55 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 17:29:56 --> Total execution time: 60.5033
DEBUG - 2024-07-09 17:30:35 --> UTF-8 Support Enabled
DEBUG - 2024-07-09 17:30:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-09 17:30:36 --> Total execution time: 0.7841
