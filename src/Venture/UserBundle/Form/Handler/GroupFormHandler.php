<?php

namespace Venture\UserBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\GroupFormHandler as BaseGroupFormHandler;

use FOS\UserBundle\Model\GroupInterface;

class GroupFormHandler extends BaseGroupFormHandler
{
    protected function onSuccess(GroupInterface $group)
    {
        $this->assignRole($group);
        $this->groupManager->updateGroup($group);
    }
    
    public function assignRole($group) {
        $name = $group->getName();
        $upperName = strtoupper($name);
        $removeSpclChars = preg_replace("/ /", "_", $upperName);
        
        $group->addRole("ROLE_{$removeSpclChars}");
    }
}
