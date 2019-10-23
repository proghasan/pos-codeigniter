// stock 

SELECT *,((total_purchase_qty +total_sale_return_qty) - (total_purchase_return_qty +total_sale_qty) ) as stock FROM(
SELECT
 p.product_name,
 p.product_code,
 pd.group_id,
 pd.purchase_rate,
 pd.sale_rate,
 IFNULL(SUM(pd.qty),0) as total_purchase_qty,
 IFNULL(SUM(pr.qty),0) as total_purchase_return_qty,
 IFNULL(SUM(sd.qty),0) as total_sale_qty,
 IFNULL(SUM(sr.qty),0) as total_sale_return_qty,
 pd.branch

FROM tbl_purchases_details as pd
LEFT JOIN tbl_products as p ON p.product_id = pd.product_id AND p.is_deleted = 0 AND p.branch = 1
LEFT JOIN tbl_groups as g ON g.id = pd.group_id AND g.is_deleted = 0 AND g.branch =1
LEFT JOIN tbl_purchase_return as pr on pr.product_id= pd.product_id AND pr.group_id = pd.group_id AND pr.is_deleted = 0 AND pr.branch =1
LEFT JOIN tbl_sale_details as sd ON sd.product_id = pd.product_id AND sd.group_id =pd.group_id AND sd.is_deleted = 0 AND sd.branch = 1
LEFT JOIN tbl_sale_return as sr ON sr.product_id = pd.product_id AND sr.group_id = pd.group_id AND sr.is_deleted =0

WHERE pd.is_deleted = 0
AND pd.branch =1
GROUP BY pd.product_id,pd.group_id
) as t WHERE ( (t.total_purchase_qty+t.total_sale_return_qty) - (t.total_purchase_return_qty +t.total_sale_qty) ) > 0