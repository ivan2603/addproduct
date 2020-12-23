<?php

namespace Module\ProductLabel\Plugin\Magento\Checkout\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;

class CartPlugin
{
    protected $checkoutSession;

    protected $messageManager;

    protected $productRepository;

    public function __construct(
        Session $checkoutSession,
        ManagerInterface $messageManager,
        ProductRepositoryInterface $productRepository
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
    }


    /*public function aroundAddProduct(Cart $subject, callable $proceed, $productInfo, $requestInfo = null)
    {
        $productType = $productInfo->getTypeId();
        try {
            $quote = $this->checkoutSession->getQuote();
            $itemsCount = (int)$quote->getItemsSummaryQty();
            if ($requestInfo['qty'] < 3) {
                if (empty($itemsCount)) {
                    return $proceed($productInfo, $requestInfo);
                } else {
                    $isSameType = 0;
                    foreach ($quote->getItemsCollection() as $item) {
                        $product = $item->getProduct();
                        if ($product->getData('type_id') == $productType) {
                            $isSameType = $itemsCount + $requestInfo['qty'];
                        }
                    }
                    if ($isSameType <= 2) {
                        return $proceed($productInfo, $requestInfo);
                    }
                    $this->messageManager->addErrorMessage(__('Cannot added more than two products with the same type'));
                    return $proceed();
                }
            }
        } catch (LocalizedException $e) {
            $e->getMessage();
        }
    }*/
}
