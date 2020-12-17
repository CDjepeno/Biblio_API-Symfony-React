<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookCrudController extends AbstractCrudController 
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            NumberField::new('year'),
            TextField::new('langue'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('genre'),
            AssociationField::new('author'),
            AssociationField::new('editor'),
        ];
    }
    
}
