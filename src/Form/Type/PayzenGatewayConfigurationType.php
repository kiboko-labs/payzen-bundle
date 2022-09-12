<?php

namespace Kiboko\SyliusPayzenBundle\Form\Type;

use Ekyna\Component\Payum\Payzen\Api\Api;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PayzenGatewayConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site_id', TextType::class, [
                'label'       => 'sylius.form.gateway_configuration.payzen.site_id',
                'constraints' => [
                    new NotBlank(['groups' => ['sylius'],]),
                ],
            ])
            ->add('certificate', TextType::class, [
                'label'       => 'sylius.form.gateway_configuration.payzen.certificate',
                'constraints' => [
                    new NotBlank(['groups' => ['sylius'],]),
                ],
            ])
            ->add('ctx_mode', ChoiceType::class, [
                'label'       => 'sylius.form.gateway_configuration.payzen.ctx_mode.label',
                'choices'  => array(
                    'sylius.form.gateway_configuration.payzen.ctx_mode.choices.test' => Api::MODE_TEST,
                    'sylius.form.gateway_configuration.payzen.ctx_mode.choices.production' => Api::MODE_PRODUCTION,
                ),
            ])
        ;
    }
}
