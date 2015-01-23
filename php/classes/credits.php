<?php

/**
 * Credits for an album as represented on allmusic.com
 *
 * This class represents credits for an album as represented on allmusic.com.
 *
 * @author Alonso Indacochea <alonso@hermesdevelopment.com>
 **/
class Credits {
	/**
	 * id for credits; this is the primary key
	 **/
	private $creditsId;
	/**
	 * id of the album with the credits; this is a foreign key
	 **/
	private $albumId;
	/**
	 * id of the artist credited; this is a foreign key
	 **/
	private $artistId;
	/**
	 * description of the credits
	 **/
	private $creditsDescription;

	/**
	 * constructor for this Award
	 *
	 * @param mixed $newCreditsID id of this Credits
	 * @param mixed $newAlbumId id of the Album with Credits
	 * @param mixed $newCreditsDescription description of the Credits
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 **/
	public function __construct($newCreditsID, $newAlbumId, $newArtistId, $newCreditsDescription) {
		try {
			$this->setCreditsId($newCreditsID);
			$this->setAlbumId($newAlbumId);
			$this->setArtistId($newArtistId);
			$this->setCreditsDescription($newCreditsDescription);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		}
	}
	/**
	 * accessor method for credits id
	 *
	 * @return mixed value of credits id
	 **/
	public function getCreditsId() {
		return ($this->creditsId);
	}

	/**
	 * mutator method for credits id
	 *
	 * @param mixed $newAwardsId new value of credits id
	 * @throws InvalidArgumentException if $newCreditsID is not an integer
	 * @throws RangeException if $newCreditsID is not positive
	 **/
	public function setCreditsId($newCreditsID) {
		if($newCreditsID === null) {
			$this->creditsId = null;
			return;
		}
		// verify the credits id is valid
		$newCreditsID = filter_var($newCreditsID, FILTER_VALIDATE_INT);
		if($newCreditsID === false) {
			throw(new InvalidArgumentException("credits id is not a valid integer"));
		}
		// verify the credits id is positive
		if($newCreditsID <= 0) {
			throw(new RangeException("credits id is not positive"));
		}
		// convert and store the credits id
		$this->creditsId = intval($newCreditsID);
	}
	/**
	 * accessor method for album id
	 *
	 * @return mixed value of album id
	 **/
	public function getAlbumId() {
		return ($this->albumId);
	}

	/**
	 * mutator method for album id
	 *
	 * @param mixed $newAlbumId new value of album id
	 * @throws InvalidArgumentException if $newAlbumId is not an integer
	 * @throws RangeException if $newAlbumId is not positive
	 **/
	public function setAlbumId($newAlbumId) {
		if($newAlbumId === null) {
			$this->albumId = null;
			return;
		}
		// verify the album id is valid
		$newAlbumId = filter_var($newAlbumId, FILTER_VALIDATE_INT);
		if($newAlbumId === false) {
			throw(new InvalidArgumentException("album id is not a valid integer"));
		}
		// verify the album id is positive
		if($newAlbumId <= 0) {
			throw(new RangeException("album id is not positive"));
		}
		// convert and store the album id
		$this->albumId = intval($newAlbumId);
	}
	/**
	 * accessor method for artist id
	 *
	 * @return mixed value of artist id
	 **/
	public function getArtistId() {
		return ($this->artistId);
	}

	/**
	 * mutator method for artist id
	 *
	 * @param mixed $newArtistId new value of artist id
	 * @throws InvalidArgumentException if $newArtistId is not an integer
	 * @throws RangeException if $newArtistId is not positive
	 **/
	public function setArtistId($newArtistId) {
		if($newArtistId === null) {
			$this->artistId = null;
			return;
		}
		// verify the artist id is valid
		$newArtistId = filter_var($newArtistId, FILTER_VALIDATE_INT);
		if($newArtistId === false) {
			throw(new InvalidArgumentException("artist id is not a valid integer"));
		}
		// verify the album id is positive
		if($newArtistId <= 0) {
			throw(new RangeException("artist id is not positive"));
		}
		// convert and store the album id
		$this->artistId = intval($newArtistId);
	}
	/**
	 * accessor method for credits description
	 *
	 * @return mixed value of credits description
	 **/
	public function getCreditsDescription() {
		return ($this->creditsDescription);
	}

