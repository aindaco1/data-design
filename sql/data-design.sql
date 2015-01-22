DROP TABLE IF EXISTS albumArtist;
DROP TABLE IF EXISTS albumStyles;
DROP TABLE IF EXISTS albumGenre;
DROP TABLE IF EXISTS styles;
DROP TABLE IF EXISTS genre;
DROP TABLE IF EXISTS awards;
DROP TABLE IF EXISTS credits;
DROP TABLE IF EXISTS artist;
DROP TABLE IF EXISTS album;

CREATE TABLE album (
	albumId           INT UNSIGNED AUTO_INCREMENT NOT NULL,
	albumAllmusicPick BOOLEAN                     NOT NULL,
	allmusicRating    TINYINT UNSIGNED            NOT NULL,
	duration          VARCHAR(16)                 NOT NULL,
	recordingDate     DATE                        NOT NULL,
	releaseDate       DATE                        NOT NULL,
	releaseYear       YEAR                        NOT NULL,
	streamBuy         VARCHAR(1024),
	INDEX(albumId),
	PRIMARY KEY (albumId)
);

CREATE TABLE artist (
	artistId          INT UNSIGNED AUTO_INCREMENT NOT NULL,
	artistDescription VARCHAR(128)                NOT NULL,
	INDEX(artistId),
	PRIMARY KEY (artistId)
);

CREATE TABLE credits (
	albumId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	artistId INT UNSIGNED NOT NULL,
	credits VARCHAR(128),
	INDEX(albumId),
	INDEX(artistId),
	FOREIGN KEY(artistId) REFERENCES artist(artistId),
	FOREIGN KEY(albumId) REFERENCES album(albumId),
	PRIMARY KEY(albumId)
);

CREATE TABLE awards (
	albumId  INT UNSIGNED NOT NULL,
	awardsId INT UNSIGNED AUTO_INCREMENT          NOT NULL,
	awardsYear  SMALLINT UNSIGNED NOT NULL,
	awardsTitle  VARCHAR(128) NOT NULL,
	INDEX (albumId),
	INDEX (awardsId),
	UNIQUE (albumId, awardsYear, awardsTitle),
	FOREIGN KEY (albumId) REFERENCES album (albumId),
	PRIMARY KEY (awardsId)
);

CREATE TABLE genre (
	genreId          INT UNSIGNED AUTO_INCREMENT NOT NULL,
	genreDescription VARCHAR(128)                NOT NULL,
	PRIMARY KEY (genreId)
);

CREATE TABLE styles (
	stylesId          INT UNSIGNED AUTO_INCREMENT NOT NULL,
	stylesDescription VARCHAR(128)                NOT NULL,
	PRIMARY KEY (stylesId)
);

CREATE TABLE albumArtist (
	albumId INT UNSIGNED NOT NULL,
	artistId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	INDEX(albumId),
	INDEX(artistId),
	FOREIGN KEY(artistId) REFERENCES artist(artistId),
	FOREIGN KEY(albumId) REFERENCES album(albumId),
	PRIMARY KEY(artistId, albumId)
);

CREATE TABLE albumStyles (
	albumId INT UNSIGNED NOT NULL,
	stylesId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	INDEX(albumId),
	INDEX(stylesId),
	FOREIGN KEY(stylesId) REFERENCES styles(stylesId),
	FOREIGN KEY(albumId) REFERENCES album(albumId),
	PRIMARY KEY(stylesId, albumId)
);

CREATE TABLE albumGenre (
	albumId INT UNSIGNED NOT NULL,
	genreId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	INDEX(albumId),
	INDEX(genreId),
	FOREIGN KEY(genreId) REFERENCES genre(genreId),
	FOREIGN KEY(albumId) REFERENCES album(albumId),
	PRIMARY KEY(genreId, albumId)
);

