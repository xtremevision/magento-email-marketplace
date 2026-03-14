<?php

namespace Zitec\EmagMarketplace\Block\Adminhtml\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class AbstractButton
 * @package Zitec\EmagMarketplace\Block\Adminhtml\Mapping\Edit\Button
 */
abstract class AbstractButton implements ButtonProviderInterface
{
    /**
     * @var UrlInterface
     */
    protected $urlBuidler;

    /**
     * AbstractButton constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->urlBuidler = $context->getUrlBuilder();
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->urlBuidler->getUrl($route, $params);
    }

    /**
     * @return array
     */
    abstract public function getButtonData(): array;
}
