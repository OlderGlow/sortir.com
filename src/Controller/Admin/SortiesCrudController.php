<?php

namespace App\Controller\Admin;

use App\Entity\Sorties;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SortiesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sorties::class;
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
