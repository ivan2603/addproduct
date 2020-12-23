<?php

namespace Module\ProductLabel\Plugin\Magento\Quote\Model\Quote;

use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote\Item;
use Magento\Quote\Api\CartRepositoryInterface;

class ItemPlugin
{
    protected $checkoutSession;
    protected $cartRepository;

    public function __construct(
        Session $checkoutSession,
        CartRepositoryInterface $cartRepository
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->cartRepository = $cartRepository;
    }

    public function beforeSetQty(Item $subject, $result)
    {
        $productType = $subject->getProductType();
        $addingQty = (int)$subject->getData('qty_to_add');
        if ((int)$addingQty > 2) {
            throw new LocalizedException(__('Cannot added more than two products'));
        } else {
            $quoteId = $this->checkoutSession->getQuoteId();
            $quote = $this->cartRepository->get($quoteId);
            $itemsCount = (int)$quote->getItemsSummaryQty();
            if ($itemsCount > 0) {
                foreach ($quote->getAllVisibleItems() as $item) {
                    $itemsCount = (int)$quote->getItemsSummaryQty();
                    $itemType = $item->getProduct()->getTypeId();
                    if ($productType == $itemType) {
                        $itemsCount += $addingQty;
                    }
                }
                if ($itemsCount > 2) {
                    throw new LocalizedException(__('Cannot added more than two products with the same type'));
                }
            }
        }
        return [$result];
    }
}
