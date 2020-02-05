CREATE TABLE parent (
	parentId binary(16) not null,
	parentActivationToken char(32),
	parentUsername varchar(32) not null,
	parentEmail varchar(128) not null,
	parentHash char(96) not null,
	unique (parentEmail),
	unique(parentUsername),
	primary key(parentId)
);

CREATE TABLE kid (
	kidId binary(16) not null,
	kidParentId binary(16) not null,
	kidUsername varchar(32) not null,
	kidName nvarchar(255),
	kidAvatarUrl varchar(255),
	kidHash char(96) not null,
	unique (kidUsername),
	foreign key(kidParentId) references parent(parentId),
	primary key(kidId)
);

CREATE TABLE task (
	taskId binary(16) not null ,
	taskParentId binary(16) not null,
	taskKidId binary(16) not null,
	taskContent varchar(1000),
	taskDueDate DATETIME(6),
	taskIsComplete boolean,
	taskReward varchar(255),
	foreign key(taskParentId) references parent(parentId),
	foreign key(taskKidId) references kid(kidId),
	primary key(taskId)
);

CREATE TABLE step (
	stepId binary(16) not null,
	stepTaskId binary(16) not null,
	stepOrder SMALLINT,
	stepContent varchar(1000),
	foreign key(stepTaskId) references task(taskId),
	primary key(stepId)
);

