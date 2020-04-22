<?php

// functie de utilitate ca sa mearga chestia cu utf-8 dracu s-o ia
function utf8_for_xml($string) {
    return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u',
                        ' ', $string);
 }


class db_connection {

	private $conn = "";

	function __construct() {

		$conf = require("dbconfig.php"); // file is gitignored, you need to provide it for yourself

		$servername = $conf["hostname"];
		$username = $conf["username"];
		$password = $conf["password"];
		$dbname = $conf["database"];

		error_reporting(0);
		// Create connection
		$this->conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($this->conn->connect_errno) {

			header($_SERVER["SERVER_PROTOCOL"] . " 503 Service Unavailable");
			include($_SERVER["DOCUMENT_ROOT"] . "/errors/503.php");
			echo("Could not connect to database: " . $this->conn->connect_error);
			die();

		}
		error_reporting(5);
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

		$stmt = $this->conn->prepare("INSERT INTO utilizatori (Parola, Username, Email, Autoritate, Functie, Nume, Prenume, IdClasa) VALUES ('notset', ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ssssssi',
			$utilizator_data["Username"],
			$utilizator_data["Email"],
			$utilizator_data["Autoritate"],
			$utilizator_data["Functie"],
			$utilizator_data["Nume"],
			$utilizator_data["Prenume"],
			$utilizator_data["IdClasa"]);
		$stmt->execute();

	}

	public function delete_utilizator($utilizator_id) {

		$stmt = $this->conn->prepare("DELETE FROM utilizatori WHERE Id=?;");
		$stmt->bind_param("i", $utilizator_id);
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

	public function retrieve_utilizator_where_cod_inregistrare($columns, $cod) {

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori WHERE CodInregistrare=?;");
		$stmt->bind_param("i", $cod);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 0)
			return null;
		else return $result->fetch_assoc();

	}

	public function update_utilizator_cod_inregistrare($user_id, $cod) {

		$stmt = $this->conn->prepare("UPDATE utilizatori SET CodInregistrare=? WHERE Id=?;");
		$stmt->bind_param("ii", $cod, $user_id);
		$stmt->execute();

	}

	public function retrieve_count_utilizatori($filter = null) {

		$filterSql = "";

		if (in_array("profesori", $filter) && in_array("elevi", $filter)) {
			$filterSql = "WHERE Functie='profesor' OR Functie='elev'";
		} else {
			if (in_array("profesori", $filter))
				$filterSql = "WHERE Functie='profesor'";
			if (in_array("elevi", $filter))
				$filterSql = "WHERE Functie='elev'";
		}

		$stmt = $this->conn->prepare("SELECT count(Id) FROM utilizatori $filterSql;");
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->fetch_assoc()["count(Id)"];

	}

	public function retrieve_paged_utilizatori($columns, $entriesPerPage, $page, $filter = null) {

		$filterSql = "";

		if (in_array("profesori", $filter) && in_array("elevi", $filter)) {
			$filterSql = "WHERE Functie='profesor' OR Functie='elev'";
		} else {
			if (in_array("profesori", $filter))
				$filterSql = "WHERE Functie='profesor'";
			if (in_array("elevi", $filter))
				$filterSql = "WHERE Functie='elev'";
		}

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori $filterSql ORDER BY Nume,Prenume ASC LIMIT ? OFFSET ?;");
		$offset = $page * $entriesPerPage;
		$stmt->bind_param('ii',
			$entriesPerPage,
			$offset);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;

	}

