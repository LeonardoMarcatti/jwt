<?php
    namespace api\config\objetcs;

    use PDO;

    class User
    {
        private object $conn;
        public int $id;
        public string $firstname, $lastname, $email, $password;

        public function __construct(object $db)
        {
            $this->conn = $db;
        }

        public function create()
        {
            $sql = "insert into users (firstname, lastname, password, email) values(:f, :l, :p, :e)";
            $insert = $this->conn->prepare($sql);
            $insert->bindValue(':f', $this->firstname);
            $insert->bindValue(':l', $this->lastname);
            $insert->bindValue(':e', $this->email);

            $hash = password_hash($this->password, PASSWORD_BCRYPT);
            $insert->bindValue(':p', $hash);
            $insert->execute();
        }

        public function emailExists()
        {
            $sql = 'select id, firstname, lastname, password from users where email = :e';
            $result = $this->conn->prepare($sql);
            $result->bindValue(':e', $this->email);
            $result->execute();
            if ($result->rowCount() > 0) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $this->id = $row['id'];
                $this->firstname = $row['firstname'];
                $this->lastname = $row['lastname'];
                $this->password = $row['password'];
                return true;
            } else {
            return false;
            };
        }

        public function update()
        {
            $sql = "update users set firstname = :f, lastname = :l, email = :e ";

            if (!empty($this->password)) {
                $sql .= ", password = :p ";
            };

            $sql .= 'where id = :id';

            $update = $this->conn->prepare($sql);
            $update->bindValue(':f', $this->firstname);
            $update->bindValue(':l', $this->lastname);
            $update->bindValue(':e', $this->email);

            if (!empty($this->password)) {
                $hash = password_hash($this->password, PASSWORD_BCRYPT);
                $update->bindValue(':p', $hash);
            };

            $update->bindValue(':id', $this->id);

            if ($update->execute()) {
                return true;
            };
            
            return false;
        }

    };
    
?>