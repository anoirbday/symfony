<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 03/04/2018
 * Time: 19:21
 */

namespace BonPlanBundle\Entity;


class Mail
{
private $email;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}