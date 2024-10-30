-- public.datatex_m_item_log definition

-- Drop table

-- DROP TABLE public.datatex_m_item_log;

CREATE TABLE public.datatex_m_item_log (
	dtmitemlog_id bigserial NOT NULL,
	dtmitemlog_data text NULL,
	dtmitemlog_action varchar(30) NULL,
	dtmitemlog_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	dtmitemlog_created_by int4 NULL,
	CONSTRAINT datatex_m_item_log_pk PRIMARY KEY (dtmitemlog_id)
);


-- public.datatex_m_role definition

-- Drop table

-- DROP TABLE public.datatex_m_role;

CREATE TABLE public.datatex_m_role (
	dtmrole_id bigserial NOT NULL,
	dtmrole_name varchar(100) NULL,
	dtmrole_desc text NULL,
	dtmrole_is_active int2 NULL DEFAULT 1,
	dtmrole_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT datatex_m_role_pk PRIMARY KEY (dtmrole_id)
);


-- public.datatex_m_subcode definition

-- Drop table

-- DROP TABLE public.datatex_m_subcode;

CREATE TABLE public.datatex_m_subcode (
	dtmsubcode_id bigserial NOT NULL,
	dtmsubcode_name varchar(100) NULL,
	dtmsubcode_parent int8 NULL,
	dtmsubcode_level int4 NULL,
	dtmsubcode_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	dtmsubcode_is_active int4 NULL DEFAULT 1,
	dtmsubcode_code varchar(10) NULL,
	dtmsubcode_updated_at timestamp NULL,
	CONSTRAINT datatech_m_subcode_pk PRIMARY KEY (dtmsubcode_id)
);


-- public.datatex_scope_item definition

-- Drop table

-- DROP TABLE public.datatex_scope_item;

CREATE TABLE public.datatex_scope_item (
	dtscopeitem_id bigserial NOT NULL,
	item_id bpchar(16) NULL,
	dtscopeitem_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	dtscopeitem_buyer_ids text NULL,
	CONSTRAINT datatex_scope_item_pk PRIMARY KEY (dtscopeitem_id),
	CONSTRAINT datatex_scope_item_un UNIQUE (item_id)
);


-- public.datatex_m_role_permission definition

-- Drop table

-- DROP TABLE public.datatex_m_role_permission;

CREATE TABLE public.datatex_m_role_permission (
	dtmrolepermission_id bigserial NOT NULL,
	dtmrole_id int8 NULL,
	dtmrolepermission_name varchar(150) NULL,
	dtmrolepermission_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT datatex_m_role_permission_pk PRIMARY KEY (dtmrolepermission_id),
	CONSTRAINT datatex_m_role_permission_fk FOREIGN KEY (dtmrole_id) REFERENCES public.datatex_m_role(dtmrole_id)
);


-- public.datatex_m_role_user definition

-- Drop table

-- DROP TABLE public.datatex_m_role_user;

CREATE TABLE public.datatex_m_role_user (
	dtmroleuser_id bigserial NOT NULL,
	dtmrole_id int8 NULL,
	user_id int4 NULL,
	dtmroleuser_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT datatex_m_role_user_pk PRIMARY KEY (dtmroleuser_id),
	CONSTRAINT datatex_m_role_user_un UNIQUE (user_id),
	CONSTRAINT datatex_m_role_user_fk FOREIGN KEY (dtmrole_id) REFERENCES public.datatex_m_role(dtmrole_id)
);


-- public.datatex_m_subcode_detail definition

-- Drop table

-- DROP TABLE public.datatex_m_subcode_detail;

