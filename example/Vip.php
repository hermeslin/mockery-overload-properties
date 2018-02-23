<?php
class Vip
{
    /**
     * check user is vip or not
     *
     * @return boolean is vip
     */
    public function bonus($userId)
    {
        $defaultBonus = 100;
        $user = new User($userId);

        if ($user->isVip) {
            $bonus = $defaultBonus * 2;
        }
        else {
            $bonus = $defaultBonus * 0.5 + $user->rank;
        }
    }
}