<?php

namespace App\Controller\Admin;

use App\Entity\Inscriptions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InscriptionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Inscriptions::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
