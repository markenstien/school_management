truncate children;

alter table children
	add constraint fk_parent_id FOREIGN KEY (parent_id) REFERENCES users(id),
	add constraint fk_child_id FOREIGN KEY (child_id) REFERENCES users(id);


truncate class_students;
alter table class_students
	add constraint fk_class_id FOREIGN KEY (class_id) REFERENCES classrooms(id),
	add constraint fk_student_id FOREIGN KEY (student_id) REFERENCES users(id);



truncate feed_comments;
alter table feed_comments
	add constraint fk_feed_id FOREIGN KEY (feed_id) REFERENCES feeds(id),
	add constraint fk_user_id FOREIGN KEY (user_id) REFERENCES users(id);



truncate tasks;
alter table tasks
	add constraint fk_parent_id FOREIGN KEY (parent_id) REFERENCES classrooms(id),
	add constraint fk_created_by FOREIGN KEY (created_by) REFERENCES users(id);


truncate feeds;
alter table feeds
	add constraint fk_owner_id FOREIGN KEY (owner_id) REFERENCES users(id);


truncate task_submissions;
alter table task_submissions
	add constraint fk_task_id FOREIGN KEY (task_id) REFERENCES tasks(id),
	add constraint fk_task_user_id FOREIGN KEY (user_id) REFERENCES users(id);

	

-- ALTER TABLE task_submissions DROP FOREIGN KEY fk_user_id;
