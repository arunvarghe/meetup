<?php
declare(strict_types=1);

namespace Meetup\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class MatchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'search',
            SubmitType::class,
            [
                'attr' => [
                    'class' => 'btn btn-secondary mb-2'
                ]
            ]
        );
    }
}