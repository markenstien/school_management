drop table if exists class_students;
create table class_students(
    id int(10) not null PRIMARY KEY AUTO_INCREMENT,
    class_id int(10) not null,
    student_id int(10) not null,
    joined_by enum('code','direct-invite') DEFAULT 'direct-invite',
    created_at timestamp DEFAULT now(),
    is_active boolean DEFAULT true
);