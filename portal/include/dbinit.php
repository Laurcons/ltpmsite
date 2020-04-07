<?php

// WRITTEN AND MAINTAINED BY BUBU

// NAMING SCHEMES
//
// using_this_style_of_naming
//
// is_x_y : checks whether x is y
// insert_user : function that inserts an user
// delete_user_where_x : function that deletes users that satisfy the x condition

// functie de utilitate ca sa mearga chestia cu utf-8 dracu s-o ia
function utf8_for_xml($string) {
    return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u',
                        ' ', $string);
 }


class db_connection {

	private $conn = "";

	function __construct() {

		$servername = "laurcons.ddns.net";
		$username = "ltpmdb_user";
		$password = "m5a2Yc0ztiVkd24b";
		$dbname = "ltpmdb";

		// Create connection
		$this->conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($this->conn->connect_error) {
		    die("Database connection failed: " . $conn->connect_error);
		}
		$this->conn->set_charset("utf8");
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	}

	public function get_conn() {

		return $this->conn;

	}

	public function is_username_available($username) {

		$stmt = $this->conn->prepare("SELECT count(Id) FROM utilizatori WHERE Username=?;");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		$count = $result->fetch_assoc()["count(Id)"];

		if ($count == 0)
			return true;
		else return false;

	}

	public function insert_utilizator($utilizator_data) {

		$stmt = $this->conn->prepare("INSERT INTO utilizatori (Username, Parola, Email, Autoritate, Functie, NrMatricol, Nume, Prenume) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ssssssss',
			$utilizator_data["Username"],
			$utilizator_data["Parola"],
			$utilizator_data["Email"],
			$utilizator_data["Autoritate"],
			$utilizator_data["Functie"],
			$utilizator_data["NrMatricol"],
			$utilizator_data["Nume"],
			$utilizator_data["Prenume"]);
		$stmt->execute();

	}

	public function retrieve_utilizator_ultima_logare($username) {

		$stmt = $this->conn->prepare("SELECT UltimaLogare FROM utilizatori WHERE Username=?;");
		$stmt->bind_param('s',
			$username);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		return $row['UltimaLogare'];

	}

	public function update_utilizator_ultima_logare($username) {

		$stmt = $this->conn->prepare("UPDATE utilizatori SET UltimaLogare = current_timestamp() WHERE Username=?;");
		$stmt->bind_param('s', $username);
		$stmt->execute();

	}

	public function retrieve_utilizator_where_username($columns, $username) {

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori WHERE Username=?;");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 0)
			return null;
		else return $result->fetch_assoc();

	}

	public function retrieve_utilizator_where_id($columns, $id) {

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori WHERE Id=?;");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 0)
			return null;
		else return $result->fetch_assoc();

	}

	public function retrieve_count_utilizatori() {

		$stmt = $this->conn->prepare("SELECT count(Id) FROM utilizatori;");
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->fetch_assoc()["count(Id)"];

	}

	public function retrieve_paged_utilizatori($columns, $entriesPerPage, $page) {

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori ORDER BY Id ASC LIMIT ? OFFSET ?;");
		$offset = $page * $entriesPerPage;
		$stmt->bind_param('ii',
			$entriesPerPage,
			$offset);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;

	}

	public function retrieve_paged_profesori($columns, $entriesPerPage, $page) {

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori WHERE Functie='profesor' ORDER BY Id ASC LIMIT ? OFFSET ?;");
		$offset = $page * $entriesPerPage;
		$stmt->bind_param('ii',
			$entriesPerPage,
			$offset
		);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;

	}

	public function retrieve_profesori($columns) {

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori WHERE Functie='profesor';");
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;

	}

	public function retrieve_profesori_where_not_diriginte($columns) {

		$stmt = $this->conn->prepare("SELECT * FROM utilizatori WHERE Functie='profesor' AND Id NOT IN (SELECT IdDiriginte FROM clase);");
		$stmt->execute();

		return $stmt->get_result();

	}

	public function retrieve_count_elevi_where_clasa($clasa_id) {

		$stmt = $this->conn->prepare("SELECT COUNT(Id) FROM utilizatori WHERE Functie='elev' AND IdClasa=?;");
		$stmt->bind_param('i', $clasa_id);
		$stmt->execute();

		return $stmt->get_result()->fetch_assoc()["COUNT(Id)"];

	}

	public function insert_materie($materie_data) {

		$stmt = $this->conn->prepare("INSERT INTO materii (Nume) VALUES (?);");
		$stmt->bind_param('s', $materie_data["Nume"]);
		$stmt->execute();

	}

