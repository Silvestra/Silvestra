<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Image;

use Silvestra\Component\Media\Exception\InvalidImageConfigException;
use Silvestra\Component\Media\Image\Config\ImageConfigValidatorInterface;
use Silvestra\Component\Media\Image\Config\ImageDefaultConfig;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 7:52 PM
 */
class ImageValidator
{
    /**
     * @var array|ImageConfigValidatorInterface[]
     */
    private $configValidators = array();

    /**
     * @var ImageDefaultConfig
     */
    private $defaultConfig;

    /**
     * Constructor.
     *
     * @param ImageDefaultConfig $defaultConfig
     */
    public function __construct(ImageDefaultConfig $defaultConfig)
    {
        $this->defaultConfig = $defaultConfig;
    }


    /**
     * Add config validator.
     *
     * @param ImageConfigValidatorInterface $configValidator
     */
    public function addConfigValidator(ImageConfigValidatorInterface $configValidator)
    {
        $this->configValidators[] = $configValidator;
    }

    /**
     * Check if image config is valid.
     *
     * @param array $config
     *
     * @return bool
     *
     * @throws InvalidImageConfigException
     */
    public function isConfigValid(array $config)
    {
        $isValid = true;

        foreach ($this->configValidators as $configValidator) {
            $configName = $configValidator->getConfigName();

            if (!isset($config[$configName])) {
                throw new InvalidImageConfigException(sprintf('Invalid image config: %s', $configName));
            }

            $isValid = $isValid && $configValidator->validate($config[$configName], $this->defaultConfig);
        }

        return $isValid;
    }
}
