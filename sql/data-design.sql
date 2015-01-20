-- this is a comment is SQL (yes, space is needed)

DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS tweet;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	email VARCHAR(128) NOT NULL,
	phone VARCHAR(32),
	atHandle VARCHAR(32),
	PRIMARY KEY(profileId)
);

CREATE TABLE tweet (
	tweetId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileId INT UNSIGNED NOT NULL,
	tweetContent VARCHAR(140) NOT NULL,
	tweetDate DATETIME NOT NULL,
	INDEX(profileId),
	FOREIGN KEY(profileId) REFERENCES profile(profileId),
	PRIMARY KEY(tweetId)
);

CREATE TABLE favorite (
	profileId INT UNSIGNED NOT NULL,
	tweetId INT UNSIGNED NOT NULL,
	favoriteDate DATETIME NOT NULL,
	INDEX(profileId),
	INDEX(tweetId),
	FOREIGN KEY(profileId) REFERENCES profile(profileId),
	PRIMARY KEY(profileId, tweetId)
);