<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileFormType extends AbstractType
{
    /**
     * @var string
     */
    private $fileClass;

    /**
     * Constructor.
     *
     * @param string $fileClass
     */
    public function __construct($fileClass)
    {
        $this->fileClass = $fileClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->fileClass,
                'translation_domain' => 'SilvestraMediaBundle',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_media_file';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'file';
    }
}
