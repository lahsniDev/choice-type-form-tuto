<?php

namespace AppBundle\Form;


use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('category', ChoiceType::class, [
                'required' => true,
                'choices' => []
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-block btn-primary'
                ]
            ]);

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                // Get the parent form
                $form = $event->getForm();

                // Get the data for the choice field
                $categoryId = (int)$event->getData()['category'];

                // Collect the new choices

                $choices[] = $this->em->getRepository(Category::class)->find($categoryId);

                // Add the field again, with the new choices :
                
                $form->add('category', EntityType::class, [
                    'class' => Category::class,
                    'choices' => $choices
                ]);
            }
        );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}