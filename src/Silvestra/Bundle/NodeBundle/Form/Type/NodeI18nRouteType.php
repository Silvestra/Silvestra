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

use Silvestra\Bundle\FormBundle\Form\Type\KeyValueType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Silvestra\Bundle\NodeBundle\Form\DataTransformer\NodeI18nRouteTransformer;
use Silvestra\Bundle\NodeBundle\Validator\Constraints\NodeParentIsOnline;
use Tadcka\Bundle\RoutingBundle\Form\Type\RouteType;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  14.6.29 14.05
 */
class NodeI18nRouteType extends AbstractType
{
    /**
     * @var NodeI18nRouteTransformer
     */
    private $transformer;

    /**
     * @var string
     */
    private $nodeTranslationClass;

    /**
     * Constructor.
     *
     * @param NodeI18nRouteTransformer $transformer
     * @param string $nodeTranslationClass
     */
    public function __construct(NodeI18nRouteTransformer $transformer, $nodeTranslationClass)
    {
        $this->transformer = $transformer;
        $this->nodeTranslationClass = $nodeTranslationClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('route', RouteType::class, array('label' => false, 'translation_domain' => 'SilvestraNode'));

        if (false === empty($options['allowed_link_attributes'])) {
            $builder->add(
                'linkAttributes',
                KeyValueType::class,
                array(
                    'value_type' => 'text',
                    'allowed_keys' => array_combine(
                        $options['allowed_link_attributes'],
                        $options['allowed_link_attributes']
                    ),
                    'required' => false,
                    'label' => 'form.node_translation.link_attributes',
                )
            );
        }

        $builder->addModelTransformer($this->transformer);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->nodeTranslationClass,
                'translation_domain' => 'SilvestraNode',
                'constraints' => array(new NodeParentIsOnline()),
                'allowed_link_attributes' => array(),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'silvestra_node_i18n_route';
    }
}
