<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\TextBundle\Form\Handler;

use Silvestra\Component\Text\Model\Manager\TextManagerInterface;
use Silvestra\Component\Text\Model\TextInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class TextFormHandler
{
    /**
     * @var TextManagerInterface
     */
    private $textManager;

    /**
     * Constructor.
     *
     * @param TextManagerInterface $textManager
     */
    public function __construct(TextManagerInterface $textManager)
    {
        $this->textManager = $textManager;
    }

    /**
     * Process text.
     *
     * @param Request $request
     * @param FormInterface $form
     *
     * @return bool
     */
    public function process(Request $request, FormInterface $form)
    {
        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                /** @var TextInterface $text */
                $text = $form->getData();
                foreach ($text->getTranslations() as $translation) {
                    $translation->setText($text);
                }
                $this->textManager->add($form->getData());

                return true;
            }
        }

        return false;
    }
}
