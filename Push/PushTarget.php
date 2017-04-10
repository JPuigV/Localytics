<?php
/**
 * Created by PhpStorm.
 * User: puig
 * Date: 10/04/17
 * Time: 10:59
 */

namespace jpuig\LocalyticsBundle\Push;


class PushTarget
{
    private $type;
    private $id;
    private $criteria;

    public function __construct($type,$id = null,$criteria = null)
    {
        $this->type = $type;
        $this->id = $id;
        $this->criteria = $criteria;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getCriteria()
    {
        return $this->criteria;
    }



}