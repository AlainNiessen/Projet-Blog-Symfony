<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //création de champs avec type correspondant (exemple: type=text => TextType::class)
        $builder
            ->add('titre', TextType::class, array('help' => 'Veuillez introduire un titre pour le nouveau article'))
            ->add('contenu', TextType::class, array('help' => 'Veuillez introduire un contenu pour le nouveau article')) 
            //importer avec use pour pouvoir utiliser EntityType           
            ->add('category', EntityType::class, [
                // looks for choices from this entity Category
                'class' => Category::class,
                // uses the Category.name property as the visible option string
                'choice_label' => 'name',
                // used to render a select box, check boxes or radios
                'multiple' => false, // choice multiple true ou false
                'expanded' => false, //true => radio ou checkbox (selon multiple)
                'help' => 'Veuillez choisir une catégorie pour le nouveau article'
                ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
