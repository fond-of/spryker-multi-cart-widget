<?php

namespace FondOfSpryker\Yves\MultiCartWidget\Plugin\ShopUi;

use Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface;

interface CheckoutCartWidgetPluginInterface extends WidgetPluginInterface
{
    public const NAME = 'CheckoutCartWidgetPlugin';

    /**
     * @param int $cartQuantity
     *
     * @return void
     */
    public function initialize($cartQuantity): void;
}