CREATE TABLE public.datatex_m_subcode_detail (
	dtmsubcodedtl_id bigserial NOT NULL,
	dtmsubcodedtl_seq int4 NULL,
	dtmsubcodedtl_type varchar(100) NULL,
	dtmsubcodedtl_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	dtmsubcode_id int8 NULL,
	dtmsubcode_option_id int8 NULL,
	dtmsubcodedtl_parent int8 NULL,
	dtmsubcodedtl_remark varchar(100) NULL,
	dtmsubcodedtl_updated_at timestamp NULL,
	dtmsubcodedtl_is_required bool NULL DEFAULT true,
	CONSTRAINT datatech_m_subcode_detail_pk PRIMARY KEY (dtmsubcodedtl_id),
	CONSTRAINT datatech_m_subcode_detail_fk FOREIGN KEY (dtmsubcode_id) REFERENCES public.datatex_m_subcode(dtmsubcode_id),
	CONSTRAINT datatech_m_subcode_detail_fk2 FOREIGN KEY (dtmsubcode_option_id) REFERENCES public.datatex_m_subcode(dtmsubcode_id)
);


-- public.datatex_m_subcode_hierarchy definition

-- Drop table

-- DROP TABLE public.datatex_m_subcode_hierarchy;

CREATE TABLE public.datatex_m_subcode_hierarchy (
	dtmsubcodehierarchy_id bigserial NOT NULL,
	dtmsubcodehierarchy_code varchar(10) NULL,
	dtmsubcodehierarchy_name varchar(200) NULL,
	dtmsubcodehierarchy_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	dtmsubcode_id int8 NULL,
	dtmsubcodehierarchy_is_active int4 NULL DEFAULT 1,
	dtmsubcodehierarchy_parent int8 NULL,
	dtmsubcodehierarchy_updated_at timestamp NULL,
	dtmsubcodehierarchy_user_id int4 NULL,
	dtmsubcodehierarchy_state varchar(10) NULL DEFAULT 'pending'::character varying,
	CONSTRAINT datatech_m_subcode_hierarchy_pk PRIMARY KEY (dtmsubcodehierarchy_id),
	CONSTRAINT datatech_m_subcode_hierarchy_fk FOREIGN KEY (dtmsubcode_id) REFERENCES public.datatex_m_subcode(dtmsubcode_id)
);


-- public.datatex_m_subcode_tech_information definition

-- Drop table

-- DROP TABLE public.datatex_m_subcode_tech_information;

CREATE TABLE public.datatex_m_subcode_tech_information (
	dtmsubcodetechinf_id bigserial NOT NULL,
	dtmsubcodetechinf_seq int4 NULL,
	dtmsubcodetechinf_remark varchar NULL,
	dtmsubcodetechinf_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	dtmsubcodetechinf_updated_at timestamp NULL,
	dtmsubcodetechinf_user_id int4 NULL,
	dtmsubcode_id int8 NULL,
	dtmsubcodetechinf_is_required bool NULL DEFAULT false,
	CONSTRAINT datatex_m_subcode_tech_information_pk PRIMARY KEY (dtmsubcodetechinf_id),
	CONSTRAINT datatex_m_subcode_tech_information_fk FOREIGN KEY (dtmsubcode_id) REFERENCES public.datatex_m_subcode(dtmsubcode_id)
);


-- public.datatex_m_subcode_tech_inf_hierarchy definition

-- Drop table

-- DROP TABLE public.datatex_m_subcode_tech_inf_hierarchy;

CREATE TABLE public.datatex_m_subcode_tech_inf_hierarchy (
	dtmsubcodetechinfhierarchy_id int8 NOT NULL DEFAULT nextval('datatex_m_subcode_tech_inf_hi_dtmsubcodetechinfhierarchy_id_seq'::regclass),
	dtmsubcodetechinfhierarchy_code varchar(10) NULL,
	dtmsubcodetechinfhierarchy_name text NULL,
	dtmsubcodetechinfhierarchy_is_active bool NULL,
	dtmsubcodetechinfhierarchy_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	dtmsubcodetechinfhierarchy_user_id int4 NULL,
	dtmsubcodetechinf_id int8 NULL,
	dtmsubcodetechinfhierarchy_updated_at timestamp NULL,
	CONSTRAINT datatex_m_subcode_tech_inf_hierarchy_pk PRIMARY KEY (dtmsubcodetechinfhierarchy_id),
	CONSTRAINT datatex_m_subcode_tech_inf_hierarchy_fk FOREIGN KEY (dtmsubcodetechinf_id) REFERENCES public.datatex_m_subcode_tech_information(dtmsubcodetechinf_id)
);


