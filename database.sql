create table users
(
    user_id int not null auto_increment,
    user_name varchar(255),
    password varchar(255),
    constraint pk_users primary key (user_id)
);

create table sessions
(
    session_id int not null auto_increment,
    session_uuid varchar(36),
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

create table content
(
    content_id int not null auto_increment,
    filename varchar(255) not null,
    constraint pk_content primary key (content_id)
);