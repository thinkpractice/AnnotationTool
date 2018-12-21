use annotations;

-- Drop tables if they already exist
drop table if exists user_session;
drop table if exists content_annotation;
drop table if exists user_projects;
drop table if exists users;
drop table if exists sessions;
drop table if exists content;
drop table if exists annotation_items;
drop table if exists project;
drop table if exists annotation_type;
drop table if exists project_type;

-- Drop functions if they already exist
drop function if exists login_user;
drop function if exists prolong_session;
drop function if exists is_valid_session;


-- (Re-)create the database schema
create table users
(
    user_id int not null,
    user_name varchar(255),
    user_password_hash varchar(255),
    constraint pk_users primary key (user_id)
);

create table sessions
(
    session_id int not null,
    session_uuid char(36),
    session_start datetime,
    session_end datetime,
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

create table user_projects
(
    project_id int not null,
    user_id int not null,
    constraint pk_user_projects primary key (project_id, user_id),
    constraint fk_user_projects_project foreign key (project_id) references project(project_id),
    constraint fk_user_projects_user foreign key (user_id) references users(user_id)
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

-- Stored procedures and functions
delimiter $$

-- create function login_user(user_name varchar(255)) returns char(36)
-- begin

-- end;

create function is_valid_session(uuid char(36)) 
returns boolean deterministic
begin
    declare session_valid_until datetime default '2017-04-27 00:00:00';
    select session_end into session_valid_until from sessions where session_uuid = uuid;
    return current_timestamp() <= session_valid_until;
end$$

create procedure prolong_session(uuid char(36))
begin
    if (is_valid_session(uuid)) then        
        update sessions 
        set session_end = date_add(now(), INTERVAL 5 MINUTE)
        where session_uuid = uuid;
    end if;
end$$

delimiter ;

-- Insert some default values into the database
insert into project_type values (1, 'tile_tagging');
insert into annotation_type (annotation_type_id, project_type_id, annotation_type_name) values (1, 1, 'solar_panels');
insert into annotation_items (annotation_item_id, annotation_type_id, item_name) values (1, 1, "Unknown"), (2, 1, "No Solar Panels"), (3, 1, "Solar Panels");
insert into project (project_id, project_type_id, annotation_type_id, project_name) values (1, 1, 1, 'DeepSolaris Tile Tagging');
