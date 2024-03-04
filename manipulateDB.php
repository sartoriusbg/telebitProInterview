
<?php
require_once 'db.php';


class WorkingWithDB {
    private Db $db;

   public function __construct($db) 
    {
       $this->db = $db;
    }
    

    public function login($email, $password) {

        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE email = ? AND password = ? ");
        $stmt->execute([$email, $password]);
        $rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
        //echo array_values($rows);
        if (!$rows==0 ) {
        return $rows[0];
        }
        return "-1";   
    }

    public function insertUser($name, $email, $password) 
    {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO users (name, email, password, activation_code) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, bin2hex(random_bytes(16))]);
    }

    public function getUser($email) 
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE email = ?;");
        $stmt->execute([$email]);
        $rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
        return $rows;   
    }
    public function getUsers() 
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users ;");
        $stmt->execute([]);
        $rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
        return $rows;   
    }

    public function updateUser($email, $name, $password)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE users SET name = ?, password = ? WHERE email = ?;");
        $stmt->execute([$name, $password, $email]);
    }

    public function validateUser($email)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE users SET active = 1 WHERE email = ?;");
        $stmt->execute([$email]);
    }

}

?>