	public function retrieve_utilizatori_pagination_titles($entriesPerPage, $filter = null) {

		$count = $this->retrieve_count_utilizatori();
		$remaining = $count;
		$return = array();

		while ($remaining > 0) {

			$pag = ($count - $remaining) / $entriesPerPage;
			$utiliz = $this->retrieve_paged_utilizatori("Nume,Prenume", $entriesPerPage, $pag, $filter);

			$first = $utiliz->fetch_assoc();
			$utiliz->data_seek($utiliz->num_rows - 1);
			$last = $utiliz->fetch_assoc();

			$return[] = array(
				"page" => $pag,
				"count" => $utiliz->num_rows,
				"first" => $first["Nume"] . " " . $first["Prenume"],
				"last" => $last["Nume"] . " " . $last["Prenume"]
			);

			$remaining -= $entriesPerPage;

		}

		return $return;

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

	public function update_utilizator_inregistrare($user_id, $data) {

		$stmt = $this->conn->prepare("UPDATE utilizatori SET Username=?,Email=?,Nume=?,Prenume=?,Parola=?,CodInregistrare=NULL,Activat=current_timestamp() WHERE Id=?;");
		$stmt->bind_param("sssssi",
			$data["Username"],
			$data["Email"],
			$data["Nume"],
			$data["Prenume"],
			$data["Parola"],
			$user_id);
		$stmt->execute();

	}

	public function update_utilizator_general_settings($user_id, $data) {

		$stmt = $this->conn->prepare("UPDATE utilizatori SET Username=?,Email=?,Nume=?,Prenume=?,Functie=?,Autoritate=? WHERE Id=?;");
		$stmt->bind_param("ssssssi",
			$data["Username"],
			$data["Email"],
			$data["Nume"],
			$data["Prenume"],
			$data["Functie"],
			$data["Autoritate"],
			$user_id);
		$stmt->execute();

	}

	public function update_utilizator_set_clasa($user_id, $clasa_id) {

		$stmt = $this->conn->prepare("UPDATE utilizatori SET IdClasa=? WHERE Id=?;");
		$stmt->bind_param("ii",
			$clasa_id,
			$user_id);
		$stmt->execute();

	}

	public function retrieve_profesori($columns) {

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori WHERE Functie='profesor';");
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;

	}

	public function retrieve_profesori_where_not_diriginte($columns) {

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori WHERE Functie='profesor' AND Id NOT IN (SELECT IdDiriginte FROM clase);");
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

	public function insert_predare($predare_data) {

		$stmt = $this->conn->prepare("INSERT INTO predari (IdClasa, IdMaterie, IdProfesor, TipTeza) VALUES (?, ?, ?, ?);");
		$stmt->bind_param('iiis',
			$predare_data["IdClasa"],
			$predare_data["IdMaterie"],
			$predare_data["IdProfesor"],
			$predare_data["TipTeza"]);
		$stmt->execute();

	}

	public function delete_predare($predare_id) {

		$stmt = $this->conn->prepare("DELETE FROM predari WHERE Id=?;");
		$stmt->bind_param('i', $predare_id);
		$stmt->execute();

	}

	// $id_clasa poate fi NULL
	public function retrieve_elevi_where_clasa($columns, $id_clasa) {

		$clasaSql = "";
		if ($id_clasa == NULL) {
			$clasaSql = "IdClasa IS NULL";
		} else {
			$clasaSql = "IdClasa=?";
		}

		$stmt = $this->conn->prepare("SELECT $columns FROM utilizatori WHERE $clasaSql AND Functie='elev' ORDER BY Nume,Prenume DESC;");
		if ($id_clasa != NULL)
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

	public function retrieve_clasa_where_diriginte($columns, $diriginte_id) {

		$stmt = $this->conn->prepare("SELECT $columns FROM clase WHERE IdDiriginte=?;");
		$stmt->bind_param('i', $diriginte_id);
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

	public function update_clasa_set_diriginte($clasa_id, $diriginte_id) {

		$stmt = $this->conn->prepare("UPDATE clase SET IdDiriginte=? WHERE Id=?;");
		$stmt->bind_param("ii",
			$diriginte_id,
			$clasa_id);
		$stmt->execute();

	}

	public function delete_clasa($clasa_id) {

		$stmt = $this->conn->prepare("DELETE FROM clase WHERE Id=?");
		$stmt->bind_param("i", $clasa_id);
		$stmt->execute();

	}

	public function retrieve_note_where_elev_and_materie_and_semestru($columns, $user_id, $materie_id, $semestru) {

		$stmt = $this->conn->prepare("SELECT $columns FROM note WHERE IdElev=? AND IdMaterie=? AND Semestru=? ORDER BY Luna,Ziua DESC;");
		$stmt->bind_param("iis", $user_id, $materie_id, $semestru);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function insert_nota($nota_data) {

		$stmt = $this->conn->prepare("INSERT INTO note (IdElev, IdClasa, IdMaterie, IdProfesor, Teza, Tip, Semestru, Nota, Ziua, Luna) VALUES (?,?,?,?,?,?,?,?,?,?);");
		$stmt->bind_param("iiiisssiii",
			$nota_data["IdElev"],
			$nota_data["IdClasa"],
			$nota_data["IdMaterie"],
			$nota_data["IdProfesor"],
			$nota_data["Teza"],
			$nota_data["Tip"],
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

	public function retrieve_absente_where_elev_and_materie_and_semestru($columns, $user_id, $materie_id, $semestru) {

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

		$stmt = $this->conn->prepare("INSERT INTO absente (IdElev, IdMaterie, IdClasa, IdProfesor, Semestru, Ziua, Luna) VALUES (?, ?, ?, ?, ?, ?, ?);");
		$stmt->bind_param("iiiisii",
			$absenta_data["IdElev"],
			$absenta_data["IdMaterie"],
			$absenta_data["IdClasa"],
			$absenta_data["IdProfesor"],
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

	// array of type
	//  "IdElev" => ..
	//  "IdPredare" => ..
	//  "Teza" => "da", "nu"
	public function update_teze($teze_data) {

		foreach ($teze_data as $teza) {

			if ($teza["Teza"] == "nu") {

				$stmt = $this->conn->prepare("DELETE FROM elevi_teze WHERE IdElev=? AND IdPredare=?;");
				$stmt->bind_param("ii",
					$teza["IdElev"],
					$teza["IdPredare"]);
				$stmt->execute();

			} else {

				$stmt = $this->conn->prepare("INSERT IGNORE INTO elevi_teze (IdElev, IdPredare) VALUES (?,?);");
				$stmt->bind_param("ii",
					$teza["IdElev"],
					$teza["IdPredare"]);
				$stmt->execute();

			}

		}

	}

	public function retrieve_teze_where_predare($columns, $predare_id) {

		$stmt = $this->conn->prepare("SELECT $columns FROM elevi_teze WHERE IdPredare=?;");
		$stmt->bind_param("i",
			$predare_id);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function has_elev_teza_in_predare($elev_id, $predare_id) {

		$predare = $this->retrieve_predare_where_id("*", $predare_id);

		if ($predare["TipTeza"] == "optional") {

			$stmt = $this->conn->prepare("SELECT * FROM elevi_teze WHERE IdElev=? AND IdPredare=?;");
			$stmt->bind_param("ii",
				$elev_id,
				$predare_id);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 0) {
				return false;
			} else {
				return true;
			}

		} else {

			if ($predare["TipTeza"] == "nu")
				return false;
			if ($predare["TipTeza"] == "obligatoriu")
				return true;

		}

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
