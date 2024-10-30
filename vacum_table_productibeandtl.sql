--Work Order--
 COPY (
 select oi.order_no as ORDER_NO,oi.order_date as ORDER_DATE, oi.buyer_id as BUYER_ID,  OI.total_qty as ORDER_QTY,
 oi.status as STATUS_ORDER,oi.created_date as ORDER_CRETAED,oi.modify_date as ORDER_MODIFY,
 wo.delivery_date as WO_DELIVERY,wo.order_qty as WO_ORDER_QTY,wo.wo_qty as WO_QTY,wo.created_date as WO_CREATED,wo.modify_date as WO_MODIFY
 , wo.wo_no as WO_NO, bpo.dt as ex_fty_date,oi.closed_sts as closed_sts,oi.closed_date as closed_date
 from work_orders wo join order_instructions oi on wo.order_no =oi.order_no
  and oi.status='N'
 JOIN (select wo_no, min(ex_fty_date) dt from wo_bpo group by wo_no) bpo ON bpo.wo_no=wo.wo_no
 where wo.created_date between (now() - interval '9 months')::date and (now() + interval '1 day')::date 
 or wo.modify_date between (now() - interval '9 months')::date and (now() + interval '1 day')::date
 order by oi.order_date desc
 ) to '/data_qrcode/qrwo.csv' DELIMITER ',' CSV HEADER;

--Laundry EDI--
COPY (
SELECT
BA.wo_no, BA.order_no, trim(BA.garment_colors) as garment_colors, BA.buyer_id,BB.new_ex_fty_date,BB.id as id_edi,
BB.buyer_po_number,BB.destination,BB.first_new_xfty_date,BB.last_new_xfty_date,BB.shipment_date,BB.buyer_po_qty,DATE(CC.xfty_date) as xfty_date_gea
FROM
( SELECT A.wo_no,A.order_no,A.buyer_style_no,C.garment_colors,A.buyer_id,B.buyer_po_number
FROM
work_orders
A JOIN wo_bpo B ON A.wo_no = B.wo_no AND A.order_no = B.order_no
JOIN order_size_breakdown C ON A.order_no = C.order_no AND B.buyer_po_number = C.buyer_po_number
JOIN order_instructions E ON A.order_no = E.order_no
JOIN quotation_header F ON E.quote_no = F.quote_no
WHERE
A.created_date BETWEEN ( now( ) - INTERVAL '2 months' ) :: DATE
AND (now() + interval '1 day')::date
OR A.modify_date BETWEEN ( now( ) - INTERVAL '2 months' ) :: DATE
AND (now() + interval '1 day')::date
GROUP BY A.wo_no, C.garment_colors, A.buyer_id, A.buyer_style_no, B.buyer_po_number
) AS BA
JOIN exp_delivinfo_mst as BB ON BA.buyer_po_number=BB.original_buyer_po_number and BA.order_no=BB.order_no
LEFT JOIN exp_trucking as CC ON BB.id=CC.edi_id
WHERE BB.status = 0
) to '/data_qrcode/laundry_edi.csv' DELIMITER ',' CSV HEADER;

