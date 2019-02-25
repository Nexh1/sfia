<?php

namespace App\Entity;

use App\Entity\SecteurActivite;
use PHPUnit\Framework\TestCase;


class SecteurActiviteTest extends TestCase
{
    public function testType()
    {
        $secteur = new SecteurActivite();
        $secteur->setNom('test');
        $result = $secteur->getNom();

        
        $this->assertInternalType('string', $result);
    }     
}
