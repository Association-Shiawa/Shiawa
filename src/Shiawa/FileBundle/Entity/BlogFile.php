<?php

namespace Shiawa\FileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Shiawa\FileBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 *
 * @Vich\Uploadable
 */
class BlogFile extends File
{
    /**
     * @Vich\UploadableField(mapping="blog_file", fileNameProperty="filename")
     */
    protected $file;
}
