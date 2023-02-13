create table comments (
    id int not null AUTO_INCREMENT,
    user_ID int unsigned default null,
    story_ID int not null,
    content longtext not null,
    link longtext not null,
    time timestamp not null DEFAULT current_timestamp() on update current_timestamp(),
    primary key(id, user_ID, story_ID),
    foreign key (user_ID) references users (id),
    foreign key (story_ID) references stories (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8