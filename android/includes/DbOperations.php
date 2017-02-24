<?php

	/** Handeling all operations **/

	class DbOperation
	{
		private $con;

		function __construct()
		{
			require_once dirname(__FILE__).'/DBConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect();

		}

		/*CRUD- first create Users*/

		public function createUser($username, $pass, $email){

			#calling ifUserExist function
			if ($this->ifUserExist($email)) {

				# 0 if user already exists
				return 0;
			}
			else {
				# making password encrypted in md5 hash
				#$password = md5($pass);

				# Statement
				$stmt = $this->con->prepare("INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES (NULL, ?, ?, ?);");

				# binding the statement to variable
				$stmt->bind_param("sss",$username,$pass,$email);

				if ($stmt->execute()) {
					# created new user 
					return 1;
				}else{
					# didn't create user
					return 2;
				}
			}
		}

		public function userLogin($username, $pass){
			# saving password into md5 hash
			# $password = md5($pass);

			# creating user statement to get data
			$stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
			$stmt->bind_param("ss", $username, $pass);
			$stmt->execute();
			$stmt->store_result();

			return $stmt->num_rows > 0;
		}

		public function getUserByUsername($username){

			# make statement for getting all user details using username
			$stmt = $this->con->prepare("SELECT * FROM users WHERE username = ?");

			# bind the statement with variable and execute
			$stmt->bind_param("s", $username);
			$stmt->execute();

			# fetching all details from database
			return $stmt->get_result()->fetch_assoc();
		}

		private function ifUserExist($email){
			
			# statement to find if email is unique or not in database
			$stmt = $this->con->prepare("SELECT id FROM users WHERE email = ?");
			
			# bind statement to variable and execute and store the value
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$stmt->store_result();

			# return num_rows will tell if the email is unique or not
			return $stmt->num_rows > 0;
		}

	}