-- public.datatex_m_item definition

-- Drop table

-- DROP TABLE public.datatex_m_item;

CREATE TABLE public.datatex_m_item (
	dtmitem_id bigserial NOT NULL,
	item_id bpchar(16) NULL,
	dtmitem_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	dtmsubcode_id int8 NULL,
	dtmitem_code varchar(200) NULL,
	dtmitem_created_by int4 NULL,
	dtmitem_updated_at timestamp NULL,
	dtmitem_updated_by int4 NULL,
	dtmitem_uom_id bpchar(3) NULL,
	dtmitem_description text NULL,
	CONSTRAINT datatech_m_item_pk PRIMARY KEY (dtmitem_id)
);


-- public.datatex_m_item_detail definition

-- Drop table

-- DROP TABLE public.datatex_m_item_detail;

CREATE TABLE public.datatex_m_item_detail (
	dtmitemdtl_id bigserial NOT NULL,
	dtmitem_id int8 NULL,
	dtmsubcodedtl_id int8 NULL,
	dtmsubcodehierarchy_id int8 NULL,
	dtmitemdtl_code varchar(20) NULL,
	dtmitemdtl_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT datatech_m_item_detail_pk PRIMARY KEY (dtmitemdtl_id)
);


-- public.datatex_m_item_tech_information definition

-- Drop table

-- DROP TABLE public.datatex_m_item_tech_information;

CREATE TABLE public.datatex_m_item_tech_information (
	dtmitemtechinf_id bigserial NOT NULL,
	dtmitem_id int8 NULL,
	dtmsubcodetechinf_id int8 NULL,
	dtmitemtechinf_note text NULL,
	dtmitemtechinf_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	dtmsubcodetechinfhierarchy_id int8 NULL,
	CONSTRAINT datatex_m_item_tech_information_pk PRIMARY KEY (dtmitemtechinf_id)
);


-- public.datatex_m_item foreign keys

ALTER TABLE public.datatex_m_item ADD CONSTRAINT datatech_m_item_fk FOREIGN KEY (dtmsubcode_id) REFERENCES public.datatex_m_subcode(dtmsubcode_id);
ALTER TABLE public.datatex_m_item ADD CONSTRAINT datatex_m_item_fk FOREIGN KEY (dtmitem_uom_id) REFERENCES public.m_um(um_id);


-- public.datatex_m_item_detail foreign keys

ALTER TABLE public.datatex_m_item_detail ADD CONSTRAINT datatech_m_item_detail_fk FOREIGN KEY (dtmitem_id) REFERENCES public.datatex_m_item(dtmitem_id) ON DELETE CASCADE;
ALTER TABLE public.datatex_m_item_detail ADD CONSTRAINT datatech_m_item_detail_fk_1 FOREIGN KEY (dtmsubcodedtl_id) REFERENCES public.datatex_m_subcode_detail(dtmsubcodedtl_id);
ALTER TABLE public.datatex_m_item_detail ADD CONSTRAINT datatech_m_item_detail_fk_2 FOREIGN KEY (dtmsubcodehierarchy_id) REFERENCES public.datatex_m_subcode_hierarchy(dtmsubcodehierarchy_id);


-- public.datatex_m_item_tech_information foreign keys

ALTER TABLE public.datatex_m_item_tech_information ADD CONSTRAINT datatex_m_item_tech_information_fk FOREIGN KEY (dtmitem_id) REFERENCES public.datatex_m_item(dtmitem_id) ON DELETE CASCADE;
ALTER TABLE public.datatex_m_item_tech_information ADD CONSTRAINT datatex_m_item_tech_information_fk2 FOREIGN KEY (dtmsubcodetechinf_id) REFERENCES public.datatex_m_subcode_tech_information(dtmsubcodetechinf_id);
ALTER TABLE public.datatex_m_item_tech_information ADD CONSTRAINT datatex_m_item_tech_information_fk3 FOREIGN KEY (dtmsubcodetechinfhierarchy_id) REFERENCES public.datatex_m_subcode_tech_inf_hierarchy(dtmsubcodetechinfhierarchy_id);