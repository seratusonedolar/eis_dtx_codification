<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2024-09-19 08:33:18 --> UTF-8 Support Enabled
DEBUG - 2024-09-19 08:33:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-19 08:36:52 --> Total execution time: 214.6423
DEBUG - 2024-09-19 11:55:15 --> UTF-8 Support Enabled
DEBUG - 2024-09-19 11:55:15 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-09-19 14:12:14 --> Query error: server closed the connection unexpectedly
	This probably means the server terminated abnormally
	before or while processing the request. - Invalid query: 
			select case when max(a.dtxproductibeanid)= max(b.dtxproductibeanid) then 1 else 0 end cekprod
            from
			datatex_productibeandtl_240706 a
			join datatex_productibean_240706  b 
			on trim(a.itemtypecode) = trim(b.itemtypecode) and 
			trim(a.subcode01) = trim(b.subcode01) and
			trim(a.subcode02) = trim(b.subcode02) and
			trim(a.subcode03) = trim(b.subcode03) and
			trim(a.subcode04) = trim(b.subcode04) and
			trim(a.subcode05) = trim(b.subcode05) and
			trim(a.subcode06) = trim(b.subcode06)
			left join datatex_productibeandtl_status_240706 c on a.dtmitem_id=c.dtmitem_id
			where b.itemtypecode = 'TRM' and 
			trim(a.subcode01) = 'GCRC9625' and
			trim(a.subcode02) = 'THRED' and
			trim(a.subcode03) = 'PLYST' and
			trim(a.subcode04) = 'SPNTP' and
			trim(a.subcode05) = 'NA' and
			trim(a.subcode06) = 'NA' and
			c.status_subcode = 'confirmed'
			;
DEBUG - 2024-09-19 14:12:14 --> DB Transaction Failure
ERROR - 2024-09-19 14:12:14 --> Database: Failure during an automated transaction commit/rollback!
