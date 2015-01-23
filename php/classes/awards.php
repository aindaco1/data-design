<?php

/**
 * Awards received for an album as represented on allmusic.com
 *
 * This class represents industry awards received for the release, sales, or critical acclaim of an album
 * as represented on allmusic.com.
 *
 * @author Alonso Indacochea <alonso@hermesdevelopment.com>
 **/
class Awards {
	/**
	 * id for this award; this is the primary key
	 **/
	private $awardsId;
	/**
	 * id of the album that received this award; this is a foreign key
	 **/
	private $albumId;
	/**
	 * year award was received
	 **/
	private $awardsYear;
	/**
	 * title of the award
	 **/
	private $awardsTitle;

	/**
	 * constructor for this Award
	 *
	 * @param mixed $newAwardsId id of this Award
	 * @param mixed $newAlbumId id of the Album that received the Award
	 * @param mixed $newAwardsYear year Award was received
	 * @param mixed $newAwardsTitle title of the Award
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 **/
	public function __construct($newAwardsId, $newAlbumId, $newAwardsYear, $newAwardsTitle) {
		try {
			$this->setAwardsId($newAwardsId);
			$this->setAlbumId($newAlbumId);
			$this->setAwardsYear($newAwardsYear);
			$this->setAwardsTitle($newAwardsTitle);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		}
	}
	/**
	 * accessor method for award id
	 *
	 * @return mixed value of award id
	 **/
	public function getAwardsId() {
		return ($this->awardsId);
	}

	/**
	 * mutator method for awards id
	 *
	 * @param mixed $newAwardsId new value of awards id
	 * @throws InvalidArgumentException if $newAwardsId is not an integer
	 * @throws RangeException if $newAwardsId is not positive
	 **/
	public function setAwardsId($newAwardsId) {
		if($newAwardsId === null) {
			$this->awardsId = null;
			return;
		}
		// verify the awards id is valid
		$newAwardsId = filter_var($newAwardsId, FILTER_VALIDATE_INT);
		if($newAwardsId === false) {
			throw(new InvalidArgumentException("awards id is not a valid integer"));
		}
		// verify the awards id is positive
		if($newAwardsId <= 0) {
			throw(new RangeException("awards id is not positive"));
		}
		// convert and store the awards id
		$this->awardsId = intval($newAwardsId);
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
		// convert and store the awards id
		$this->albumId = intval($newAlbumId);
	}

	/**
	 * accessor method for award year
	 *
	 * @return mixed value of award year
	 **/
	public function getAwardsYear() {
		return ($this->awardsYear);
	}

	/**
	 * mutator method for award year
	 *
	 * @param mixed $newAwardsYear new value of award year
	 * @throws InvalidArgumentException if $newAwardsYear is not an integer
	 * @throws RangeException if $newAwardsYear is a future year
	 * @throws RangeException if $newAwardsYear is an ancient year
	 **/
	public function setAwardsYear($newAwardsYear) {
		if($newAwardsYear === null) {
			$this->awardsYear = null;
			return;
		}
		// verify the award year is valid
		$newAwardsYear = filter_var($newAwardsYear, FILTER_VALIDATE_INT);
		if($newAwardsYear === false) {
			throw(new InvalidArgumentException("awards year is not a valid integer"));
		}
		// verify the award year is not a future year
		if($newAwardsYear > intval(date("Y"))) {
			throw(new RangeException("awards year is a future year"));
		}
		// verify the award year is not an ancient year
		if($newAwardsYear <= 1857) {
			throw(new RangeException("awards year is an ancient year"));
		}
		// convert and store the awards id
		$this->awardsYear = intval($newAwardsYear);
	}
	/**
	 * accessor method for award title
	 *
	 * @return mixed value of award title
	 **/
	public function getAwardsTitle() {
		return ($this->awardsTitle);
	}

	/**
	 * mutator method for award title
	 *
	 * @param string $newAwardsTitle new value of award title
	 * @throws InvalidArgumentException if $newAwardsTitle is not a string or insecure
	 * @throws RangeException if $newAwardsTitle is > 200 characters
	 **/
	public function setAwardsTitle($newAwardsTitle) {
		// verify the award title is secure
		$newAwardsTitle = trim($newAwardsTitle);
		$newAwardsTitle = filter_var($newAwardsTitle, FILTER_SANITIZE_STRING);
		if($newAwardsTitle === false || empty($newAwardsTitle) === true) {
			throw(new InvalidArgumentException("award title is empty or insecure"));
		}

		// verify the award title will fit in the database
		if(strlen($newAwardsTitle) > 200) {
			throw(new RangeException("award title too long"));
		}

		// store the award title
		$this->awardsTitle = $newAwardsTitle;
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

		// enforce the awardId is null (i.e., don't insert an award that already exists)
		if($this->awardsId !== null) {
			throw(new mysqli_sql_exception("not a new award"));
		}

		// create query template
		$query	 = "INSERT INTO aindacochea.awards(albumId, awardsTitle, awardsYear) VALUES(?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean	  = $statement->bind_param("isi", $this->albumId, $this->awardsTitle, $this->awardsYear);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement"));
		}

		// update the null awardsId with what mySQL just gave us
		$this->awardsId = $mysqli->insert_id;
		// clean up the statement
		$statement->close();
	}


	/**
	 * deletes this Award from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the awardsId is not null (i.e., don't delete an Award that hasn't been inserted)
		if($this->awardsId === null) {
			throw(new mysqli_sql_exception("unable to delete an award that does not exist"));
		}

		// create query template
		$query	 = "DELETE FROM aindacochea.awards WHERE awardsId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->awardsId);
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
	 * updates this Award in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the awardsId is not null (i.e., don't update an award that hasn't been inserted)
		if($this->awardsId === null) {
			throw(new mysqli_sql_exception("unable to update an award that does not exist"));
		}

		// create query template
		$query	 = "UPDATE aindacochea.awards SET albumId = ?, awardsTitle = ?, awardsYear = ? WHERE awardsId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("iisi", $this->awardsId, $this->albumId, $this->awardsTitle, $this->awardsYear);
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
	 * gets the Award by content
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $awardsTitle tweet content to search for
	 * @return mixed array of Awards found, or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getAwardsByAwardsTitle(&$mysqli, $awardsTitle) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the title before searching
		$awardsTitle = trim($awardsTitle);
		$awardsTitle = filter_var($awardsTitle, FILTER_SANITIZE_STRING);

		// create query template
		$query	 = "SELECT awardsId, albumId, awardsTitle, awardsYear FROM aindacochea.awards WHERE awardsTitle LIKE ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the title to the place holder in the template
		$awardsTitle = "%$awardsTitle%";
		$wasClean = $statement->bind_param("s", $awardsTitle);
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

		// build an array of awards
		$awards = array();
		while(($row = $result->fetch_assoc()) !== null) {
			try {
				$awards = new Awards($row["awardsId"], $row["albumId"], $row["awardsTitle"], $row["awardsYear"]);
				$awards[] = $awards;
			}
			catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("unable to convert row to Award", 0, $exception));
			}
		}

		// count the results in the array and return:
		// 1) null if 0 results
		// 2) a single object if 1 result
		// 3) the entire array if > 1 result
		$numberOfAwards = count($awards);
		if($numberOfAwards === 0) {
			return(null);
		} else {
			return($awards);
		}
	}
}
?>