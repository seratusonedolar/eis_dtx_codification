<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2024-06-12 11:18:43 --> UTF-8 Support Enabled
DEBUG - 2024-06-12 11:18:43 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-06-12 11:18:57 --> Total execution time: 15.0562
DEBUG - 2024-06-12 11:22:08 --> UTF-8 Support Enabled
DEBUG - 2024-06-12 11:22:08 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-06-12 11:22:11 --> Query error: ERROR:  there is no unique or exclusion constraint matching the ON CONFLICT specification - Invalid query: insert into datatex_productibeandtl 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values ('FAB','FEN-11790-BW_OLAH','WOVEN','DENIM','CO10X','REGLR','51','78X57','PREFD',
							'1','WHITE',3263,'FEN-11790-BW_OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE','F/1/104777      ') 
						  	ON CONFLICT (item_id) DO UPDATE 
							SET itemtypecode='FAB',
								subcode01='FEN-11790-BW_OLAH',
								subcode02='WOVEN',
								subcode03='DENIM',
								subcode04='CO10X',
								subcode05='REGLR',
								subcode06='51',
								subcode07='78X57',
								subcode08='PREFD',
								subcode09='1',
								subcode10='WHITE',
								dtmitem_id='3263',
								fullsubcode='FEN-11790-BW_OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE'
DEBUG - 2024-06-12 11:22:11 --> DB Transaction Failure
DEBUG - 2024-06-12 11:22:40 --> UTF-8 Support Enabled
DEBUG - 2024-06-12 11:22:40 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-06-12 11:22:50 --> Total execution time: 9.6939
DEBUG - 2024-06-12 11:23:15 --> UTF-8 Support Enabled
DEBUG - 2024-06-12 11:23:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-06-12 11:23:25 --> Total execution time: 9.7115
