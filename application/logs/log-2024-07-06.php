<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2024-07-06 10:25:49 --> UTF-8 Support Enabled
DEBUG - 2024-07-06 10:25:49 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-07-06 10:25:58 --> Query error: ERROR:  value too long for type character(10) - Invalid query: insert into datatex_productibeandtl_240706 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values ('FAB','74230D','WOVEN','DENIM','CO10X','SANFR','45','28.60X18.80','YARND',
							'1','SULPH',1179,'74230D-WOVEN-DENIM-CO10X-SANFR-45-28.60X18.80-YARND-1-SULPH','F/1/343024      ') 
						  	ON CONFLICT (item_id) DO UPDATE 
							SET itemtypecode='FAB',
								subcode01='74230D',
								subcode02='WOVEN',
								subcode03='DENIM',
								subcode04='CO10X',
								subcode05='SANFR',
								subcode06='45',
								subcode07='28.60X18.80',
								subcode08='YARND',
								subcode09='1',
								subcode10='SULPH',
								dtmitem_id='1179',
								fullsubcode='74230D-WOVEN-DENIM-CO10X-SANFR-45-28.60X18.80-YARND-1-SULPH'
DEBUG - 2024-07-06 10:25:58 --> DB Transaction Failure
DEBUG - 2024-07-06 10:29:44 --> UTF-8 Support Enabled
DEBUG - 2024-07-06 10:29:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-07-06 10:29:57 --> Total execution time: 13.4285
