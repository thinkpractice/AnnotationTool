use annotations;

-- Drop tables if they already exist
drop table if exists user_session;
drop table if exists content_annotation;
drop table if exists users;
drop table if exists sessions;
drop table if exists content;
drop table if exists annotation_items;
drop table if exists annotation_type;
drop table if exists project_type;
drop table if exists project;

-- (Re-)create the database schema
create table users
(
    user_id int not null,
    user_name varchar(255),
    user_password varchar(255),
    constraint pk_users primary key (user_id)
);

create table sessions
(
    session_id int not null,
    session_uuid varchar(36),
    session_start datetime,
    constraint pk_sessions primary key (session_id)
);

create table user_session
(
    user_id int not null,
    session_id int not null,
    constraint pk_user_session primary key (user_id, session_id),
    constraint fk_user_user_session foreign key (user_id) references users(user_id),
    constraint fk_session_user_session foreign key (session_id) references sessions(session_id)
);

create table project_type
(
    project_type_id int not null,
    project_type_name varchar(255) not null,
    constraint pk_project_type primary key (project_type_id)
);

create table annotation_type
(
    annotation_type_id int not null,
    project_type_id int not null,
    annotation_type_name varchar(255) not null,
    constraint pk_annotation_type primary key (annotation_type_id),
    constraint fk_project_type_id foreign key (project_type_id) references project_type (project_type_id)
);

create table project
(
    project_id int not null,
    project_type_id int not null,
    annotation_type_id int not null,
    project_name varchar(255) not null,
    constraint pk_project_id primary key (project_id),
    constraint fk_project_project_type foreign key (project_type_id) references project_type(project_type_id),
    constraint fk_project_annotation_type foreign key (annotation_type_id) references annotation_type(annotation_type_id)
);

create table annotation_items
(
    annotation_item_id int not null, 
    annotation_type_id int not null, 
    item_name varchar(255) not null,
    constraint pk_annotation_items primary key (annotation_item_id),    
    constraint fk_annotation_items foreign key (annotation_type_id) references annotation_type(annotation_type_id)
);

create table content
(
    content_id int not null,
    project_id int not null,
    content_filename varchar(255) not null,
    constraint pk_content primary key (content_id),
    constraint fk_content_project foreign key (project_id) references project (project_id)
);

create table content_annotation
(
    user_id int not null,
    content_id int not null,
    annotation_item_id int not null,
    constraint pk_content_annotation primary key (user_id, content_id, annotation_item_id),
    constraint fk_content_annotation_user_id foreign key (user_id) references users(user_id),
    constraint fk_content_annotation_content_id foreign key (content_id) references content(content_id),
    constraint fk_content_annotation_annotation_items foreign key (annotation_item_id) references annotation_items(annotation_item_id)
);

insert into project_type values (1, 'tile_tagging');
insert into annotation_type (annotation_type_id, project_type_id, annotation_type_name) values (1, 1, 'solar_panels');
insert into annotation_items (annotation_item_id, annotation_type_id, item_name) values (1, 1, "Unknown"), (2, 1, "No Solar Panels"), (3, 1, "Solar Panels");
insert into project (project_id, project_type_id, annotation_type_id, project_name) values (1, 1, 1, 'DeepSolaris Tile Tagging');
