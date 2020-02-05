CREATE TABLE parent (
	parentId binary(16) not null,
	parentActivationToken char(32),
	parentEmail varchar(128) not null,
	parentHash char(96) not null,
	parentName nvarchar(255),
	parentUsername varchar(32) not null,
	unique (parentEmail),
	unique(parentUsername),
	index(parentEmail),
	primary key(parentId)
);

CREATE TABLE kid (
	kidId binary(16) not null,
	kidParentId binary(16) not null,
	kidAvatarUrl varchar(255),
	kidHash char(96) not null,
	kidName nvarchar(255),
	kidUsername varchar(32) not null,
	unique (kidUsername),
	index(kidParentId),
	foreign key(kidParentId) references parent(parentId),
	primary key(kidId)
);

CREATE TABLE task (
	taskId binary(16) not null ,
	taskParentId binary(16) not null,
	taskKidId binary(16) not null,
	taskContent varchar(1000),
	taskDueDate DATETIME(6),
	taskIsComplete TINYINT,
	taskReward varchar(255),
	index(taskParentId),
	index (taskKidId),
	foreign key(taskParentId) references parent(parentId),
	foreign key(taskKidId) references kid(kidId),
	primary key(taskId)
);

CREATE TABLE step (
	stepId binary(16) not null,
	stepTaskId binary(16) not null,
	stepContent varchar(1000),
	stepOrder SMALLINT,
	index(stepTaskId),
	foreign key(stepTaskId) references task(taskId),
	primary key(stepId)
);

