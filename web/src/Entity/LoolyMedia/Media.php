<?php

namespace App\Entity\LoolyMedia;

use Looly\Media\Entity\Media as BaseMedia;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'media')]
class Media extends BaseMedia
{
    public function __toString() {
        return $this->getName();
    }

    public function getDesktop(): string
    {
        $file_path = $this->getFolder() . $this->getSlug() . '_desktop.webp';

        if(file_exists('/app/web/public/'.$file_path)) {
            return $file_path;
        }

        return '/' . $this->getFolder() . $this->getName();
    }
}