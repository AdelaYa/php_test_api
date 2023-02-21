<?php

namespace Models;

use Core\BaseModel;

class AuthModel extends BaseModel
{

    public function addUserToDb($data): bool
    {
        $sql = "INSERT INTO logins  (login, password_hash) VALUES (:login, :password)";
        $query = $this->dbConnect->prepare($sql);
        $query->execute($data);
        echo "Успешно";
        return true;
    }

    public function checkInDb($data)
    {
        $dataPassword = $data['password'];
        unset($data['password']);

        $sql = "SELECT * FROM logins WHERE login = :login;)";
        $query = $this->dbConnect->prepare($sql);
        $query->execute($data);
        $result = $query->fetch();
        if ($result["login"] != $data['login'] or !password_verify($dataPassword, $result["password_hash"])) {
            echo "Неверный логин или пароль";
            return null;
        } else {
            return $result;
        }

    }

}