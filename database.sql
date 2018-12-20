create table users
(
    user_id int not null auto_increment,
    user_name varchar(255),
    user_password varchar(255),
    constraint pk_users primary key (user_id)
);

create table user_sessions
(
    session_id int not null auto_increment,
    session_uuid varchar(36),
    constraint pk_sessions primary key (session_id)
);

create table content
(
    content_id int not null auto_increment,
    filename varchar(255) not null,
    constraint pk_content primary key (content_id)
);

create table project_type
(
    project_type_id int not null,
    project_type_name varchar(255) not null,
    constraint pk_project_type primary key (project_type_id)
);

create table project
(
    project_id int not null auto_increment,
    project_type_id int not null,
    project_name varchar(255) not null,
    constraint pk_ primary key (project_id),
    constraint fk_annotation_annotation_type foreign key (project_type_id) references annotation_type(project_type_id)
);

create table annotation_categories
(
    category_id int not null auto_increment,
    category_name varchar(255) not null,
    constraint pk_annotation_categories primary key (category_id)
);

create table content_annotation
(
    user_id int not null,
    content_id int not null,
    category_id int not null,
    constraint pk_content_annotation primary key (user_id, content_id, category_id),
    constraint fk_content_annotation_user_id foreign key (user_id) references users(user_id),
    constraint fk_content_annotation_content_id foreign key (content_id) references content(content_id),
    constraint fk_content_annotation_category_id foreign key (category_id) references annotation_categories(category_id)
);

create table user_session
(
    user_id int not null,
    session_id int not null,
    constraint pk_user_session primary key (user_id, session_id),
    constraint fk_user_user_session foreign key (user_id) references users(user_id),
    constraint fk_session_user_session foreign key (session_id) references sessions(session_id)
);