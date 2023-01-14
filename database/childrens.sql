create table children(
    id int(10) not null PRIMARY key AUTO_INCREMENT,
    parent_id int(10),
    child_id int(10),
    created_at timestamp DEFAULT now()
);