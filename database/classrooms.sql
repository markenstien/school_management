drop table if exists classrooms;
create table classrooms(
    id int(10) not null PRIMARY KEY AUTO_INCREMENT,
    reference_code varchar(50) unique,
    join_code varchar(50),
    class_code varchar(50) unique,
    class_name varchar(100),
    description text,
    teacher_id int(10) not null,
    is_active boolean DEFAULT true,
    created_at timestamp DEFAULT now(),
    theme char(5),
    updated_at timestamp DEFAULT now() ON UPDATE now()
);

/*
*class room views
*/

drop view v_total_student;

CREATE VIEW v_total_student as SELECT count(id) as total, class_id
    FROM class_students
    GROUP BY class_id;