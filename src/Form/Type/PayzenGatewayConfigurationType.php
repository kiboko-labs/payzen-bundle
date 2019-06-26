<?php

namespace Kiboko\SyliusPayzenBundle\Form\Type;

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
                    new NotBlank(),
                ],
            ])
            ->add('certificate', TextType::class, [
                'label'       => 'sylius.form.gateway_configuration.payzen.certificate',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('ctx_mode', ChoiceType::class, [
                'label'       => 'sylius.form.gateway_configuration.payzen.ctx_mode',
                'choices'  => array(
                    'TEST' => 'TEST',
                    'PRODUCTION' => 'PRODUCTION',
                ),
            ])
            ->add('directory', TextType::class, [
                'label'       => 'sylius.form.gateway_configuration.payzen.directory',
            ])
            ->add('debug', ChoiceType::class, [
                'label'       => 'sylius.form.gateway_configuration.payzen.debug',
                'choices'  => array(
                    'Yes' => true,
                    'No' => false,
                ),
            ])
            ->add('n_times', ChoiceType::class, [
                'label'       => 'sylius.form.gateway_configuration.payzen.n_times',
                'choices'  => array(
                    'sylius.form.gateway_configuration.payzen.yes' => true,
                    'sylius.form.gateway_configuration.payzen.no' => false,
                ),
            ])
            ->add('count', TextType::class, [
                'label'       => 'sylius.form.gateway_configuration.payzen.count',
            ])
            ->add('period', TextType::class, [
                'label'       => 'sylius.form.gateway_configuration.payzen.period',
            ])
        ;
    }
}
