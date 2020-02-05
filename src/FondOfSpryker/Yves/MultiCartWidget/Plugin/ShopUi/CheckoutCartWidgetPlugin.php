<?php

namespace FondOfSpryker\Yves\MultiCartWidget\Plugin\ShopUi;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Kernel\PermissionAwareTrait;
use Spryker\Yves\Kernel\Widget\AbstractWidgetPlugin;

/**
 * @method \SprykerShop\Yves\MultiCartWidget\MultiCartWidgetFactory getFactory()
 */
class CheckoutCartWidgetPlugin extends AbstractWidgetPlugin implements CheckoutCartWidgetPluginInterface
{
    use PermissionAwareTrait;

    /**
     * @param int $cartQuantity
     *
     * @return void
     */
    public function initialize($cartQuantity): void
    {
        $this->addParameter('cartQuantity', $cartQuantity)
            ->addParameter('activeCart', $this->getActiveCart())
            ->addParameter('cartList', $this->getInActiveQuoteList())
            ->addParameter('isMultiCartAllowed', $this->isMultiCartAllowed())
            ->addWidgets($this->getFactory()->getViewExtendWidgetPlugins());
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public static function getName()
    {
        return static::NAME;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public static function getTemplate()
    {
        return '@MultiCartWidget/views/mini-cart/checkout-cart.twig';
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function getActiveCart(): QuoteTransfer
    {
        return $this->getFactory()->getMultiCartClient()->getDefaultCart();
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer[]
     */
    protected function getInActiveQuoteList(): array
    {
        $quoteCollectionTransfer = $this->getFactory()
            ->getMultiCartClient()
            ->getQuoteCollection();

        $inActiveQuoteTransferList = [];
        foreach ($quoteCollectionTransfer->getQuotes() as $quoteTransfer) {
            if (!$quoteTransfer->getIsDefault() && $this->can('ReadSharedCartPermissionPlugin', $quoteTransfer->getIdQuote())) {
                $inActiveQuoteTransferList[] = $quoteTransfer;
            }
        }

        return $inActiveQuoteTransferList;
    }

    /**
     * @return bool
     */
    protected function isMultiCartAllowed(): bool
    {
        return $this->getFactory()
            ->getMultiCartClient()
            ->isMultiCartAllowed();
    }
}
