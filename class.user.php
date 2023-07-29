<?php
class User {
	private $db = null;
	private $id = 0;
	private $name = null;
	private $email = null;
	private $password = null;
	private $request_email = null;
	private $request_email_id = null;
	private $register_ip = null;
	private $current_ip = null;
	private $profile_json = null;
	private $rank = null;
	private $verified = false;
	private $exists = false;

	function __construct($id) {
		include "connect.php";

		$this->db = $db;

		$q = $db->prepare("SELECT * FROM users WHERE id=?");
		$q->execute(array(abs(intval($id))));

		if ($q->rowCount()) {
			$res = $q->fetch();

			$this->id = $res["id"];
			$this->name = $res["name"];
			$this->email = ($res["email"] == "null") ? null : $res["email"];
			$this->password = $res["password"];
			$this->request_email = ($res["request_email"] == "null") ? null : $res["request_email"];
			$this->request_email_id = ($res["request_email_id"] == "null") ? null : $res["request_email_id"];
			$this->register_ip = $res["register_ip"];
			$this->current_ip = $res["current_ip"];
			$this->profile_json = $res["profile_json"];



			$this->rank = $res["rank"];



			$this->verified = $res["verified"];
			$this->exists = true;
		} else $this->exists = false;
	}
}
?>