<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\ForgottenPasswordInput;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\ForgottenPassword;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ForgottenPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("email", EmailType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", ForgottenPasswordInput::class);
    }
}