--Laundry WO--
-- COPY(
-- SELECT
-- 	wo_no,
-- 	order_no,
-- 	TRIM ( garment_colors ) AS garment_colors,
-- 	buyer_id,
-- 	buyer_style_no,
-- 	ex_fty_date,
-- 	wash_category_id,
-- 	type_source,
-- 	CONCAT ( 'A', ROW_NUMBER ( ) OVER ( PARTITION BY wo_no, garment_colors, type_source ORDER BY ex_fty_date ) ) AS codeseq,
-- 	wash_sub_category_id,
-- 	gmt_weight,
-- 	buyer_name
-- FROM
-- 	(
-- 	SELECT
-- 	CASE
			
-- 		WHEN
-- 			DATA_EDI.wo_no IS NULL THEN
-- 				DATA_ORDER.wo_no ELSE DATA_EDI.wo_no 
-- 				END AS wo_no,
-- 		CASE
				
-- 				WHEN DATA_EDI.order_no IS NULL THEN
-- 				DATA_ORDER.order_no ELSE DATA_EDI.order_no 
-- 			END AS order_no,
-- 		CASE
				
-- 				WHEN DATA_EDI.garment_colors IS NULL THEN
-- 				DATA_ORDER.garment_colors ELSE DATA_EDI.garment_colors 
-- 			END AS garment_colors,
-- 		CASE
				
-- 				WHEN DATA_EDI.buyer_id IS NULL THEN
-- 				DATA_ORDER.buyer_id ELSE DATA_EDI.buyer_id 
-- 			END AS buyer_id,
-- 		CASE
				
-- 				WHEN DATA_EDI.new_ex_fty_date IS NULL THEN
-- 				DATA_ORDER.ex_fty_date ELSE DATA_EDI.new_ex_fty_date 
-- 			END AS ex_fty_date,
-- 		CASE
				
-- 				WHEN DATA_EDI.wash_category_id IS NULL THEN
-- 				DATA_ORDER.wash_category_id ELSE DATA_EDI.wash_category_id 
-- 			END AS wash_category_id,
-- 		CASE
				
-- 				WHEN DATA_EDI.wash_sub_category_id IS NULL THEN
-- 				DATA_ORDER.wash_sub_category_id ELSE DATA_EDI.wash_sub_category_id 
-- 			END AS wash_sub_category_id,
-- 		CASE
				
-- 				WHEN DATA_EDI.gmt_weight IS NULL THEN
-- 				DATA_ORDER.gmt_weight ELSE DATA_EDI.gmt_weight 
-- 			END AS gmt_weight,
-- 		CASE
				
-- 				WHEN DATA_EDI.buyer_style_no IS NULL THEN
-- 				DATA_ORDER.buyer_style_no ELSE DATA_EDI.buyer_style_no 
-- 			END AS buyer_style_no,
-- 		CASE
				
-- 				WHEN DATA_EDI.wo_no IS NOT NULL THEN
-- 				'1' ELSE'2' 
-- 			END AS type_source,
-- 			CAM.name as buyer_name
-- 		FROM
-- 			work_orders WO
-- 			JOIN m_company CAM ON WO.buyer_id=CAM.company_id
-- 			JOIN (
-- 			SELECT A
-- 				.wo_no,
-- 				A.order_no,
-- 				A.buyer_style_no,
-- 				C.garment_colors,
-- 				E.buyer_id,
-- 				B.ex_fty_date,
-- 				F.wash_category_id,
-- 				F.wash_sub_category_id,
-- 				F.gmt_weight
-- 			FROM
-- 				work_orders
-- 				A JOIN order_buyer_po B ON A.order_no = B.order_no
-- 				JOIN order_size_breakdown C ON B.order_no = C.order_no 
-- 				AND B.buyer_po_number = C.buyer_po_number
-- 				JOIN order_instructions E ON A.order_no = E.order_no
-- 				JOIN (
-- 				SELECT
-- 					wash_category_id,
-- 					wash_sub_category_id,
-- 					gmt_weight,
-- 					A.quote_no,
-- 					B.rev_no 
-- 				FROM
-- 					quotation_header
-- 					A JOIN ( SELECT MAX ( rev_no ) AS rev_no, quote_no FROM quotation_header GROUP BY quote_no, wash_category_id ) AS B ON A.quote_no = B.quote_no 
-- 					AND A.rev_no = B.rev_no 
-- 				) AS F ON E.quote_no = F.quote_no 
-- 			WHERE
-- 				A.created_date BETWEEN ( now( ) - INTERVAL '2 months' ) :: DATE 
-- 				AND (now() + interval '1 day')::DATE
-- 				OR A.modify_date BETWEEN ( now( ) - INTERVAL '2 months' ) :: DATE 
-- 				AND (now() + interval '1 day')::DATE
-- 			GROUP BY
-- 				A.wo_no,
-- 				C.garment_colors,
-- 				E.buyer_id,
-- 				A.buyer_style_no,
-- 				B.ex_fty_date,
-- 				F.wash_category_id,
-- 				F.wash_sub_category_id,
-- 				F.gmt_weight
-- 			) AS DATA_ORDER ON WO.wo_no = DATA_ORDER.wo_no 
-- 			LEFT JOIN (
-- 			SELECT
-- 				BA.wo_no,
-- 				BA.order_no,
-- 				BA.garment_colors,
-- 				BA.buyer_id,
-- 				BA.buyer_style_no,
-- 				BA.wash_category_id,
-- 				BA.wash_sub_category_id,
-- 				BA.gmt_weight,
-- 				BB.new_ex_fty_date 
-- 			FROM
-- 				(
-- 				SELECT A
-- 					.wo_no,
-- 					A.order_no,
-- 					A.buyer_style_no,
-- 					C.garment_colors,
-- 					A.buyer_id,
-- 					B.buyer_po_number,
-- 					F.wash_category_id,
-- 					F.wash_sub_category_id,
-- 					F.gmt_weight
-- 				FROM
-- 					work_orders
-- 					A JOIN wo_bpo B ON A.wo_no = B.wo_no 
-- 					AND A.order_no = B.order_no
-- 					JOIN order_size_breakdown C ON A.order_no = C.order_no 
-- 					AND B.buyer_po_number = C.buyer_po_number
-- 					JOIN order_instructions E ON A.order_no = E.order_no
-- 					JOIN (
-- 					SELECT
-- 						wash_category_id,
-- 						wash_sub_category_id,
-- 						gmt_weight,
-- 						A.quote_no,
-- 						B.rev_no 
-- 					FROM
-- 						quotation_header A JOIN ( SELECT MAX ( rev_no ) AS rev_no, quote_no FROM quotation_header GROUP BY quote_no) AS B ON A.quote_no = B.quote_no 
-- 						AND A.rev_no = B.rev_no 
-- 					) AS F ON E.quote_no = F.quote_no 
-- 				WHERE
-- 					A.created_date BETWEEN ( now( ) - INTERVAL '2 months' ) :: DATE 
-- 					AND (now() + interval '1 day')::DATE 
-- 					OR A.modify_date BETWEEN ( now( ) - INTERVAL '2 months' ) :: DATE 
-- 					AND (now() + interval '1 day')::DATE 
-- 				GROUP BY
-- 					A.wo_no,
-- 					C.garment_colors,
-- 					A.buyer_id,
-- 					A.buyer_style_no,
-- 					B.buyer_po_number,
-- 					F.wash_category_id,
-- 					F.wash_sub_category_id,
-- 					F.gmt_weight
-- 				) AS BA
-- 				JOIN exp_delivinfo_mst AS BB ON BA.buyer_po_number = BB.original_buyer_po_number 
-- 				AND BA.order_no = BB.order_no 
-- 			WHERE
-- 				BB.status = 0 
-- 			) AS DATA_EDI ON WO.wo_no = DATA_EDI.wo_no
			
-- 		WHERE
-- 			WO.created_date BETWEEN ( now( ) - INTERVAL '2 months' ) :: DATE 
-- 			AND (now() + interval '1 day')::DATE
-- 			OR WO.modify_date BETWEEN ( now( ) - INTERVAL '2 months' ) :: DATE 
-- 			AND (now() + interval '1 day')::DATE 
-- 		) AS ALL_DATA 
-- 	GROUP BY
-- 		wo_no,
-- 		order_no,
-- 		garment_colors,
-- 		buyer_id,
-- 		buyer_style_no,
-- 		ex_fty_date,
-- 		wash_category_id,
-- 		wash_sub_category_id,
-- 		gmt_weight,
-- 		type_source,
-- 		buyer_name
-- ORDER BY
-- 	wo_no
-- ) to '/data_qrcode/laundry_wo.csv' DELIMITER ',' CSV HEADER;

