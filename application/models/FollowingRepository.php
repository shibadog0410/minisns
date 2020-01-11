<?php
class FollowingRepository extends DBRepository
{
    public function insert($user_id, $following_id)
    {
        $sql = "INSERT INTO following VALUES(:user_id, :following_id)";

        $stmt = $this->execute($sql, array(
            ':user_id'      => $user_id,
            ':following_id' => $following_id
        ));
    }

    public function isFollowing($user_id, $following_id)
    {
        $sql = "
                SELECT COUNT(user_id) AS count
                FROM following
                WHERE user_id = :user_id
                AND following_id = :following_id
            ";

        $row = $this->fetch($sql, array(
            ':user_id'      => $user_id,
            ':following_id' => $following_id,
        ));

        if ($row['count'] !== '0') {
            return TRUE;
        }

        return FALSE;
    }
}