	/**
	 * mutator method for credits description
	 *
	 * @param string $newCreditsDescription new value of credits description
	 * @throws InvalidArgumentException if $newCreditsDescription is not a string or insecure
	 * @throws RangeException if $newCreditsDescription is > 512 characters
	 **/
	public function setCreditsDescription($newCreditsDescription) {
		// verify the credits description is secure
		$newCreditsDescription = trim($newCreditsDescription);
		$newCreditsDescription = filter_var($newCreditsDescription, FILTER_SANITIZE_STRING);
		if($newCreditsDescription === false || empty($newCreditsDescription) === true) {
			throw(new InvalidArgumentException("credits description is empty or insecure"));
		}

		// verify the credits description will fit in the database
		if(strlen($newCreditsDescription) > 512) {
			throw(new RangeException("credits description too long"));
		}

		// store the credits description
		$this->creditsDescription = $newCreditsDescription;
	}

	/**
	 * inserts this Award into mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the creditsId is null (i.e., don't insert credits that already exist)
		if($this->creditsId !== null) {
			throw(new mysqli_sql_exception("not a new credit"));
		}

		// create query template
		$query	 = "INSERT INTO aindacochea.credits(albumId, artistId, creditsDescription) VALUES(?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean	  = $statement->bind_param("iis", $this->albumId, $this->artistId, $this->creditsDescription);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement"));
		}

		// update the null creditsId with what mySQL just gave us
		$this->creditsId = $mysqli->insert_id;
		// clean up the statement
		$statement->close();
	}


	/**
	 * deletes this Credits from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the creditsId is not null (i.e., don't delete credits that haven't been inserted)
		if($this->creditsId === null) {
			throw(new mysqli_sql_exception("unable to delete credits that do not exist"));
		}

		// create query template
		$query	 = "DELETE FROM aindacochea.credits WHERE creditsId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->creditsId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement"));
		}

		// clean up the statement
		$statement->close();
	}

	/**
	 * updates this Credits in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the creditsId is not null (i.e., don't update credits that haven't been inserted)
		if($this->creditsId === null) {
			throw(new mysqli_sql_exception("unable to update credits that do not exist"));
		}

		// create query template
		$query	 = "UPDATE aindacochea.credits SET albumId = ?, artistId = ?, creditsDescription = ? WHERE creditsId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("iiis", $this->creditsId, $this->albumId, $this->artistId, $this->creditsDescription);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement"));
		}

		// clean up the statement
		$statement->close();

	}

	/**
	 * gets the Credits by content
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $creditsDescription tweet content to search for
	 * @return mixed array of Credits found, or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getCreditsByCreditsDescription(&$mysqli, $creditsDescription) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the title before searching
		$creditsDescription = trim($creditsDescription);
		$creditsDescription = filter_var($creditsDescription, FILTER_SANITIZE_STRING);

		// create query template
		$query	 = "SELECT creditsId, albumId, artistId, creditsDescription FROM aindacochea.credits WHERE creditsDescription LIKE ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the title to the place holder in the template
		$creditsDescription = "%$creditsDescription%";
		$wasClean = $statement->bind_param("s", $creditsDescription);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement"));
		}

		// get result from the SELECT query
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("unable to get result set"));
		}

		// build an array of credits
		$credits = array();
		while(($row = $result->fetch_assoc()) !== null) {
			try {
				$credits = new Credits($row["creditsId"], $row["albumId"], $row["artistId"], $row["creditsDescription"]);
				$credits[] = $credits;
			}
			catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("unable to convert row to Credits", 0, $exception));
			}
		}

		// count the results in the array and return:
		// 1) null if 0 results
		// 2) the entire array if > 0 result
		$numberOfCredits = count($credits);
		if($numberOfCredits === 0) {
			return(null);
		} else {
			return($credits);
		}
	}
}
?>