--Work Order SB--
 COPY (
 select c.*
 from work_orders wo join order_instructions oi on wo.order_no =oi.order_no
 and oi.status='N'
 JOIN (select wo_no, min(ex_fty_date) dt from wo_bpo group by wo_no) bpo ON bpo.wo_no=wo.wo_no
 JOIN wo_sb c on wo.wo_no=c.wo_no
 where wo.created_date between (now() - interval '12 months')::date and (now() + interval '1 day')::date 
 or wo.modify_date between (now() - interval '12 months')::date and (now() + interval '1 day')::date

 order by oi.order_date desc
 ) to '/data_qrcode/qrwosb.csv' DELIMITER ',' CSV HEADER;

--WO GEA--
 COPY (
 SELECT
 BA.wo_no,BA.buyer_id,BA.buyer_po_number,BC.buyer_po_qty,BB.gea_no,BB.edi_id,BB.delivery_qty,BB.carton_qty,BB.volume,BB.status,BB.remarks,BB.order_no,BB.asn_no,DATE(CC.xfty_date) as xfty_date
 FROM
 ( SELECT A.wo_no,A.order_no,A.buyer_id,B.buyer_po_number,B.bpo_qty
 FROM
 work_orders A JOIN wo_bpo B ON A.wo_no = B.wo_no AND A.order_no = B.order_no
 WHERE
 A.created_date BETWEEN ( now( ) - INTERVAL '3 months' ) :: DATE
 AND now( ) :: DATE
 OR A.modify_date BETWEEN ( now( ) - INTERVAL '3 months' ) :: DATE
 AND now( ) :: DATE
 GROUP BY A.wo_no,A.buyer_id,B.buyer_po_number,B.bpo_qty) AS BA
-- X asal tidak digunakan JOIN exp_delivinfo_mst as BC on BA.order_no=BC.order_no and BA.buyer_po_number=BC.buyer_po_number
 JOIN (select *, case when COALESCE(original_buyer_po_number,'')<>'' then original_buyer_po_number else buyer_po_number end as bpon from exp_delivinfo_mst) as BC on BA.order_no=BC.order_no and (BA.buyer_po_number=BC.bpon)
 JOIN exp_trucking_advices_detail as BB on BC.id=BB.edi_id
 JOIN exp_trucking_advices as CC on BB.gea_no=CC.gea_no
 ) to '/data_qrcode/qrwogea.csv' DELIMITER ',' CSV HEADER;

