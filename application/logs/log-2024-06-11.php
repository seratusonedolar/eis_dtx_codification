<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2024-06-11 13:01:33 --> UTF-8 Support Enabled
DEBUG - 2024-06-11 13:01:33 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-06-11 13:01:38 --> Query error: ERROR:  syntax error at or near "OLAH"
LINE 4:        values (FAB,FEN-11790-BW OLAH,WOVEN,DENIM,CO10X,REGLR...
                                        ^ - Invalid query: insert into datatex_productibeandtl 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values (FAB,FEN-11790-BW OLAH,WOVEN,DENIM,CO10X,REGLR,51,78X57,PREFD,
							1,WHITE,3263,FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE,F/1/104777      ) 
						  ON DUPLICATE KEY UPDATE item_id='F/1/104777      '
DEBUG - 2024-06-11 13:01:38 --> DB Transaction Failure
DEBUG - 2024-06-11 13:03:14 --> UTF-8 Support Enabled
DEBUG - 2024-06-11 13:03:14 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-06-11 13:03:17 --> Query error: ERROR:  syntax error at or near "DUPLICATE"
LINE 6:         ON DUPLICATE KEY UPDATE item_id='F/1/104777      '
                   ^ - Invalid query: insert into datatex_productibeandtl 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values (FAB,'FEN-11790-BW OLAH','WOVEN','DENIM','CO10X','REGLR','51','78X57','PREFD',
							'1','WHITE',3263,'FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE',F/1/104777      ) 
						  ON DUPLICATE KEY UPDATE item_id='F/1/104777      '
DEBUG - 2024-06-11 13:03:17 --> DB Transaction Failure
DEBUG - 2024-06-11 13:09:19 --> UTF-8 Support Enabled
DEBUG - 2024-06-11 13:09:19 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-06-11 13:09:22 --> Query error: ERROR:  column "fab" does not exist
LINE 4:        values (FAB,'FEN-11790-BW OLAH','WOVEN','DENIM','CO10...
                       ^ - Invalid query: insert into datatex_productibeandtl 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values (FAB,'FEN-11790-BW OLAH','WOVEN','DENIM','CO10X','REGLR','51','78X57','PREFD',
							'1','WHITE',3263,'FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE',F/1/104777      ) 
						  	ON CONFLICT (item_id) DO UPDATE 
							SET itemtypecode='FAB',
								subcode01='FEN-11790-BW OLAH',
								subcode02='FEN-11790-BW OLAH',
								subcode03='FEN-11790-BW OLAH',
								subcode04='FEN-11790-BW OLAH',
								subcode05='FEN-11790-BW OLAH',
								subcode06='FEN-11790-BW OLAH',
								subcode07='FEN-11790-BW OLAH',
								subcode08='FEN-11790-BW OLAH',
								subcode09='FEN-11790-BW OLAH',
								subcode10='FEN-11790-BW OLAH',
								dtmitem_id='3263',
								fullsubcode='FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE'
DEBUG - 2024-06-11 13:09:22 --> DB Transaction Failure
DEBUG - 2024-06-11 13:09:54 --> UTF-8 Support Enabled
DEBUG - 2024-06-11 13:09:54 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-06-11 13:09:57 --> Query error: ERROR:  column "f" does not exist
LINE 5: ...H-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE',F/1/104777...
                                                             ^ - Invalid query: insert into datatex_productibeandtl 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values ('FAB','FEN-11790-BW OLAH','WOVEN','DENIM','CO10X','REGLR','51','78X57','PREFD',
							'1','WHITE',3263,'FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE',F/1/104777      ) 
						  	ON CONFLICT (item_id) DO UPDATE 
							SET itemtypecode='FAB',
								subcode01='FEN-11790-BW OLAH',
								subcode02='FEN-11790-BW OLAH',
								subcode03='FEN-11790-BW OLAH',
								subcode04='FEN-11790-BW OLAH',
								subcode05='FEN-11790-BW OLAH',
								subcode06='FEN-11790-BW OLAH',
								subcode07='FEN-11790-BW OLAH',
								subcode08='FEN-11790-BW OLAH',
								subcode09='FEN-11790-BW OLAH',
								subcode10='FEN-11790-BW OLAH',
								dtmitem_id='3263',
								fullsubcode='FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE'
DEBUG - 2024-06-11 13:09:57 --> DB Transaction Failure
DEBUG - 2024-06-11 13:26:23 --> UTF-8 Support Enabled
DEBUG - 2024-06-11 13:26:23 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-06-11 13:26:29 --> Query error: ERROR:  value too long for type character(10) - Invalid query: insert into datatex_productibeandtl 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values ('FAB','FEN-11790-BW OLAH','WOVEN','DENIM','CO10X','REGLR','51','78X57','PREFD',
							'1','WHITE',3263,'FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE','F/1/104777      ') 
						  	ON CONFLICT (item_id) DO UPDATE 
							SET itemtypecode='FAB',
								subcode01='FEN-11790-BW OLAH',
								subcode02='FEN-11790-BW OLAH',
								subcode03='FEN-11790-BW OLAH',
								subcode04='FEN-11790-BW OLAH',
								subcode05='FEN-11790-BW OLAH',
								subcode06='FEN-11790-BW OLAH',
								subcode07='FEN-11790-BW OLAH',
								subcode08='FEN-11790-BW OLAH',
								subcode09='FEN-11790-BW OLAH',
								subcode10='FEN-11790-BW OLAH',
								dtmitem_id='3263',
								fullsubcode='FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE'
DEBUG - 2024-06-11 13:26:29 --> DB Transaction Failure
DEBUG - 2024-06-11 13:35:52 --> UTF-8 Support Enabled
DEBUG - 2024-06-11 13:35:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-06-11 13:35:55 --> Query error: ERROR:  there is no unique or exclusion constraint matching the ON CONFLICT specification - Invalid query: insert into datatex_productibeandtl 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values ('FAB','FEN-11790-BW OLAH','WOVEN','DENIM','CO10X','REGLR','51','78X57','PREFD',
							'1','WHITE',3263,'FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE','F/1/104777      ') 
						  	ON CONFLICT (item_id) DO UPDATE 
							SET itemtypecode='FAB',
								subcode01='FEN-11790-BW OLAH',
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
								fullsubcode='FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE'
DEBUG - 2024-06-11 13:35:55 --> DB Transaction Failure
DEBUG - 2024-06-11 14:33:49 --> UTF-8 Support Enabled
DEBUG - 2024-06-11 14:33:49 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-06-11 14:33:54 --> Query error: ERROR:  there is no unique or exclusion constraint matching the ON CONFLICT specification - Invalid query: insert into datatex_productibeandtl 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values ('FAB','FEN-11790-BW OLAH','WOVEN','DENIM','CO10X','REGLR','51','78X57','PREFD',
							'1','WHITE',3263,'FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE','F/1/104777      ') 
						  	ON CONFLICT (dtmitem_id,item_id) DO UPDATE 
							SET itemtypecode='FAB',
								subcode01='FEN-11790-BW OLAH',
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
								fullsubcode='FEN-11790-BW OLAH-WOVEN-DENIM-CO10X-REGLR-51-78X57-PREFD-1-WHITE'
DEBUG - 2024-06-11 14:33:54 --> DB Transaction Failure
DEBUG - 2024-06-11 14:51:27 --> UTF-8 Support Enabled
DEBUG - 2024-06-11 14:51:27 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-06-11 14:51:33 --> Query error: ERROR:  syntax error at or near "S"
LINE 4:        values ('FAB','NA MACY'S','WOVEN','DENIM','CO10X','NA...
                                      ^ - Invalid query: insert into datatex_productibeandtl 
							(itemtypecode,subcode01,subcode02,subcode03,subcode04,subcode05,subcode06,subcode07,subcode08,subcode09,subcode10,
							dtmitem_id,fullsubcode,item_id)
							values ('FAB','NA MACY'S','WOVEN','DENIM','CO10X','NA','NA','NA','NA',
							'1','DNM',51780,'NA MACY'S-WOVEN-DENIM-CO10X-NA-NA-NA-NA-1-DNM','F/1/280354      ') 
						  	ON CONFLICT (dtxprodibeandtlid) DO UPDATE 
							SET itemtypecode='FAB',
								subcode01='NA MACY'S',
								subcode02='WOVEN',
								subcode03='DENIM',
								subcode04='CO10X',
								subcode05='NA',
								subcode06='NA',
								subcode07='NA',
								subcode08='NA',
								subcode09='1',
								subcode10='DNM',
								dtmitem_id='51780',
								fullsubcode='NA MACY'S-WOVEN-DENIM-CO10X-NA-NA-NA-NA-1-DNM'
DEBUG - 2024-06-11 14:51:33 --> DB Transaction Failure
DEBUG - 2024-06-11 15:30:42 --> UTF-8 Support Enabled
DEBUG - 2024-06-11 15:30:42 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-06-11 15:30:52 --> Total execution time: 9.8746
