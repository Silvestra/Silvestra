<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Silvestra\Bundle\NodeBundle\Form\DataTransformer\NodeI18nRedirectRouteTransformer;
use Silvestra\Bundle\NodeBundle\Validator\Constraints\NodeParentIsOnline;
use Tadcka\Component\Routing\Model\RouteInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/1/14 8:17 PM
 */
class NodeI18nRedirectRouteType extends AbstractType
{
    /**
     * @var NodeI18nRedirectRouteTransformer
     */
    private $transformer;

    /**
     * @var string
     */
    private $nodeTranslationClass;

    /**
     * Constructor.
     *
     * @param NodeI18nRedirectRouteTransformer $transformer
     * @param string $nodeTranslationClass
     */
    public function __construct(NodeI18nRedirectRouteTransformer $transformer, $nodeTranslationClass)
    {
        $this->transformer = $transformer;
        $this->nodeTranslationClass = $nodeTranslationClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('route', 'tadcka_route', array('label' => false, 'translation_domain' => 'TadckaSitemapBundle'));

        $builder->add('routeRedirect', 'tadcka_redirect_route', array('label' => false, 'mapped' => false, 'use_route_target' => false));

        $postSetDataListener = function (FormEvent $event) {
            $form = $event->getForm();
            /** @var RouteInterface $route */
            $route = $form->get('route')->getData();

            if ((null !== $route) && (null !== $redirectRouteName = $route->getDefault('redirectRouteName'))) {
                $form->get('routeRedirect')->setData($this->transformer->getRedirectRoute($redirectRouteName));
            }
        };
        $builder->addEventListener(FormEvents::POST_SET_DATA, $postSetDataListener);

        $submitListener = function (FormEvent $event) {
            $form = $event->getForm();

            $this->transformer->setRedirectRoute($form->get('routeRedirect')->getData());
        };
        $builder->addEventListener(FormEvents::SUBMIT, $submitListener);

        $builder->addModelTransformer($this->transformer);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->nodeTranslationClass,
                'translation_domain' => 'TadckaSitemapBundle',
                'constraints' => array(new NodeParentIsOnline()),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_node_node_i18n_redirect_route';
    }
}
