<?php

namespace App\Controller\Admin;

use App\Entity\Lieux;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LieuxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lieux::class;
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
