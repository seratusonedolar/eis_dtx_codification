<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2024-05-28 15:03:42 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:03:43 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-05-28 15:03:43 --> Query error: ERROR:  bind message supplies 0 parameters, but prepared statement "pdo_stmt_00000002" requires 1 - Invalid query: 
			INSERT INTO datatex_scopefin_hierarchy (
				order_no,
				wo_no,
				item_type,
				sub1_buyerstyle,
				sub2_buyer,
				sub3_season,
				sub4_prodsegment,
				sub5_prodcategory,
				sub6_prodtype,
				sub7_destination,
				sub8_inseam,
				sub9_color,
				sub10_size,
				fulldesc,
				qty,
				dtscfinhie_version,
				dtscfinhie_type
			)
					select vab.order_no, vab.wo_no, 'GMT' as item_type, oi.buyer_style_no as sub1_buyerstyle, oi.buyer_name as sub2_buyer, concat_ws('',oi.season, oi.season_yr) as sub3_season,
					case 
						when oi.buyer_div = 'L' then  'LADIES'
						when oi.buyer_div = 'M' then  'MAN'
						when oi.buyer_div = 'W' then  'LADIES'
						when oi.buyer_div = 'K' then  'KIDS'
						when oi.buyer_div = 'I' then  'INFANT'
						when oi.buyer_div = 'T' then  'TOODLER'
						when oi.buyer_div = 'O' then  'OTHER'
						else 'NA'
					end as sub4_prodsegment,
					'WOV' as sub5_prodcategory,
					mpt2.product_type_name||' '||mpt.product_types_name as sub6_prodtype,
					vab.destination as sub7_destination,
					vab.inseam as sub8_inseam,
					vab.color as sub9_color, 
					vab.size as sub10_size,
					concat_ws('-', 
						oi.buyer_style_no, 
						oi.buyer_name, 
						concat_ws('',oi.season, oi.season_yr),
						case 
							when oi.buyer_div = 'L' then  'LADIES'
							when oi.buyer_div = 'M' then  'MAN'
							when oi.buyer_div = 'W' then  'LADIES'
							when oi.buyer_div = 'K' then  'KIDS'
							when oi.buyer_div = 'I' then  'INFANT'
							when oi.buyer_div = 'T' then  'TOODLER'
							when oi.buyer_div = 'O' then  'OTHER'
							else 'NA'
						end,
						'WOV',
						(mpt2.product_type_name||' '||mpt.product_types_name),
						vab.destination,
						vab.inseam,
						vab.color,
						vab.size
					) as fullcode,
					sum(vab.qty) as qty,
					10 as dtscfinhie_version,
					? as dtscfinhie_type
		from (
			select rcv.order_no, rcv.po_no, rcv.wo_no, rcv.destination, rcv.color, rcv.inseam, rcv.size, (coalesce(rcv.qty,0)+coalesce(adjp.qty,0))-(coalesce(adjm.qty,0)+coalesce(iss.qty,0)) qty
			from temp_erx_fg1_rcv rcv
			left join temp_erx_fg1_adjp adjp on rcv.order_no=adjp.order_no and rcv.po_no=adjp.po_no and rcv.wo_no=adjp.wo_no and rcv.destination=adjp.destination and rcv.color=adjp.color and rcv.inseam=adjp.inseam and rcv.size=adjp.size 
			left join temp_erx_fg1_adjm adjm on rcv.order_no=adjm.order_no and rcv.po_no=adjm.po_no and rcv.wo_no=adjm.wo_no and rcv.destination=adjm.destination and rcv.color=adjm.color and rcv.inseam=adjm.inseam and rcv.size=adjm.size 
			left join temp_erx_fg1_iss iss on rcv.order_no=iss.order_no and rcv.po_no=iss.po_no and rcv.wo_no=iss.wo_no and rcv.destination=iss.destination and rcv.color=iss.color and rcv.inseam=iss.inseam and rcv.size=iss.size 
			where (coalesce(rcv.qty,0)+coalesce(adjp.qty,0))-(coalesce(adjm.qty,0)+coalesce(iss.qty,0))>0 
		) vab
		left join order_instructions oi on oi.order_no = vab.order_no 
		left join quotation_header qh on oi.quote_no=qh.quote_no and oi.quote_rev_no=qh.rev_no
		left join m_prod_types mpt on qh.product_types_id=mpt.product_types_id
		left join m_prod_type mpt2 on qh.product_type_id=mpt2.product_type_id
		group by vab.order_no, vab.wo_no, oi.buyer_style_no, oi.buyer_name, oi.buyer_div, oi.season, oi.season_yr, mpt2.product_type_name, mpt.product_types_name, vab.destination, vab.color, vab.size, vab.inseam
		having sum(vab.qty) <> 0
	
DEBUG - 2024-05-28 15:03:43 --> DB Transaction Failure
DEBUG - 2024-05-28 15:09:49 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:09:49 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 15:09:50 --> Total execution time: 1.0783
DEBUG - 2024-05-28 15:20:09 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:20:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 15:20:10 --> Total execution time: 0.9288
DEBUG - 2024-05-28 15:20:19 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:20:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 15:20:20 --> Total execution time: 0.9082
DEBUG - 2024-05-28 15:21:11 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:21:11 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 15:21:12 --> Total execution time: 0.9342
DEBUG - 2024-05-28 15:21:56 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:21:56 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 15:21:57 --> Total execution time: 0.8887
DEBUG - 2024-05-28 15:23:08 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:23:08 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 15:23:09 --> Total execution time: 0.8812
DEBUG - 2024-05-28 15:24:02 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:24:02 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 15:24:03 --> Total execution time: 0.9414
DEBUG - 2024-05-28 15:24:24 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:24:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 15:24:25 --> Total execution time: 0.9235
DEBUG - 2024-05-28 15:24:33 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:24:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 15:24:34 --> Total execution time: 0.9209
DEBUG - 2024-05-28 15:54:17 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 15:54:17 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 15:54:18 --> Total execution time: 0.7320
DEBUG - 2024-05-28 16:02:45 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 16:02:45 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 16:02:45 --> Total execution time: 0.3810
DEBUG - 2024-05-28 16:03:16 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 16:03:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 16:03:16 --> Total execution time: 0.3427
DEBUG - 2024-05-28 16:08:30 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 16:08:30 --> No URI present. Default controller set.
DEBUG - 2024-05-28 16:08:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 16:08:30 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 16:08:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 16:08:31 --> Total execution time: 0.1795
DEBUG - 2024-05-28 16:08:36 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 16:08:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 16:08:36 --> Total execution time: 0.0966
DEBUG - 2024-05-28 16:08:37 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 16:08:37 --> No URI present. Default controller set.
DEBUG - 2024-05-28 16:08:37 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 16:08:37 --> Total execution time: 0.3688
DEBUG - 2024-05-28 16:08:40 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 16:08:40 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 16:08:40 --> Total execution time: 0.2013
DEBUG - 2024-05-28 16:08:41 --> UTF-8 Support Enabled
DEBUG - 2024-05-28 16:08:41 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-05-28 16:08:41 --> Total execution time: 0.4734
