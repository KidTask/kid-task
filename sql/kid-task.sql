DROP TABLE step;
DROP TABLE task;
DROP TABLE kid;
DROP TABLE adult;

CREATE TABLE adult (
	adultId binary(16) not null,
	adultActivationToken char(32),
	adultAvatarUrl varchar(255),
	adultCloudinaryToken varchar(255),
	adultEmail varchar(128) not null,
	adultHash char(97) not null,
	adultName nvarchar(255),
	adultUsername varchar(32) not null,
	unique (adultEmail),
	unique(adultUsername),
	index(adultEmail),
	primary key(adultId)
);

CREATE TABLE kid (
	kidId binary(16) not null,
	kidAdultId binary(16) not null,
	kidAvatarUrl varchar(255),
	kidCloudinaryToken VARCHAR(255),
	kidHash char(97) not null,
	kidName nvarchar(255),
	kidUsername varchar(32) not null,
	unique (kidUsername),
	index(kidAdultId),
	foreign key(kidAdultId) references adult(adultId),
	primary key(kidId)
);

CREATE TABLE task (
	taskId binary(16) not null ,
	taskAdultId binary(16) not null,
	taskKidId binary(16) not null,
	taskAvatarUrl VARCHAR(255),
	taskCloudinaryToken VARCHAR(255),
	taskContent VARCHAR(255) not null,
	taskDueDate DATETIME(6),
	taskIsComplete TINYINT,
	taskReward varchar(255),
	index(taskAdultId),
	index (taskKidId),
	foreign key(taskKidId) references kid(kidId),
	foreign key(taskAdultId) references adult(adultId),
	primary key(taskId)
);

CREATE TABLE step (
	stepId binary(16) not null,
	stepTaskId binary(16) not null,
	stepContent varchar(255) not null,
	stepOrder SMALLINT,
	index(stepTaskId),
	foreign key(stepTaskId) references task(taskId),
	primary key(stepId)
);


