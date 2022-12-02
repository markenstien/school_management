drop table if exists task_submissions;
create table task_submissions(
    id int(10) not null primary key auto_increment,
    task_id int(10),
    user_id int(10),
    user_score smallint,
    status enum('approved','unapproved','denied') default 'unapproved',
    created_at timestamp default now()
);