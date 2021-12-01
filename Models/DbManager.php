<?php

namespace Application\Models;

use DevNet\Entity\EntityContext;
use DevNet\Entity\EntityOptions;
use DevNet\System\Collections\ArrayList;
use DevNet\System\Linq;

class DbManager extends EntityContext
{
    public function __construct(EntityOptions $options)
    {
        parent::__construct($options);
    }
}
