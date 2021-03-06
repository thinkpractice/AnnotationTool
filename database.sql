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
drop function if exists get_user_id;
drop function if exists session_for;
drop function if exists create_session;
drop function if exists is_valid_project_for_user;
drop procedure if exists prolong_session;
drop function if exists user_for;
drop function if exists is_valid_session;
drop procedure if exists empty_result;
drop procedure if exists get_projects;

-- (Re-)create the database schema
create table users
(
    user_id int not null auto_increment,
    user_name varchar(255),
    user_password_hash varchar(255),
    constraint pk_users primary key (user_id)
);

create table sessions
(
    session_id int not null auto_increment,
    user_id int not null,
    session_uuid char(36),
    session_start datetime,
    session_end datetime,
    constraint pk_sessions primary key (session_id),
    constraint fk_user_user_session foreign key (user_id) references users(user_id)
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
    user_id int not null,
    project_id int not null,    
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

create function get_user_id(user_name varchar(255), user_password_hash varchar(255))
returns boolean deterministic
begin
    declare user_id int default -1;
    select user_id into user_id from users
    where user_name = user_name and user_password_hash = user_password_hash;

    return user_id;
end$$

create function create_session(user_id)
returns char(36) deterministic
begin
    declare session_hash char(36) default null;
    set session_hash := uuid();
    insert into sessions (user_id, session_uuid, session_start, session_end)
    values (user_id, session_hash, now(), date_add(now(), INTERVAL 20 MINUTE));
    return session_hash;
end$$

create function session_for(user_id int)
returns char(36) deterministic
begin
    declare session_id int default -1;
    declare session_hash char(36) default null;
    
    select s.session_id into session_id, s.session_uuid into session_hash 
    from sessions as s 
    where s.session_id = us.session_id and s.user_id = user_id;

    if (session_id is not null and not is_valid_session(user_id))
        delete from sessions where session_id = session_id and user_id = user_id;
        set session_hash := null;
    end if;

    if (isnull(session_hash)) then
        session_hash = create_session(user_id);
    end if;

    return session_hash;
end$$

create function login_user(user_name varchar(255), user_password_hash varchar(255)) 
returns char(36) deterministic
begin
    declare user_id int default -1;
    declare session_hash char(36) default null;
    set user_id := get_user_id(user_name, user_password_hash);
    if (user_id > -1) then
        set session_hash := session_for(user_id);
    end if;
    return session_hash; 
end$$

create function hash_for(user_name varchar(255))
returns varchar(255) deterministic
begin
    declare user_password_hash varchar(255) default null;
    select user_password_hash into user_password_hash
    from users 
    where user_name = user_name;

    return user_password_hash;
end$$

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

create function user_for(uuid char(36))
returns int deterministic
begin
    declare user_id int default -1;
    if (is_valid_session(uuid)) then
        select user_id into user_id        
        from user_session as us
        inner join sessions as s
        on us.user_id = s.user_id and s.session_uuid = uuid;
    end if;    
    return user_id;
end$$


create procedure empty_result()  
begin
    select 1 from dual where false;
end$$

create procedure get_projects(uuid char(36))
begin
    if (is_valid_session(uuid)) then
        select p.project_name from projects as p
        inner join user_projects as up
        on p.project_id = up.project_id and up.user_id = user_for(uuid);
        call prolong_session(uuid);
    end if;
    call empty_result();
end$$

create function is_valid_project_for_user(uuid char (36), project_id int)
returns boolean deterministic
begin
    declare project_id int default null;
    declare is_valid_project boolean default false;
    if (is_valid_session(uuid)) then
        select p.project_id into project_id from projects as p
        inner join user_projects as up
        on p.project_id = up.project_id and up.user_id = user_for(uuid)
        where p.project_id = project_id;
        
        call prolong_session(uuid);
        if (project_id is not null) then
            set is_valid_project := true;
        end if;
    end if;
    return is_valid_project;
end$$

delimiter ;

-- Insert some default values into the database
insert into project_type values (1, 'tile_tagging');
insert into annotation_type (annotation_type_id, project_type_id, annotation_type_name) values (1, 1, 'solar_panels');
insert into annotation_items (annotation_item_id, annotation_type_id, item_name) values (1, 1, "Unknown"), (2, 1, "No Solar Panels"), (3, 1, "Solar Panels");
insert into project (project_id, project_type_id, annotation_type_id, project_name) values (1, 1, 1, 'DeepSolaris Tile Tagging');
