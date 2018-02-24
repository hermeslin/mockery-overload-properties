<?php
class User
{
    public $id;
    public $isVip;
    public $rank;

    /**
     * construct
     */
    public function __construct($id)
    {
        // some global static function
        $dbh = DB_INSTANCE::getCurrent();

        $sql = "
            SELECT id, isVip, rank
            FROM user
            WHERE id = :id
        ";

        $stm = $dbh->prepare($sql);
        $bind = $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $user = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = $user['id'];
        $this->isVip = $user['isVip'];
        $this->rank = $user['rank'];
    }
}