--Order Instrution--
 COPY (
 select order_no,buyer_id,buyer_name,order_date,status as status_order,total_qty,created_date,modify_date,closed_sts,closed_date,buyer_style_no,a.quote_no,b.wash_category_id,b.wash_sub_category_id,case when b.wash_category_id<>'13' then 'Wash' else 'Non-Wash' end wash_type 
 from order_instructions a join (SELECT wash_category_id,wash_sub_category_id,gmt_weight,A.quote_no,B.rev_no FROM
						quotation_header A JOIN ( SELECT MAX ( rev_no ) AS rev_no, quote_no FROM quotation_header GROUP BY quote_no) AS B ON A.quote_no = B.quote_no AND A.rev_no = B.rev_no ) b on a.quote_no=b.quote_no
						join m_wash_category c on b.wash_category_id=c.wash_category_id
 where status='N' and created_date between (now() - interval '9 months')::date and (now() + interval '1 day')::date
 order by order_date desc
 ) to '/data_qrcode/qrorder.csv' DELIMITER ',' CSV HEADER;


--WO Sew Ratio--
 COPY (
 SELECT 
	A.wo_no,A.order_no,C.quote_no,A.buyer_style_no,A.buyer_id,sew_ratio
 FROM
	work_orders	A 
	JOIN order_instructions B ON A.order_no = B.order_no
	JOIN (SELECT A.quote_no,sew_ratio,B.rev_no FROM	quotation_header A 
				JOIN ( SELECT MAX ( rev_no ) AS rev_no, quote_no FROM quotation_header 
							 GROUP BY quote_no ) AS B 
				ON A.quote_no = B.quote_no AND A.rev_no = B.rev_no 
	) AS C ON B.quote_no = C.quote_no 
 WHERE
	A.created_date BETWEEN ( now( ) - INTERVAL '9 months' ) :: DATE 
	AND (now() + interval '1 day')::date
	OR A.modify_date BETWEEN ( now( ) - INTERVAL '9 months' ) :: DATE 
	AND (now() + interval '1 day')::date
 ) to '/data_qrcode/qr_sew_ratio.csv' DELIMITER ',' CSV HEADER;
