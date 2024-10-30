CREATE TABLE public.datatex_scope_item_sync (
	scopeitemsync_id varchar(10) NOT NULL,
	scopeitemsync_timestamp timestamp NULL,
	scopeitemsync_string varchar(100) NULL,
	CONSTRAINT datatex_scope_item_sync_pk PRIMARY KEY (scopeitemsync_id)
);

INSERT INTO public.datatex_scope_item_sync
(scopeitemsync_id, scopeitemsync_timestamp, scopeitemsync_string)
VALUES('ITEMSCOPE', NULL, 'T;F');
INSERT INTO public.datatex_scope_item_sync
(scopeitemsync_id, scopeitemsync_timestamp, scopeitemsync_string)
VALUES('LASTSYNC', '2023-11-23 17:00:58.450', NULL);
