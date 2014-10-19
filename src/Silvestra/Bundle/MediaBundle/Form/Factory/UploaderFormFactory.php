<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\MediaBundle\Form\Factory;

use Silvestra\Component\Media\Model\FileInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

class UploaderFormFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     */
    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * Create uploader form.
     *
     * @param array|FileInterface[] $files
     *
     * @return FormInterface
     */
    public function create(array $files)
    {
        return $this->formFactory->create(
            'silvestra_media_uploader',
            $files,
            array(
                'action' => $this->router->getContext()->getPathInfo()
            )
        );
    }
}
