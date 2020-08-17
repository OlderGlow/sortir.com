<?php


namespace App\Data;


use App\Entity\Campus;
use App\Entity\Sorties;
use phpDocumentor\Reflection\Types\Boolean;

class SearchData
{

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var null|Sorties
     */
    public $sortieOrganisateur;

    /**
     * @var null|Sorties
     */
    public $sortieInscrit;

    /**
     * @var null|Sorties
     */
    public $noInscrit;

    /**
     * @var null|Campus
     */
    public $campus;

    /**
     * @var \DateTime
     */
    public $dateStart;

    /**
     * @var \DateTime
     */
    public $dateEnd;
    /**
     * @var null|\DateTime
     */
    public $datePasse;


}