	public function retrieve_materii($columns) {

		$stmt = $this->conn->prepare("SELECT $columns FROM materii;");
		$stmt->execute();

		return $stmt->get_result();

	}

	public function retrieve_materie_where_id($columns, $id_materie) {

		$stmt = $this->conn->prepare("SELECT $columns FROM materii WHERE Id=?;");
		$stmt->bind_param('i', $id_materie);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 0)
			return null;
		else return $result->fetch_assoc();

	}

	public function retrieve_predare_where_id($columns, $id_predare) {

		$stmt = $this->conn->prepare("SELECT $columns FROM predari WHERE Id=?;");
		$stmt->bind_param('i', $id_predare);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 0)
			return null;
		else return $result->fetch_assoc();

	}

	// alias
	public function retrieve_predari_where_materie($columns, $id_materie) {
		return $this->retrieve_predari_where_idmaterie($columns, $id_materie); }
	public function retrieve_predari_where_idmaterie($columns, $id_materie) {

		$stmt = $this->conn->prepare("SELECT $columns FROM predari WHERE IDMaterie=?;");
		$stmt->bind_param('i', $id_materie);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function retrieve_predari_where_profesor($columns, $id_profesor) {

		$stmt = $this->conn->prepare("SELECT $columns FROM predari WHERE IdProfesor=?;");
		$stmt->bind_param("i", $id_profesor);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function retrieve_profesori_where_predare_materie($columns, $id_materie) {

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori WHERE Id IN (SELECT predari.IDProfesor FROM predari WHERE IDMaterie=?);");
		$stmt->bind_param('i', $id_materie);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function retrieve_materii_where_predare_elev($columns, $id_elev) {

		$stmt = $this->conn->prepare("SELECT $columns FROM materii WHERE Id IN (SELECT predari.IdMaterie FROM predari WHERE IdClasa IN (SELECT utilizatori.IdClasa FROM utilizatori WHERE Id =?));");
		$stmt->bind_param('i', $id_elev);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function delete_materie($materie_id) {

		$stmt = $this->conn->prepare("DELETE FROM materii WHERE Id=?;");
		$stmt->bind_param('i', $materie_id);
		$stmt->execute();

	}

	public function retrieve_predari_where_clasa($columns, $id_clasa) {

		$stmt = $this->conn->prepare("SELECT $columns FROM predari WHERE IdClasa=?;");
		$stmt->bind_param('i', $id_clasa);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function retrieve_elevi_where_clasa($columns, $id_clasa) {

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori WHERE IdClasa=? ORDER BY Nume,Prenume DESC;");
		$stmt->bind_param('i', $id_clasa);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function retrieve_clasa_where_id($columns, $id) {

		$stmt = $this->conn->prepare("SELECT $columns FROM clase WHERE Id=?;");
		$stmt->bind_param('i', $id);
		$stmt->execute();

		return $stmt->get_result()->fetch_assoc();

	}

	public function retrieve_clase($columns) {

		$stmt = $this->conn->prepare("SELECT $columns FROM clase ORDER BY Nivel,Sufix;");
		$stmt->execute();

		return $stmt->get_result();

	}

	public function insert_clasa($clasa_data) {

		$stmt = $this->conn->prepare("INSERT INTO clase (Nivel, Sufix, IdDiriginte, AnScolar) VALUES (?, ?, ?, ?);");
		$stmt->bind_param("isii",
			$clasa_data["Nivel"],
			$clasa_data["Sufix"],
			$clasa_data["IdDiriginte"],
			$clasa_data["AnScolar"]
		);
		$stmt->execute();

	}

	public function delete_clasa($clasa_id) {

		$stmt = $this->conn->prepare("DELETE FROM clase WHERE Id=?");
		$stmt->bind_param("i", $clasa_id);
		$stmt->execute();

	}

	public function retrieve_note_where_utilizator_and_materie_and_semestru($columns, $user_id, $materie_id, $semestru) {

		$stmt = $this->conn->prepare("SELECT $columns FROM note WHERE IdElev=? AND IdMaterie=? AND Semestru=? ORDER BY Luna,Ziua DESC;");
		$stmt->bind_param("iis", $user_id, $materie_id, $semestru);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function insert_nota($nota_data) {

		$stmt = $this->conn->prepare("INSERT INTO note (IdElev, IdClasa, IdMaterie, Semestru, Nota, Ziua, Luna) VALUES (?,?,?,?,?,?,?);");
		$stmt->bind_param("iiisiii",
			$nota_data["IdElev"],
			$nota_data["IdClasa"],
			$nota_data["IdMaterie"],
			$nota_data["Semestru"],
			$nota_data["Nota"],
			$nota_data["Ziua"],
			$nota_data["Luna"]);
		$stmt->execute();

	}

	public function delete_nota_where_id($nota_id) {

		$stmt = $this->conn->prepare("DELETE FROM note WHERE Id=?;");
		$stmt->bind_param("i", $nota_id);
		$stmt->execute();

	}

	public function calculate_medie_where_utilizator_and_materie_and_semestru($user_id, $materie_id, $semestru) {

		$note = $this->retrieve_note_where_utilizator_and_materie_and_semestru("Nota", $user_id, $materie_id, $semestru);
		$suma_note = 0;
		$nr_note = 0;
		while ($nota = $note->fetch_assoc()) {
			$nota_val = $nota["Nota"];
			$nr_note++;
			$suma_note += $nota_val;
		}
		if ($suma_note == 0)
			return 0;
		// fa impartirea
		$imp = $suma_note / $nr_note;
		// rotunjeste la 2 zecimale
		$imp = floor($imp * 100) / 100;

		return $imp;

	}

	public function retrieve_activitate_where_utilizator_and_materie($columns, $user_id, $materie_id) {

		$stmt = $this->conn->prepare("SELECT $columns FROM activitate WHERE IdElev=? AND IdMaterie=?;");
		$stmt->bind_param("ii", $user_id, $materie_id);
		$stmt->execute();

		return $stmt->get_result()->fetch_assoc();

	}

	public function retrieve_absente_where_utilizator_and_materie_and_semestru($columns, $user_id, $materie_id, $semestru) {

		$stmt = $this->conn->prepare("SELECT $columns FROM absente WHERE IdElev=? AND IdMaterie=? AND Semestru=? ORDER BY Luna,Ziua ASC");
		$stmt->bind_param("iii", $user_id, $materie_id, $semestru);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function retrieve_absenta_where_id($columns, $id) {

		$stmt = $this->conn->prepare("SELECT $columns FROM absente WHERE Id=?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		return $stmt->get_result()->fetch_assoc();

	}

	public function insert_absenta($absenta_data) {

		$stmt = $this->conn->prepare("INSERT INTO absente (IdElev, IdMaterie, IdClasa, Semestru, Ziua, Luna) VALUES (?, ?, ?, ?, ?, ?);");
		$stmt->bind_param("iiisii",
			$absenta_data["IdElev"],
			$absenta_data["IdMaterie"],
			$absenta_data["IdClasa"],
			$absenta_data["Semestru"],
			$absenta_data["Ziua"],
			$absenta_data["Luna"]);
		$stmt->execute();

	}

	public function delete_absenta($absenta_id) {

		$stmt = $this->conn->prepare("DELETE FROM absente WHERE Id=?;");
		$stmt->bind_param("i", $absenta_id);
		$stmt->execute();

	}

	public function update_absenta_motivare($absenta_id, $motivata) {

		$stmt = $this->conn->prepare("UPDATE absente SET Motivata=? WHERE Id=?");
		$stmt->bind_param("ii", $motivata, $absenta_id);
		$stmt->execute();

	}

	public function exists_absenta($user_id, $materie_id, $ziua, $luna) {

		$stmt = $this->conn->prepare("SELECT Count(Id) FROM absente WHERE IdElev=? AND IdMaterie=? AND Luna=? AND Ziua=?;");
		$stmt->bind_param("iiii",
			$user_id,
			$materie_id,
			$luna,
			$ziua);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		if ($row["Count(Id)"] == 1)
			return true;
		else return false;

	}

	public function insert_citat($citat_data) {

		$stmt = $this->conn->prepare("INSERT INTO citate (Text, Autor, IdUser, Comentariu, Status) VALUES (?, ?, ?, ?, ?);");
		$stmt->bind_param("ssiss",
			$citat_data["Text"],
			$citat_data["Autor"],
			$citat_data["IdUser"],
			$citat_data["Comentariu"],
			$citat_data["Status"]);
		$stmt->execute();

	}

	public function update_citat_status($citat_id, $status) {

		throw new Exception("Not implemented");

	}

	public function retrieve_citat_random($columns, $recursive = false) {

		$stmt = $this->conn->prepare("SELECT $columns FROM citate WHERE Status='acceptat' AND Ziua=curdate();");
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 0) {

			if ($recursive)
				return null;

			// seteaza unul
			$stmt = $this->conn->prepare("UPDATE citate SET Ziua=curdate() WHERE Status='acceptat' ORDER BY rand() LIMIT 1;");
			$stmt->execute();
			return $this->retrieve_citat_random($columns, true);

		} else {
			return $result->fetch_assoc();
		}

	}

}

?>
