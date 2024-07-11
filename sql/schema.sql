-- t_comments definition

-- Drop table

-- DROP TABLE t_comments;

CREATE TABLE t_comments
(
    id             serial4 NOT NULL,
    username       varchar NULL,
    user_id        int4 NULL,
    website        varchar NULL,
    email          varchar NULL,
    "content"      varchar NOT NULL,
    created_at     timestamp NULL,
    updated_at     timestamp NULL,
    memo_id        int4    NOT NULL,
    reply_user_id  int4 NULL,
    reply_username varchar NULL,
    CONSTRAINT t_comments_pk PRIMARY KEY (id)
);


-- t_likes definition

-- Drop table

-- DROP TABLE t_likes;

CREATE TABLE t_likes
(
    id         serial4 NOT NULL,
    user_id    int4    NOT NULL,
    memo_id    int4    NOT NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    CONSTRAINT t_likes_pk PRIMARY KEY (id),
    CONSTRAINT t_likes_pk_2 UNIQUE (user_id, memo_id)
);


-- t_memos definition

-- Drop table

-- DROP TABLE t_memos;

CREATE TABLE t_memos
(
    id            serial4 NOT NULL,
    content_html  varchar NULL,
    imgs          _text NULL,
    fav_count     int4 DEFAULT 0 NULL,
    comment_count int4 DEFAULT 0 NULL,
    user_id       int4 NULL,
    pinned        bool NULL,
    "permission"  int4 NULL,
    ext           jsonb NULL,
    created_at    timestamp NULL,
    updated_at    timestamp NULL,
    tags          _text NULL,
    content_md    varchar NULL,
    CONSTRAINT t_memos_pk PRIMARY KEY (id)
);


-- t_sys_config definition

-- Drop table

-- DROP TABLE t_sys_config;

CREATE TABLE t_sys_config
(
    id            serial4 NOT NULL,
    theme         varchar NULL,
    website_title varchar NULL,
    favicon       varchar NULL,
    config        json NULL,
    created_at    timestamp NULL,
    updated_at    timestamp NULL,
    CONSTRAINT t_sys_config_pk PRIMARY KEY (id)
);


-- t_users definition

-- Drop table

-- DROP TABLE t_users;

CREATE TABLE t_users
(
    id         serial4 NOT NULL,
    username   varchar NOT NULL,
    nickname   varchar NOT NULL,
    "password" varchar NULL,
    avatar_url varchar NULL,
    slogan     varchar NULL,
    cover_url  varchar NULL,
    config     json NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP NULL,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP NULL,
    email      varchar NULL,
    CONSTRAINT t_users_pk PRIMARY KEY (id),
    CONSTRAINT t_users_unique_nickname UNIQUE (nickname),
    CONSTRAINT t_users_unique_username UNIQUE (username)
);