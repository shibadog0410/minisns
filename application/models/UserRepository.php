<?php

class UserRepository extends DBRepository
{
    public function insert($user_name, $password)
    {
        $password = $this->hashPassword($password);
        $now = new DateTime();

        $sql = "INSERT INTO `user` (user_name, password, created_at) VALUES (:user_name, :password, :created_at)";

        $stmt = $this->execute($sql, array(
            ':user_name'    => $user_name,
            ':password'     => $password,
            ':created_at'   => $now->format('Y-m-d H:i:s'),
        ));
    }

    public function hashPassword($password)
    {
        return sha1($password . 'qwerewgrdhfmg');
    }

    public function fetchByUserName($user_name)
    {
        $sql = "SELECT * FROM user WHERE user_name = :user_name";
        return $this->fetch($sql, array(':user_name' => $user_name));
    }

    public function isUniqueUserName($user_name)
    {
        $sql = "SELECT COUNT(id) as count FROM user WHERE user_name = :user_name";

        $row = $this->fetch($sql, array(':user_name' => $user_name));
        if ($row['count'] === '0') {
            return TRUE;
        }
        return FALSE;
    }

    public function fetchAllFollowingsByuserId($user_id)
    {
        $sql = "
            SELECT u.*
            FROM user u
            LEFT JOIN following f ON f.following_id = u.id
            WHERE f.user_id = :user_id
        ";

        return $this->fetchAll($sql, array(':user_id' => $user_id));
    }
}
