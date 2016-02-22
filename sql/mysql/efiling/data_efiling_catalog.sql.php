<?php

 // po_custom
$sql['select_po_custom'] = "SELECT DISTINCT sitehandler_id,
		b.`name`,
		a.site_id,a.site_name, a.far_end_site_id,
		a.far_end_site_name, a.site_id_actual,
		CONCAT(a.technology,a.po_type)AS technology,		
		a.site_name_actual,
		a.far_end_site_id_actual, a.far_end_site_name_actual, 
		a.region as region_name, a.on_air_date, a.trigger_capitalization, 
		a.scope, a.reference_number
	FROM `po_custom` a
	INNER JOIN `company` b ON b.`id` = a.`company_id` 
	ORDER BY a.`sitehandler_id` LIMIT %s OFFSET %s"; 
	
$sql['count'] = "SELECT  COUNT( DISTINCT a.sitehandler_id)AS jml
				FROM `po_custom` a ;";				

$sql['count_po_number'] = "SELECT count(*) AS jml
						FROM `po_custom` a
						WHERE a.`sitehandler_id` = %s order by a.`customer_po_number`;";
				
$sql['select_po_number'] = "SELECT a.`customer_po_number`, a.`project_id`,
						CASE a.currency
							WHEN 'USD' THEN a.`actual_value_in_usd` 
							WHEN 'IDR' THEN a.`actual_value_in_idr` 
						END AS actual_price, 
						CASE a.currency  
							WHEN 'USD' THEN a.`value_in_usd_po` 
							WHEN 'IDR' THEN a.`value_in_idr_po` 
						END AS contract_price, 
			a.bast_value,  
			a.`currency`,
			a.`receipt_number`,
			a.`invoice_number`,
			a.`tax_form_number`,
			a.`approval_status`
			FROM `po_custom` a
			WHERE a.`sitehandler_id` = %s ORDER BY a.`customer_po_number` LIMIT %s OFFSET %s"; 
			
$sql['search_po_custom_count'] = "SELECT 
		COUNT(DISTINCT a.sitehandler_id)AS jml
	FROM `po_custom` a
	INNER JOIN `company` b ON b.`id` = a.`company_id`
	WHERE 1=1 %s ORDER BY a.`sitehandler_id`;";
				
$sql['search_po_custom'] = "SELECT DISTINCT sitehandler_id,
		b.`name`,
		a.site_id,a.site_name, a.far_end_site_id,
		a.far_end_site_name, a.site_id_actual, 
		CONCAT(a.technology,a.po_type)AS technology,
		a.site_name_actual,
		a.far_end_site_id_actual, a.far_end_site_name_actual, 
		a.`region` AS region_name, a.on_air_date, a.trigger_capitalization, 
		a.scope, a.reference_number
	FROM `po_custom` a
	INNER JOIN `company` b ON b.`id` = a.`company_id`
	WHERE 1=1 %s ORDER BY a.`sitehandler_id`;";
	


$sql['search_count_document'] = "SELECT COUNT(*)as jml 
	FROM `document` b where b.`sitehandler_id`=(select DISTINCT(sitehandler_id) from `po_custom` where sitehandler_id='%s');";	


$sql['search_document']	= "SELECT d.`typename` as name, d.`file_name`, d.path_file, d.`doc_date`, d.`doctype` FROM `document` d 
    WHERE d.`sitehandler_id`=(select DISTINCT(sitehandler_id) from `po_custom` where sitehandler_id='%s')
	ORDER BY d.`file_name` DESC;";

				
?>
