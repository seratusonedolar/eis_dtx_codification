<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2024-09-27 16:26:51 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:26:51 --> No URI present. Default controller set.
DEBUG - 2024-09-27 16:26:51 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:26:52 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:26:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:26:52 --> Total execution time: 0.0994
DEBUG - 2024-09-27 16:27:00 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:27:00 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:27:00 --> Total execution time: 0.1587
DEBUG - 2024-09-27 16:27:00 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:27:00 --> No URI present. Default controller set.
DEBUG - 2024-09-27 16:27:00 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:27:01 --> Total execution time: 0.3279
DEBUG - 2024-09-27 16:27:23 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:27:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:27:23 --> Total execution time: 0.0934
DEBUG - 2024-09-27 16:27:25 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:27:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:27:25 --> Total execution time: 0.1453
DEBUG - 2024-09-27 16:27:29 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:27:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:27:29 --> Total execution time: 0.1020
DEBUG - 2024-09-27 16:27:29 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:27:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:27:29 --> Total execution time: 0.1431
DEBUG - 2024-09-27 16:27:36 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:27:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:27:53 --> Total execution time: 16.2167
DEBUG - 2024-09-27 16:42:11 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:42:11 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:42:11 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:42:11 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-09-27 16:42:11 --> Query error: ERROR:  syntax error at or near ")"
LINE 3: ...atex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.d...
                                                             ^ - Invalid query: SELECT a.dtmitem_id, COUNT(a.dtmitem_id) as countitem 
					FROM datatex_m_item a join
					(select dtmitem_id from datatex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.dtmitem_id=b.dtmitem_id
					left join datatex_m_item_detail c on b.dtmitem_id=c.dtmitem_id
					WHERE a.dtmsubcode_id = 2 
					GROUP BY a.dtmitem_id;
ERROR - 2024-09-27 16:42:11 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\eis_datatex\application\controllers\eis\Datatech_approval.php 57
DEBUG - 2024-09-27 16:42:12 --> Total execution time: 1.2553
DEBUG - 2024-09-27 16:42:14 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:42:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:42:44 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:42:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:42:48 --> Total execution time: 33.7695
DEBUG - 2024-09-27 16:42:49 --> Total execution time: 5.3126
DEBUG - 2024-09-27 16:43:02 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:02 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:02 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:43:02 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-09-27 16:43:02 --> Query error: ERROR:  syntax error at or near ")"
LINE 3: ...atex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.d...
                                                             ^ - Invalid query: SELECT a.dtmitem_id, COUNT(a.dtmitem_id) as countitem 
					FROM datatex_m_item a join
					(select dtmitem_id from datatex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.dtmitem_id=b.dtmitem_id
					left join datatex_m_item_detail c on b.dtmitem_id=c.dtmitem_id
					WHERE a.dtmsubcode_id = 2 
					GROUP BY a.dtmitem_id;
ERROR - 2024-09-27 16:43:02 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\eis_datatex\application\controllers\eis\Datatech_approval.php 57
DEBUG - 2024-09-27 16:43:03 --> Total execution time: 0.0980
DEBUG - 2024-09-27 16:43:04 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:43:08 --> Total execution time: 4.2409
DEBUG - 2024-09-27 16:43:15 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:43:15 --> Total execution time: 0.1239
DEBUG - 2024-09-27 16:43:16 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:43:16 --> Total execution time: 0.0483
DEBUG - 2024-09-27 16:43:17 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:17 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:43:17 --> Total execution time: 0.0634
DEBUG - 2024-09-27 16:43:18 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:43:18 --> Total execution time: 0.0445
DEBUG - 2024-09-27 16:43:24 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:43:28 --> Total execution time: 3.9473
DEBUG - 2024-09-27 16:43:41 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:41 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:41 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:43:41 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:43:41 --> Total execution time: 0.0601
ERROR - 2024-09-27 16:43:41 --> Query error: ERROR:  syntax error at or near ")"
LINE 3: ...atex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.d...
                                                             ^ - Invalid query: SELECT a.dtmitem_id, COUNT(a.dtmitem_id) as countitem 
					FROM datatex_m_item a join
					(select dtmitem_id from datatex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.dtmitem_id=b.dtmitem_id
					left join datatex_m_item_detail c on b.dtmitem_id=c.dtmitem_id
					WHERE a.dtmsubcode_id = 2 
					GROUP BY a.dtmitem_id;
ERROR - 2024-09-27 16:43:41 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\eis_datatex\application\controllers\eis\Datatech_approval.php 57
DEBUG - 2024-09-27 16:43:43 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:43:43 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:43:47 --> Total execution time: 4.1473
DEBUG - 2024-09-27 16:44:16 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:44:16 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:44:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:44:16 --> Global POST, GET and COOKIE data sanitized
ERROR - 2024-09-27 16:44:16 --> Query error: ERROR:  syntax error at or near ")"
LINE 3: ...atex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.d...
                                                             ^ - Invalid query: SELECT a.dtmitem_id, COUNT(a.dtmitem_id) as countitem 
					FROM datatex_m_item a join
					(select dtmitem_id from datatex_m_item_detail where dtmsubcodehierarchy_id = ) b on a.dtmitem_id=b.dtmitem_id
					left join datatex_m_item_detail c on b.dtmitem_id=c.dtmitem_id
					WHERE a.dtmsubcode_id = 2 
					GROUP BY a.dtmitem_id;
ERROR - 2024-09-27 16:44:16 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\xampp\htdocs\eis_datatex\application\controllers\eis\Datatech_approval.php 57
DEBUG - 2024-09-27 16:44:17 --> Total execution time: 0.3396
DEBUG - 2024-09-27 16:44:18 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:44:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:44:22 --> Total execution time: 4.0710
DEBUG - 2024-09-27 16:50:19 --> UTF-8 Support Enabled
DEBUG - 2024-09-27 16:50:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2024-09-27 16:50:19 --> Total execution time: 0.1503
