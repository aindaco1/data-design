-- this is a comment is SQL (yes, space is needed)

DROP TABLE IF EXISTS album;
DROP TABLE IF EXISTS albumGenre;
DROP TABLE IF EXISTS genre;
DROP TABLE IF EXISTS albumStyles;
DROP TABLE IF EXISTS styles;
DROP TABLE IF EXISTS albumArtist;
DROP TABLE IF EXISTS artist;
DROP TABLE IF EXISTS credits;

CREATE TABLE album (
	albumId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	duration VARCHAR(16) NOT NULL,
	albumAllmusicPick BOOLEAN NOT NULL,
	streamBuy VARCHAR(1024),
	allmusicRating INT UNSIGNED NOT NULL,
	releaseDate DATE NOT NULL,
	releaseYear VARCHAR(4) NOT NULL,
	recordingDate DATE NOT NULL,
	PRIMARY KEY(albumId)
);

CREATE TABLE genre (
	genreId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	genreDescription VARCHAR(128) NOT NULL,
	PRIMARY KEY(genreId)
);

CREATE TABLE artist (
	artistId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	artistName VARCHAR(256) NOT NULL,
	PRIMARY KEY(artistId)
);


CREATE TABLE credits (
	credits VARCHAR(128),
	albumId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	artistId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	INDEX(albumId),
	INDEX(artistId),
	FOREIGN KEY(artistId) REFERENCES artist(artistId),
	FOREIGN KEY(albumId) REFERENCES album(albumId),
	PRIMARY KEY(artistId, albumId)
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