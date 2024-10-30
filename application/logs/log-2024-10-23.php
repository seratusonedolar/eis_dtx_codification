<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2024-10-23 13:59:20 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 13:59:20 --> No URI present. Default controller set.
DEBUG - 2024-10-23 13:59:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 13:59:21 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 13:59:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 13:59:21 --> Total execution time: 0.1667
DEBUG - 2024-10-23 13:59:46 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 13:59:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 13:59:46 --> Total execution time: 0.1538
DEBUG - 2024-10-23 13:59:46 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 13:59:46 --> No URI present. Default controller set.
DEBUG - 2024-10-23 13:59:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 13:59:47 --> Total execution time: 0.6401
DEBUG - 2024-10-23 13:59:53 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 13:59:53 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 13:59:54 --> Total execution time: 0.5110
DEBUG - 2024-10-23 14:00:06 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:00:06 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:00:06 --> Total execution time: 0.1446
DEBUG - 2024-10-23 14:00:13 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:00:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:00:13 --> Total execution time: 0.0398
DEBUG - 2024-10-23 14:00:15 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:00:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:00:15 --> Total execution time: 0.0945
DEBUG - 2024-10-23 14:00:15 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:00:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:00:15 --> Total execution time: 0.1741
DEBUG - 2024-10-23 14:00:19 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:00:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:00:28 --> Total execution time: 9.2805
DEBUG - 2024-10-23 14:00:38 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:00:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:00:38 --> Total execution time: 0.0523
DEBUG - 2024-10-23 14:00:41 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:00:41 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:00:42 --> Total execution time: 0.5555
DEBUG - 2024-10-23 14:01:01 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:01:01 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:01:01 --> Total execution time: 0.1095
DEBUG - 2024-10-23 14:01:09 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:01:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:01:09 --> Total execution time: 0.0897
DEBUG - 2024-10-23 14:02:55 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:02:55 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:02:55 --> Total execution time: 0.1140
DEBUG - 2024-10-23 14:03:03 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:03:03 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-10-23 14:03:04 --> Query error: ERROR:  syntax error at or near ")"
LINE 3: ...atex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.d...
                                                             ^ - Invalid query: SELECT a.dtmitem_id, COUNT(a.dtmitem_id) as countitem 
					FROM datatex_m_item a join
					(select dtmitem_id from datatex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.dtmitem_id=b.dtmitem_id
					left join datatex_m_item_detail c on b.dtmitem_id=c.dtmitem_id
					WHERE a.dtmsubcode_id = F/2/256183 
					GROUP BY a.dtmitem_id;
ERROR - 2024-10-23 14:03:04 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\eis_datatex\application\controllers\eis\Datatech_approval.php 57
DEBUG - 2024-10-23 14:03:12 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:03:12 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:03:12 --> Total execution time: 0.1212
DEBUG - 2024-10-23 14:03:13 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:03:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:03:13 --> Total execution time: 0.0546
DEBUG - 2024-10-23 14:03:14 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:03:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:03:15 --> Total execution time: 0.2101
DEBUG - 2024-10-23 14:03:17 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:03:17 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:03:19 --> Total execution time: 1.4210
DEBUG - 2024-10-23 14:03:29 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:03:29 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-10-23 14:03:29 --> Query error: ERROR:  syntax error at or near ")"
LINE 3: ...atex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.d...
                                                             ^ - Invalid query: SELECT a.dtmitem_id, COUNT(a.dtmitem_id) as countitem 
					FROM datatex_m_item a join
					(select dtmitem_id from datatex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.dtmitem_id=b.dtmitem_id
					left join datatex_m_item_detail c on b.dtmitem_id=c.dtmitem_id
					WHERE a.dtmsubcode_id = F/2/256183 
					GROUP BY a.dtmitem_id;
ERROR - 2024-10-23 14:03:29 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\eis_datatex\application\controllers\eis\Datatech_approval.php 57
DEBUG - 2024-10-23 14:05:19 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:05:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:05:19 --> Total execution time: 0.3652
DEBUG - 2024-10-23 14:05:45 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:05:45 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:05:45 --> Total execution time: 0.0840
DEBUG - 2024-10-23 14:05:46 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:05:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:05:47 --> Total execution time: 0.2683
DEBUG - 2024-10-23 14:05:47 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:05:47 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:05:48 --> Total execution time: 0.3062
DEBUG - 2024-10-23 14:05:50 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:05:50 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:05:53 --> Total execution time: 2.2707
DEBUG - 2024-10-23 14:06:15 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:06:15 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-10-23 14:06:15 --> Query error: ERROR:  syntax error at or near ")"
LINE 3: ...atex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.d...
                                                             ^ - Invalid query: SELECT a.dtmitem_id, COUNT(a.dtmitem_id) as countitem 
					FROM datatex_m_item a join
					(select dtmitem_id from datatex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.dtmitem_id=b.dtmitem_id
					left join datatex_m_item_detail c on b.dtmitem_id=c.dtmitem_id
					WHERE a.dtmsubcode_id =  
					GROUP BY a.dtmitem_id;
ERROR - 2024-10-23 14:06:15 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\eis_datatex\application\controllers\eis\Datatech_approval.php 57
DEBUG - 2024-10-23 14:06:32 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:06:32 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-10-23 14:06:32 --> Query error: ERROR:  syntax error at or near ")"
LINE 3: ...atex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.d...
                                                             ^ - Invalid query: SELECT a.dtmitem_id, COUNT(a.dtmitem_id) as countitem 
					FROM datatex_m_item a join
					(select dtmitem_id from datatex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.dtmitem_id=b.dtmitem_id
					left join datatex_m_item_detail c on b.dtmitem_id=c.dtmitem_id
					WHERE a.dtmsubcode_id =  
					GROUP BY a.dtmitem_id;
ERROR - 2024-10-23 14:06:32 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\eis_datatex\application\controllers\eis\Datatech_approval.php 57
DEBUG - 2024-10-23 14:08:36 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 14:08:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 14:08:37 --> Total execution time: 0.4182
DEBUG - 2024-10-23 16:12:21 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:12:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:12:21 --> Total execution time: 0.3182
DEBUG - 2024-10-23 16:12:24 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:12:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:12:24 --> Total execution time: 0.0411
DEBUG - 2024-10-23 16:12:26 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:12:26 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:12:27 --> Total execution time: 0.9834
DEBUG - 2024-10-23 16:12:34 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:12:34 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:12:35 --> Total execution time: 0.3196
DEBUG - 2024-10-23 16:13:09 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:13:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:13:10 --> Total execution time: 0.2013
DEBUG - 2024-10-23 16:13:39 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:13:39 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:13:39 --> Total execution time: 0.0584
DEBUG - 2024-10-23 16:13:39 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:13:39 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:13:39 --> Total execution time: 0.0817
DEBUG - 2024-10-23 16:13:49 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:13:49 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:13:49 --> Total execution time: 0.0485
DEBUG - 2024-10-23 16:13:49 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:13:49 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:13:49 --> Total execution time: 0.3916
DEBUG - 2024-10-23 16:13:53 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:13:53 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:13:56 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:13:56 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:13:56 --> Total execution time: 0.1028
DEBUG - 2024-10-23 16:14:04 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:14:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:14:04 --> Total execution time: 0.0744
DEBUG - 2024-10-23 16:14:13 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:14:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:14:13 --> Total execution time: 0.0495
DEBUG - 2024-10-23 16:14:20 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:14:20 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:14:20 --> Total execution time: 0.0510
DEBUG - 2024-10-23 16:14:22 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:14:22 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:14:22 --> Total execution time: 0.0541
DEBUG - 2024-10-23 16:14:22 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:14:22 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:14:23 --> Total execution time: 0.0512
DEBUG - 2024-10-23 16:14:25 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:14:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:14:26 --> Total execution time: 0.5760
DEBUG - 2024-10-23 16:14:36 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:14:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:14:36 --> Total execution time: 0.0820
DEBUG - 2024-10-23 16:23:23 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:23:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:23:23 --> Total execution time: 0.1110
DEBUG - 2024-10-23 16:23:25 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:23:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:23:25 --> Total execution time: 0.1094
DEBUG - 2024-10-23 16:23:41 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:23:41 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:23:42 --> Total execution time: 0.2800
DEBUG - 2024-10-23 16:24:00 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:24:00 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:24:10 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:24:10 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:24:10 --> Total execution time: 0.1054
DEBUG - 2024-10-23 16:25:16 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:25:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:25:16 --> Total execution time: 0.0912
DEBUG - 2024-10-23 16:25:20 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:25:20 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:25:20 --> Total execution time: 0.0613
DEBUG - 2024-10-23 16:25:21 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:25:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:25:21 --> Total execution time: 0.0455
DEBUG - 2024-10-23 16:25:22 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:25:22 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:25:22 --> Total execution time: 0.0575
DEBUG - 2024-10-23 16:25:24 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:25:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:25:25 --> Total execution time: 0.4735
DEBUG - 2024-10-23 16:39:17 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:39:17 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:39:17 --> Total execution time: 0.1699
DEBUG - 2024-10-23 16:43:50 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:43:50 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:43:50 --> Total execution time: 0.1636
DEBUG - 2024-10-23 16:43:53 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:43:53 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:43:53 --> Total execution time: 0.1197
DEBUG - 2024-10-23 16:43:57 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:43:57 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:43:57 --> Total execution time: 0.1107
DEBUG - 2024-10-23 16:44:04 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:44:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:44:04 --> Total execution time: 0.1099
DEBUG - 2024-10-23 16:44:06 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:44:06 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:44:06 --> Total execution time: 0.7228
DEBUG - 2024-10-23 16:44:19 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:44:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:44:19 --> Total execution time: 0.0619
DEBUG - 2024-10-23 16:44:25 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:44:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:44:25 --> Total execution time: 0.1020
DEBUG - 2024-10-23 16:44:33 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:44:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:44:33 --> Total execution time: 0.1091
DEBUG - 2024-10-23 16:44:35 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:44:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:44:35 --> Total execution time: 0.1041
DEBUG - 2024-10-23 16:44:36 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:44:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:44:37 --> Total execution time: 0.0724
DEBUG - 2024-10-23 16:45:08 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:45:08 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:45:08 --> Total execution time: 0.1106
DEBUG - 2024-10-23 16:49:10 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:49:10 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:49:10 --> Total execution time: 0.1048
DEBUG - 2024-10-23 16:49:13 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:49:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:49:13 --> Total execution time: 0.0525
DEBUG - 2024-10-23 16:49:14 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:49:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:49:14 --> Total execution time: 0.1778
DEBUG - 2024-10-23 16:49:15 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:49:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:49:15 --> Total execution time: 0.4177
DEBUG - 2024-10-23 16:49:18 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:49:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:49:19 --> Total execution time: 0.9428
DEBUG - 2024-10-23 16:50:30 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:50:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:50:30 --> Total execution time: 0.1022
DEBUG - 2024-10-23 16:50:34 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:50:34 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:50:34 --> Total execution time: 0.1140
DEBUG - 2024-10-23 16:50:41 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:50:41 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:50:41 --> Total execution time: 0.1354
DEBUG - 2024-10-23 16:50:43 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:50:43 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:50:43 --> Total execution time: 0.1076
DEBUG - 2024-10-23 16:50:45 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:50:45 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:50:45 --> Total execution time: 0.0468
DEBUG - 2024-10-23 16:50:54 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:50:54 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:50:54 --> Total execution time: 0.0477
DEBUG - 2024-10-23 16:50:58 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:50:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:50:58 --> Total execution time: 0.0605
DEBUG - 2024-10-23 16:51:01 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:51:01 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:51:01 --> Total execution time: 0.0990
DEBUG - 2024-10-23 16:52:40 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:52:40 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:52:40 --> Total execution time: 0.1052
DEBUG - 2024-10-23 16:52:46 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:52:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:52:46 --> Total execution time: 0.0499
DEBUG - 2024-10-23 16:52:47 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:52:47 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:52:47 --> Total execution time: 0.0911
DEBUG - 2024-10-23 16:52:55 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:52:55 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:52:55 --> Total execution time: 0.0472
DEBUG - 2024-10-23 16:52:56 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:52:56 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:52:56 --> Total execution time: 0.0546
DEBUG - 2024-10-23 16:53:09 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:53:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:53:09 --> Total execution time: 0.1127
DEBUG - 2024-10-23 16:53:13 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:53:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:53:13 --> Total execution time: 0.0564
DEBUG - 2024-10-23 16:53:16 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:53:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:53:16 --> Total execution time: 0.0656
DEBUG - 2024-10-23 16:53:49 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:53:49 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:53:50 --> Total execution time: 0.0892
DEBUG - 2024-10-23 16:54:19 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:54:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:54:19 --> Total execution time: 0.1068
DEBUG - 2024-10-23 16:54:25 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:54:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:54:25 --> Total execution time: 0.0562
DEBUG - 2024-10-23 16:54:26 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:54:26 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:54:26 --> Total execution time: 0.0563
DEBUG - 2024-10-23 16:54:27 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:54:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:54:27 --> Total execution time: 0.0382
DEBUG - 2024-10-23 16:54:30 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:54:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:54:30 --> Total execution time: 0.1227
DEBUG - 2024-10-23 16:59:59 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 16:59:59 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 16:59:59 --> Total execution time: 0.1293
DEBUG - 2024-10-23 17:00:37 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:00:37 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:00:37 --> Total execution time: 0.0945
DEBUG - 2024-10-23 17:00:38 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:00:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:00:39 --> Total execution time: 0.1002
DEBUG - 2024-10-23 17:00:52 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:00:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:00:52 --> Total execution time: 0.1204
DEBUG - 2024-10-23 17:01:25 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:01:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:01:25 --> Total execution time: 0.1078
DEBUG - 2024-10-23 17:02:48 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:02:48 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:02:48 --> Total execution time: 0.1073
DEBUG - 2024-10-23 17:02:54 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:02:55 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:02:55 --> Total execution time: 0.0983
DEBUG - 2024-10-23 17:02:56 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:02:56 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:02:56 --> Total execution time: 0.1359
DEBUG - 2024-10-23 17:03:00 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:03:00 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:03:00 --> Total execution time: 0.1133
DEBUG - 2024-10-23 17:03:32 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:03:32 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:03:32 --> Total execution time: 0.0948
DEBUG - 2024-10-23 17:03:39 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:03:39 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:03:39 --> Total execution time: 0.0983
DEBUG - 2024-10-23 17:04:55 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:04:55 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:04:55 --> Total execution time: 0.1071
DEBUG - 2024-10-23 17:05:27 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:05:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:05:27 --> Total execution time: 0.1182
DEBUG - 2024-10-23 17:06:26 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:06:26 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:06:26 --> Total execution time: 0.0955
DEBUG - 2024-10-23 17:07:34 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:07:34 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:07:34 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:07:34 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:07:34 --> Total execution time: 0.1369
DEBUG - 2024-10-23 17:07:34 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:07:34 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:07:34 --> Total execution time: 0.0996
DEBUG - 2024-10-23 17:07:38 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:07:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:07:38 --> Total execution time: 0.1179
DEBUG - 2024-10-23 17:07:38 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:07:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:07:38 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:07:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:07:38 --> Total execution time: 0.1185
DEBUG - 2024-10-23 17:07:38 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:07:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:07:38 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:07:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:07:38 --> Total execution time: 0.0861
ERROR - 2024-10-23 17:07:38 --> Unable to connect to the database
ERROR - 2024-10-23 17:07:38 --> Severity: error --> Exception: Call to a member function quote() on bool C:\xampp\htdocs\eis_datatex\system\database\drivers\pdo\pdo_driver.php 243
DEBUG - 2024-10-23 17:07:40 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:07:40 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:07:40 --> Total execution time: 0.1001
DEBUG - 2024-10-23 17:07:54 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:07:54 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:07:54 --> Total execution time: 0.0984
DEBUG - 2024-10-23 17:08:51 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:08:51 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:08:51 --> Total execution time: 0.1076
DEBUG - 2024-10-23 17:09:05 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:09:05 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:09:05 --> Total execution time: 0.1236
DEBUG - 2024-10-23 17:09:15 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:09:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:09:15 --> Total execution time: 0.1262
DEBUG - 2024-10-23 17:09:31 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:09:31 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:09:31 --> Total execution time: 0.1443
DEBUG - 2024-10-23 17:09:36 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:09:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:09:38 --> Total execution time: 2.1140
DEBUG - 2024-10-23 17:09:51 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:09:51 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-10-23 17:09:51 --> 404 Page Not Found: eis/Datatex_approval/index
DEBUG - 2024-10-23 17:10:07 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:10:07 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:10:07 --> Total execution time: 0.0917
DEBUG - 2024-10-23 17:10:21 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:10:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:10:21 --> Total execution time: 0.0943
DEBUG - 2024-10-23 17:10:26 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:10:26 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:10:26 --> Total execution time: 0.1031
DEBUG - 2024-10-23 17:11:13 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:13 --> Total execution time: 0.1114
DEBUG - 2024-10-23 17:11:15 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:15 --> Total execution time: 0.0958
DEBUG - 2024-10-23 17:11:16 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:16 --> Total execution time: 0.0866
DEBUG - 2024-10-23 17:11:17 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:17 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:17 --> Total execution time: 0.1068
DEBUG - 2024-10-23 17:11:18 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:18 --> Total execution time: 0.1025
DEBUG - 2024-10-23 17:11:19 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:19 --> Total execution time: 0.1038
DEBUG - 2024-10-23 17:11:22 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:22 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:22 --> Total execution time: 0.0482
DEBUG - 2024-10-23 17:11:23 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:23 --> Total execution time: 0.0586
DEBUG - 2024-10-23 17:11:24 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:24 --> Total execution time: 0.0838
DEBUG - 2024-10-23 17:11:26 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:26 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:26 --> Total execution time: 0.1074
DEBUG - 2024-10-23 17:11:28 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:28 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:28 --> Total execution time: 0.0982
DEBUG - 2024-10-23 17:11:31 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:11:31 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:11:31 --> Total execution time: 0.1081
DEBUG - 2024-10-23 17:13:15 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:13:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:13:15 --> Total execution time: 0.1004
DEBUG - 2024-10-23 17:13:19 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:13:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:13:19 --> Total execution time: 0.0966
DEBUG - 2024-10-23 17:13:24 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:13:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:13:24 --> Total execution time: 0.0408
DEBUG - 2024-10-23 17:13:24 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:13:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:13:25 --> Total execution time: 0.0525
DEBUG - 2024-10-23 17:13:25 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:13:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:13:25 --> Total execution time: 0.0511
DEBUG - 2024-10-23 17:13:32 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:13:32 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:13:32 --> Total execution time: 0.0787
DEBUG - 2024-10-23 17:13:58 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:13:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:13:58 --> Total execution time: 0.1126
DEBUG - 2024-10-23 17:14:02 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:14:02 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:14:02 --> Total execution time: 0.0530
DEBUG - 2024-10-23 17:14:03 --> UTF-8 Support Enabled
DEBUG - 2024-10-23 17:14:03 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-10-23 17:14:03 --> Total execution time: 0.0510
