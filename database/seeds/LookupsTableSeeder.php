<?php

use Illuminate\Database\Seeder;

class LookupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lookups')->insert([

                [
                    'id' => "1",
                    'name' => 'Test Lookup',
                    'sql' => 'SELECT * FROM MANUFACTURED_PRODUCTS WHERE part_no IN ({WHERE_TOKEN},{WHERE_TOKEN},{ANOTHER_TOKEN})',
                    'area' => 'test',
                ],
                [
                    'id' => "2",
                    'name' => 'Pallet Shortage',
                    'sql' => 'select sq_2.part_no,sq_2.catalog_desc, NVL(sq_4.cartons,0) - (sq_2.qty_pick_reported / pec.units_per_l1)  difference,
sq_2.contract,
sq_2.order_no,
sq_2.pick_list_no,
NVL(sq_4.cartons,0) qty_on_pallet,
sq_2.qty_pick_reported / pec.units_per_l1 qty_pick_reported,
sq_3.qty_ordered / pec.units_per_l1 qty_ordered,
--sq_4.cartons - (sq_2.qty_pick_reported / pec.units_per_l1)  difference,
case when NVL(sq_4.cartons,0) - (sq_2.qty_pick_reported / pec.units_per_l1) < 0 then \'danger\' else null end row_highlight


from (select  sq_1.contract,
              sq_1.order_no,
              sq_1.pick_list_no,
              sq_1.catalog_no part_no,
              sq_1.catalog_desc,
              sum(sq_1.qty_pick_reported) qty_pick_reported
              from (select 
                    plj.contract,
                    plj.order_no,
                    plj.pick_list_no,
                    plj.catalog_no,
                    plj.catalog_desc,
                    case when plj.qty_picked = 0 then plj.qty_shipped else plj.qty_picked end qty_pick_reported
                    from ifsapp.create_pick_list_join_new plj
                    --where plj.pick_list_no = \'417236\'
                   where plj.order_no =  \'{WHERE_TOKEN}\'
                   --where plj.order_no =  \'&WHERE_TOKEN\'
                    ) sq_1
              group by sq_1.contract,sq_1.order_no,sq_1.pick_list_no,sq_1.catalog_no,sq_1.catalog_desc
              ) sq_2
              
left outer join  (select 
                 col.contract,
                 col.order_no,
                 col.part_no,                
                 sum(case when col.qty_invoiced = 0 then qty_on_order else col.qty_invoiced end) qty_ordered
                 from ifsinfo.cc_customer_order_line col 
                 where col.order_no =  \'{WHERE_TOKEN}\'
                 group by col.contract,col.order_no,col.part_no
                ) sq_3

on sq_2.contract = sq_3.contract
and sq_2.order_no = sq_3.order_no
and sq_2.part_no = sq_3.part_no


left outer join (select 
                  cpl.pallet_no,
                  cpl.pick_list_no,
                  cpl.order_no,
                  cpl.part_no,
                  sum(cpl.quantity) quantity,
                  sum(cpl.cartons) cartons
                  from ifsapp.chc_pallet_lines cpl
                  -- remove the lines that are non IFS products
                  where cpl.part_type <> \'NONIFS\'
                  and cpl.order_no  =  \'{WHERE_TOKEN}\'
                  group by cpl.pallet_no,cpl.pick_list_no,cpl.order_no,cpl.part_no
            ) sq_4

on sq_2.order_no = sq_4.order_no
and sq_2.part_no = sq_4.part_no
left outer join ccapp.part_ext_cat pec
on sq_2.part_no = pec.part_no
order by difference asc
                    ',
                    'area' => 'other',
                ],
                [
                    'id' => "3",
                    'name' => 'Top 20',
                    'sql' => 'SELECT * FROM MANUFACTURED_PRODUCTS WHERE ROWNUM < 20',
                    'area' => 'test',
                ],


                [
                    'id' => "4",
                    'name' => 'Pallet Shortages',
                    'sql' => '
                    select sq_3.part_no,sq_3.catalog_desc, NVL(sq_4.cartons,0) - (nvl(sq_2.qty_pick_reported,0) / pec.units_per_l1)  difference,

sq_2.contract,
sq_2.order_no,
sq_2.pick_list_no,
NVL(sq_4.cartons,0) qty_on_pallet,
nvl(sq_2.qty_pick_reported / pec.units_per_l1,0) qty_pick_reported,
sq_3.qty_ordered / pec.units_per_l1 qty_ordered,
--sq_4.cartons - (sq_2.qty_pick_reported / pec.units_per_l1)  difference,

case when 
  nvl(sq_2.qty_pick_reported,0) = 0
  then \'alert-warning\' else
case when NVL(sq_4.cartons,0) - (sq_2.qty_pick_reported / pec.units_per_l1) < 0 then \'alert-danger\' else null end end row_highlight


from   (select 
                 col.contract,
                 col.order_no,
                 col.part_no,
                 col.catalog_desc,                
                 sum(case when col.qty_invoiced = 0 then col.buy_qty_due
                 else col.qty_invoiced end) qty_ordered
                 from ifsinfo.cc_customer_order_line col 
                 where col.order_no IN ({WHERE_TOKEN})
                 --where col.order_no IN (\'&WHERE_TOKEN\')
                 and col.objstate in ( \'Picked\',\'Released\')
                 
                 group by col.contract,col.order_no,col.part_no,col.catalog_desc
                ) sq_3

left outer join (select  sq_1.contract,
              sq_1.order_no,
              sq_1.pick_list_no,
              sq_1.catalog_no part_no,
              sq_1.catalog_desc,
              sum(sq_1.qty_pick_reported) qty_pick_reported
              from (select 
                    plj.contract,
                    plj.order_no,
                    plj.pick_list_no,
                    plj.catalog_no,
                    plj.catalog_desc,
                    case when plj.qty_picked = 0 then plj.qty_shipped else plj.qty_picked end qty_pick_reported
                    from ifsapp.create_pick_list_join_new plj
                   where plj.order_no IN ({WHERE_TOKEN})
                   --where plj.order_no IN (\'&WHERE_TOKEN\')
                    ) sq_1
              group by sq_1.contract,sq_1.order_no,sq_1.pick_list_no,sq_1.catalog_no,sq_1.catalog_desc
              ) sq_2


on sq_3.contract = sq_2.contract
and sq_3.order_no = sq_2.order_no
and sq_3.part_no = sq_2.part_no


left outer join (select 
                  cpl.pallet_no,
                  cpl.pick_list_no,
                  cpl.order_no,
                  cpl.part_no,
                  sum(cpl.quantity) quantity,
                  sum(cpl.cartons) cartons
                  from ifsapp.chc_pallet_lines cpl
                  -- remove the lines that are non IFS products
                  where cpl.part_type <> \'NONIFS\'
                  and cpl.order_no  IN ({WHERE_TOKEN})
                  --and cpl.order_no  IN (\'&WHERE_TOKEN\')
                  
                  group by cpl.pallet_no,cpl.pick_list_no,cpl.order_no,cpl.part_no
            ) sq_4

on sq_2.order_no = sq_4.order_no
and sq_2.part_no = sq_4.part_no

left outer join ccapp.part_ext_cat pec
on sq_3.part_no = pec.part_no

order by difference asc
                    ',
                    'area' => 'test',
                ],

                [
                    'id' => "5",
                    'name' => 'Find Manifest number',
                    'sql' => 'select
mt.manifest_no,
mt.pick_list_no,
mt.order_no,
mt.quantity
from ifsapp.chc_manifest_temp_wf mt
where mt.order_no in ({WHERE_TOKEN})',
                    'area' => 'test',
                ],

                [
                    'id' => "6",
                    'name' => 'Shipping Information Order No',
                    'sql' => 'select
to_date(substr(cm.objversion,1,8),\'YYYY/MM/DD\') pallet_date,
cm.manifest_no,
pl.pallet_no,
max(pl.order_no) order_no,
sum(pl.cartons) Carton_qty,
max(cm.pallet_height) * 100 pallet_height,
max(cm.pallet_width) * 100 pallet_width,
max(cm.pallet_length)  * 100 pallet_length,
max(cm.pallet_weight) pallet_weight,
max(cm.pallet_type) pallet_type,
sum(sample_count) other_items,
max(co.customer_no) Customer_no,
max(c.customer_name) Customer

from ifsapp.chc_pallet_lines pl
left outer join ifsapp.chc_manifest cm
on pl.pallet_no  = cm.pallet_no

left outer join (select 
                  pl.pallet_no,
                  count(pl.pallet_no) Sample_count 
                  from ifsapp.chc_pallet_lines pl
                  where pl.part_no in (select upper(ci.cf$_pri_information) info
                                      from ifsapp.c_c1795_palletisation_info_clv ci
                                      where ci.cf$_type_db = \'PRODUCT\')
                  group by pl.pallet_no
                  ) sq_1

on pl.pallet_no = sq_1.pallet_no
left outer join ifsinfo.cc_customer_order co
on pl.order_no = co.order_no
left outer join ifsinfo.customers c
on co.customer_no = c.customer_no
where pl.order_no in ({WHERE_TOKEN})
group by cm.objversion,cm.manifest_no,pl.pallet_no',
                    'area' => 'test',
                ],

                [
                    'id' => "7",
                    'name' => 'Shipping Information Customer Account',
                    'sql' => 'select
to_date(substr(cm.objversion,1,8),\'YYYY/MM/DD\') pallet_date,
cm.manifest_no,
pl.pallet_no,
max(pl.order_no) order_no,
sum(pl.cartons) Carton_qty,
max(cm.pallet_height) * 100 pallet_height,
max(cm.pallet_width) * 100 pallet_width,
max(cm.pallet_length)  * 100 pallet_length,
max(cm.pallet_weight) pallet_weight,
max(cm.pallet_type) pallet_type,
sum(sample_count) other_items,
max(co.customer_no) Customer_no,
max(c.customer_name) Customer

from ifsapp.chc_pallet_lines pl
left outer join ifsapp.chc_manifest cm
on pl.pallet_no  = cm.pallet_no

left outer join (select 
                  pl.pallet_no,
                  count(pl.pallet_no) Sample_count 
                  from ifsapp.chc_pallet_lines pl
                  where pl.part_no in (select upper(ci.cf$_pri_information) info
                                      from ifsapp.c_c1795_palletisation_info_clv ci
                                      where ci.cf$_type_db = \'PRODUCT\')
                  group by pl.pallet_no
                  ) sq_1
on pl.pallet_no = sq_1.pallet_no
left outer join ifsinfo.cc_customer_order co
on pl.order_no = co.order_no
left outer join ifsinfo.customers c
on co.customer_no = c.customer_no
where co.customer_no in ({WHERE_TOKEN})
--and to_date(to_char(sysdate,\'YYYY/MM/DD\'),\'YYYY/MM/DD\')-1 = to_date(substr(cm.objversion,1,8),\'YYYY/MM/DD\')
group by cm.objversion,cm.manifest_no,pl.pallet_no',
                    'area' => 'test',
                ],

                [
                    'id' => "8",
                    'name' => 'Shipping test',
                    'sql' => 'select 
sq_3.pallet_date,
sq_3.manifest_no,
sq_3.pallet_no,
-- sq_3.order_no entered_order,
sq_3.Carton_qty,
sq_3.pallet_height,
sq_3.pallet_width,
sq_3.pallet_length,
sq_3.pallet_weight,
sq_3.pallet_type,
sq_3.other_items,
sq_3.Customer_no,
sq_3.Customer,
sq_6.order_list,
null as alert_field


from (

select
to_date(substr(cm.objversion,1,8),\'YYYY/MM/DD\') pallet_date,
cm.manifest_no,
pl.pallet_no,
max(pl.order_no) order_no,
sum(pl.cartons) Carton_qty,
max(cm.pallet_height) * 100 pallet_height,
max(cm.pallet_width) * 100 pallet_width,
max(cm.pallet_length)  * 100 pallet_length,
max(cm.pallet_weight) pallet_weight,
max(cm.pallet_type) pallet_type,
sum(sample_count) other_items,
max(co.customer_no) Customer_no,
max(c.customer_name) Customer

from ifsapp.chc_pallet_lines pl
left outer join ifsapp.chc_manifest cm
on pl.pallet_no  = cm.pallet_no

left outer join (select 
                  pl.pallet_no,
                  count(pl.pallet_no) Sample_count 
                  from ifsapp.chc_pallet_lines pl
                  where pl.part_no in (select upper(ci.cf$_pri_information) info
                                      from ifsapp.c_c1795_palletisation_info_clv ci
                                      where ci.cf$_type_db = \'PRODUCT\')
                  group by pl.pallet_no
                  ) sq_1

on pl.pallet_no = sq_1.pallet_no
left outer join ifsinfo.cc_customer_order co
on pl.order_no = co.order_no
left outer join ifsinfo.customers c
on co.customer_no = c.customer_no

where pl.pallet_no in (select distinct pl.pallet_no 
                        from ifsapp.chc_pallet_lines pl
                        where pl.order_no in ({WHERE_TOKEN})
                        --where pl.order_no in (\'&WHERE_TOKEN\')
                     )
group by cm.objversion,cm.manifest_no,pl.pallet_no 
) sq_3 

left outer join (select sq_6.order_no,substr(sys_connect_by_path ( sq_6.order_no,\';\'),2) order_list
                  from (
                          select sq_5.order_no, row_number () over (order by sq_5.order_no) rn, count(*) over () cnt
                                from (select distinct pl.order_no
                                      from ifsapp.chc_pallet_lines pl
                                      where pl.pallet_no in (select distinct pl.pallet_no 
                                                              from ifsapp.chc_pallet_lines pl
                                                              where pl.order_no in ({WHERE_TOKEN})
                                                              --where pl.order_no in (\'&WHERE_TOKEN\')
                                                             ) 
                                     ) sq_5
                        ) sq_6
                  where rn = sq_6.cnt
                  start with sq_6.rn = 1
                  connect by sq_6.rn = prior sq_6.rn + 1                   
                 ) sq_6
                
on sq_3.order_no = sq_6.order_no',
                    'area' => 'test',
                ],

                [
                    'id' => "9",
                    'name' => 'Palletise Overview',
                    'sql' => 'select 
sq_2.order_no,
sq_2.customer_no,
sq_2.name,
sq_2.cartons_picked,
sq_3.cartons cartons_palletised,
sq_4.activity_date,
sq_3.palletised_by,
sq_3.cartons - nvl(sq_2.cartons_picked,0) difference,
case when nvl(sq_3.cartons,0) - nvl(sq_2.cartons_picked,0) <> 0 then \'alert-danger\' else null end alert

from (
select
--sq_1.last_activity_date,
sq_1.order_no,
sq_1.customer_no,
sq_1.name,
--cor.part_no,
sum(sq_1.qty_picked) qty_picked,
sum(sq_1.cartons) cartons_picked
from (

select 
--to_char(cor.last_activity_date,\'DDMMYY\') last_activity_date,
cor.order_no,
co.customer_no,
ci.name,
cor.part_no,
cor.qty_picked,

cor.qty_picked / ipp.mul_order_qty cartons,
sd.cf$_carrier_code

from ifsapp.customer_order_reservation cor 
left outer join ifsapp.customer_order_cfv co
on cor.order_no = co.order_no
left outer join ifsapp.c_c1795__service__delivery_clv sd
on co.cf$_servicedeliverytype_db  = sd.objid

left outer join ifsapp.customer_info ci
on co.customer_no = ci.customer_id
left outer join ifsapp.inventory_part_planning ipp
on cor.part_no = ipp.part_no
and cor.contract = ipp.contract


where cor.contract = \'DO\'
and cor.qty_picked > 0
and nvl(sd.cf$_carrier_code,\'XX\') not in (\'XDP\',\'DHL\',\'APC\')

--order by cor.last_activity_date desc,cor.order_no,ci.customer_id

) sq_1
group by sq_1.order_no,sq_1.customer_no,sq_1.name
) sq_2
 left outer join (select 
                  pl.order_no,
                  sum(pl.cartons) cartons,
                  max(m.palletised_by) palletised_by
 
                  from ifsapp.chc_pallet_lines pl
                  left outer join ifsapp.chc_manifest m
                  on pl.pallet_no = m.pallet_no
                  group by pl.order_no
                  ) sq_3
on sq_2.order_no = sq_3.order_no

left outer join (select cor_2.order_no,
                 max(cor_2.last_activity_date) activity_date 
                 from ifsapp.customer_order_reservation cor_2
                 where cor_2.contract = \'DO\'
                 and cor_2.qty_picked > 0 
                 group by cor_2.order_no
                 ) sq_4
on sq_2.order_no = sq_4.order_no


order by sq_4.activity_date  desc ,sq_2.order_no,sq_2.customer_no,sq_2.name

',
                    'area' => 'test',
                ]

            ]

        );
    }
}
